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
