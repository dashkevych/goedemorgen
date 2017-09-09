/**
 * Font family control.
 */
wp.customize.controlConstructor['font-family'] = wp.customize.Control.extend({
	ready: function () {
		var control = this;

		this.container.on( 'click', 'button.reset-font-family',
			function (e) {
				e.preventDefault();
				var defaultValue = jQuery( this ).data( 'default-value' );
				control.setting.set( defaultValue );
				control.container.find( 'select' ).val( defaultValue );
				wp.customize.previewer.refresh();
			}
		);

		this.container.on( 'change', 'select',
			function () {
				control.setting.set( jQuery( this ).val() );
				wp.customize.previewer.refresh();
			}
		);
	}
});

/**
 * Toggle switch control.
 */
 wp.customize.controlConstructor['toggle-switch'] = wp.customize.Control.extend({
 	ready: function () {
 		var control = this;

 		this.container.on( 'change',
 			function () {
				if ( jQuery( this ).find( '.toggle-switch-checkbox' ).is( ':checked' ) ) {
					var controlValue = 1;
				} else {
					var controlValue = 0;
				}
				
 				control.setting.set( controlValue );
 				wp.customize.previewer.refresh();
 			}
 		);
 	}
 });

/**
 * Checks that all controls and settings are loaded.
 */
wp.customize.bind( 'ready', function() {

	// Customize object alias.
    var customize = this;

	// Toggling visibility of the control(s) based on the "Blog View: Featured Page" option.
	customize( 'goedemorgen_settings[archive][featured_page_id]', function( setting ) {
		var setupControl = function( control ) {
			var setActiveState, isDisplayed;

			// Determinate if we want to show or hide the control.
			isDisplayed = function() {
				if (
					( 0 === setting.get() || '0' === setting.get() ) &&
					'page' !== customize.control( 'show_on_front' ).setting.get()
				) {
					return false;
				} else {
					return true;
				}
			};

			// Activate or deactivate a control.
			setActiveState = function() {
				control.active.set( isDisplayed() );
			};

			// Initial state of the control.
			setActiveState();

			// Toggling visibility of the control.
			control.active.validate = isDisplayed;
			setting.bind( setActiveState );
		};

		customize.control( 'goedemorgen_is_posts_page_header', setupControl );
	} );
} );
