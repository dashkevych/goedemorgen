"use strict";

/*
 Handles additional functionalities of the theme.
*/

(function(){

	var goedemorgenTheme = {
		pageContainer: jQuery( document.getElementById( 'page' ) ),
		headerContainer: jQuery( document.getElementById( 'page' ) ).find( document.getElementById( 'masthead' ) ),
		contentContainer: jQuery( document.getElementById( 'page' ) ).find( document.getElementById( 'content' ) ),

		getDocumentBody: function() {
			return jQuery( document.body );
		},

		getBrowserWindow: function() {
			return jQuery( window );
		},

		// Run on ready.
		onReady: function() {
			this.createResponsiveTables();
		},

		// Run on load.
		onLoad: function() {
			this.displayMobileMenu();
			this.displayHeaderSearchForm();
			this.addBackToTopButton();
		},

		// Add custom class to table element and make it responsive.
		createResponsiveTables: function() {
			jQuery( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );

			var infiniteCount, infiniteItems, documentBody;

			infiniteCount = 0;
			documentBody = this.getDocumentBody();

			documentBody.on( 'post-load', function() {

				infiniteCount = infiniteCount + 1;

				infiniteItems = jQuery( '.infinite-wrap.infinite-view-' + infiniteCount );
				infiniteItems.find( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );
			});
		},

		// Create a header search form.
		displayHeaderSearchForm: function() {
			this.headerContainer.on( 'click', '#header-search-button', function(e) {
				e.preventDefault();
				jQuery( this ).closest( '.main-navigation' ).toggleClass( 'active-search-form' );
			});
		},

		// Create a mobile menu.
		displayMobileMenu: function() {
			var toggleMenu = this.pageContainer.find( document.getElementById( 'toggle-menu' ) );
			var documentBody = this.getDocumentBody();
			this.headerContainer.find( '.menu:not(.social-menu)' ).clone().appendTo( '#mobile-navigation' );

			documentBody.on( 'click', '#mobile-menu-toggle, #close-toggle-menu', function(e) {
				documentBody.toggleClass( 'toggle-mobile-menu' );
				toggleMenu.slideToggle( 'fast' );
			});
		},

		// Add Back to Top button functionality.
		addBackToTopButton: function() {
			var backToTopButton, buttonSettings, browserWindow;

			backToTopButton = jQuery( document.getElementById( 'backtotop-button' ) );
			buttonSettings = { opacity: '0', visibility: 'hidden' };
			browserWindow = this.getBrowserWindow();

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
		}
	};

	// Things that need to happen when the document is ready.
	jQuery(function() {
		goedemorgenTheme.onReady();
	});

	// Things that need to happen after a full load.
	jQuery( window ).on( 'load', function() {
		goedemorgenTheme.onLoad();
	});
})();
