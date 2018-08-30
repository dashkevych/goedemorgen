"use strict";

/*
 Handles additional functionalities of the theme.
*/
(function() {

	var documentBody = jQuery( document.body );
	var browserWindow = jQuery( window );

	var goedemorgenTheme = {
		pageContainer: jQuery( document.getElementById( 'page' ) ),
		headerContainer: jQuery( document.getElementById( 'page' ) ).find( document.getElementById( 'masthead' ) ),
		contentContainer: jQuery( document.getElementById( 'page' ) ).find( document.getElementById( 'content' ) ),

		// Run on ready.
		onReady: function() {
			this.createResponsiveTables();
			this.skipLinkFocusFix();
			this.displayMobileMenu();
			this.displayHeaderSearchForm();
			this.addBackToTopButton();
		},

		// Add custom class to table element and make it responsive.
		createResponsiveTables: function() {
			jQuery( 'table' ).addClass( 'table' ).wrap( '<div class="table-responsive" />' );

			var infiniteCount, infiniteItems;
			infiniteCount = 0;

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
			var toggleMenu, mobileMenu, dropdownToggle, toggleMenuAction;

			toggleMenu = this.pageContainer.find( document.getElementById( 'toggle-menu' ) );
			this.headerContainer.find( '.menu:not(.social-menu)' ).clone().appendTo( '#mobile-navigation' );

			documentBody.on( 'click', '#mobile-menu-toggle, #close-toggle-menu', function( e ) {
				documentBody.toggleClass( 'toggle-mobile-menu' );
				toggleMenu.slideToggle( 'fast' );
			});

			mobileMenu = this.pageContainer.find( document.getElementById( 'mobile-navigation' ) );

			// Add dropdown toggle that displays child menu items.
			dropdownToggle = jQuery( '<button />', {
				'class': 'dropdown-toggle clean-button has-icon',
				'aria-expanded': false
			} ).append( jQuery( '<span />', {
				'class': 'screen-reader-text',
				text: goedemorgenScreenReaderText.expand
			} ) );

			mobileMenu.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );
			mobileMenu.find( '.current-menu-ancestor > button, .current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );
			mobileMenu.find( '.menu-item-has-children, .page_item_has_children' ).attr( 'aria-haspopup', 'true' );

			toggleMenuAction = function( e ) {
				var currentToggleElement = jQuery( this ),
					screenReaderSpan = currentToggleElement.find( '.screen-reader-text' );

				e.preventDefault();
				currentToggleElement.toggleClass( 'toggled-on' );
				currentToggleElement.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

				currentToggleElement.attr( 'aria-expanded', currentToggleElement.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

				screenReaderSpan.text( screenReaderSpan.text() === goedemorgenScreenReaderText.expand ? goedemorgenScreenReaderText.collapse : goedemorgenScreenReaderText.expand );
			}

			mobileMenu.on( 'click', '.dropdown-toggle', toggleMenuAction );
		},

		// Add Back to Top button functionality.
		addBackToTopButton: function() {
			var backToTopButton, buttonSettings;

			backToTopButton = jQuery( document.getElementById( 'backtotop-button' ) );
			buttonSettings = { opacity: '0', visibility: 'hidden' };

			browserWindow.scroll( function() {
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
		},

		// Helps with accessibility for keyboard only users.
		skipLinkFocusFix: function() {
			var isIe = /(trident|msie)/i.test( navigator.userAgent );

			if ( isIe && document.getElementById && window.addEventListener ) {
				window.addEventListener( 'hashchange', function() {
					var id = location.hash.substring( 1 ),
						element;

					if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
						return;
					}

					element = document.getElementById( id );

					if ( element ) {
						if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
							element.tabIndex = -1;
						}

						element.focus();
					}
				}, false );
			}
		}
	};

	// Things that need to happen when the document is ready.
	jQuery( function() {
		goedemorgenTheme.onReady();
	});
})();
