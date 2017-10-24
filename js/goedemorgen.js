jQuery( document ).ready( function() {
	var documentBody = jQuery( document.body );
	var browserWindow = jQuery( window );
	var pageContainer = jQuery( document.getElementById( 'page' ) );
	var headerContainer = pageContainer.find( document.getElementById( 'masthead' ) );
	var contentContainer = pageContainer.find( document.getElementById( 'content' ) );

	// Add custom class to table element and make it responsive.
	jQuery( function() {
		jQuery( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );

		var infiniteCount = 0;

		documentBody.on( 'post-load', function() {

			infiniteCount = infiniteCount + 1;

			var infiniteItems = jQuery( '.infinite-wrap.infinite-view-' + infiniteCount );
			infiniteItems.find( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );
		});
	});

	// Header search form.
	jQuery( function() {
		headerContainer.on( 'click', '#header-search-button', function(e) {
			e.preventDefault();
			jQuery( this ).closest( '.main-navigation' ).toggleClass( 'active-search-form' );
		});
	});

	// Mobile Menu.
	jQuery( function() {
		var toggleMenu = pageContainer.find( document.getElementById( 'toggle-menu' ) );
		headerContainer.find( '.menu:not(.social-menu)' ).clone().appendTo( '#mobile-navigation' );

		documentBody.on( 'click', '#mobile-menu-toggle, #close-toggle-menu', function(e) {
			documentBody.toggleClass( 'toggle-mobile-menu' );
			toggleMenu.slideToggle( 'fast' );
		});
	});

	// Back to Top button.
	jQuery( function() {
		var backToTopButton = jQuery( '#backtotop-button' );
		var buttonSettings = { opacity: '0', visibility: 'hidden' };

		browserWindow.scroll(function() {
			if ( browserWindow.scrollTop() > 300 ) {
				buttonSettings.opacity = 1;
				buttonSettings.visibility = 'visible';
			} else {
				buttonSettings.opacity = 0;
				buttonSettings.visibility = 'hidden';
			}

			backToTopButton.css({
				'opacity': buttonSettings.opacity,
				'visibility': buttonSettings.visibility
			});
		});

		backToTopButton.on( 'click', function( e ) {
			e.preventDefault();

			jQuery( 'html, body' ).animate({
				scrollTop: 0
			}, 200);
		});
	});
});
