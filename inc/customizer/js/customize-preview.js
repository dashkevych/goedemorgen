jQuery( document ).ready(function () {
	/**
	 * Theme Customizer enhancements for a better user experience.
	 *
	 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
	 */

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			jQuery( '.site-title a' ).text( to );
		});
	});

	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			jQuery( '.site-description' ).text( to );
		});
	});

	// Jumbotron content alignment.
	wp.customize( 'goedemorgen_settings[jumbotron][alignment]', function( value ) {
		var jumbotronSection = jQuery( '#jumbotron-section' );
		value.bind( function( option ) {
			switch( option ) {
			    case 'right':
					jumbotronSection.removeClass( 'centered-alignment' );
					jumbotronSection.addClass( 'right-alignment' );
			        break;
			    case 'center':
					jumbotronSection.removeClass( 'right-alignment' );
					jumbotronSection.addClass( 'centered-alignment' );
			        break;
			    default:
			        jumbotronSection.removeClass( 'centered-alignment right-alignment' );
			}
		});
	});

	// Typography: body font size.
	wp.customize( 'goedemorgen_settings[typography][body][font_size]', function( value ) {
		value.bind( function( to ) {
			document.getElementsByTagName('html')[0].style.fontSize = to + 'px';
		});
	});
});
