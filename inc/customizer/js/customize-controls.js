/**
 * Font family control.
 */
wp.customize.controlConstructor['font-family'] = wp.customize.Control.extend({
	ready: function () {
		var control = this;
		var selectContainer = control.container.find( 'select' );
		var defaulValue = selectContainer.data( 'default' );

		this.container.on( 'click', 'button.goedemorgen-reset', function(e) {
			e.preventDefault();
			selectContainer.val( defaulValue ).change();
		});

		this.container.on( 'change', 'select', function () {
			control.setting.set( selectContainer.val() );
		});
	}
});

/**
 * Toggle switch control.
 */
 wp.customize.controlConstructor['toggle-switch'] = wp.customize.Control.extend({
 	ready: function () {
 		var control = this;

 		this.container.on( 'change', function() {
			if ( jQuery( this ).find( '.toggle-switch-checkbox' ).is( ':checked' ) ) {
				var controlValue = 1;
			} else {
				var controlValue = 0;
			}

			control.setting.set( controlValue );
			wp.customize.previewer.refresh();
 		});
 	}
 });

/**
 * Range Slider control.
 */
wp.customize.controlConstructor['goedemorgen-range-slider'] = wp.customize.Control.extend({
	ready: function () {
		var control = this;

		var rangeSlider = control.container.find( '.goedemorgen-slider' );
		var rangeInput = control.container.find( 'input.value' );
		var minValue = rangeSlider.data( 'min' );
		var maxValue = rangeSlider.data( 'max' );
		var selectedValue;
		var defaulValue = rangeInput.data( 'default' );

		// Set up range slider,
		rangeSlider.slider({
			value: rangeInput.val(),
			min: minValue,
			max: maxValue,
			step: rangeSlider.data( 'step' ),
			slide: function( event, ui ) {
				rangeInput.val( ui.value ).change();
			}
		});

		// Update range value based on the input value.
		this.container.on( 'input', 'input.value', function() {
			selectedValue = jQuery( this ).val();

			if ( selectedValue < minValue || selectedValue > maxValue ) {
				selectedValue = defaulValue;
			}

			rangeSlider.slider( 'value', parseFloat( selectedValue ) ).change();
		});

		// Reset button.
		this.container.on( 'click', 'button.goedemorgen-reset', function(e) {
			e.preventDefault();

			rangeInput.val( defaulValue ).change();
			rangeSlider.slider( 'value', parseFloat( defaulValue ) );
		});

		// Save the changes.
		this.container.on( 'change', function() {
 			control.saveRangeValue( rangeInput.val(), defaulValue, minValue, maxValue );
 		});
	},

	saveRangeValue: function( selected, defaultV, min, max ) {
		var control = this, notificationCode, notification;
		notificationCode = 'goedemorgen_range_input_not_allowed';

		if ( selected < min || selected > max ) {
			control.setting.notifications.add( notificationCode, new wp.customize.Notification(
                notificationCode,
                {
                    type: 'warning',
                    message: control.params.notificationWarning
                }
            ) );
        } else {
            control.setting.notifications.remove( notificationCode );
			control.setting.set( selected );
        }
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
