"use strict";

/*
 Handles additional functionalities of the theme.
*/
(function() {
	var goedemorgenTheme = {
		// Run on ready.
		onReady: function() {
			this.createResponsiveTables();
			this.displayMobileMenu();
			this.displayHeaderSearchForm();
			this.addBackToTopButton();
			this.skipLinkFocusFix();
			this.requestAnimationFramePolyfill();
		},

		// Add custom class to table element and make it responsive.
		createResponsiveTables: function() {
			var setUpResponsiveTables = function( container ) {
			    var tables = container.getElementsByTagName( 'table' );

			    if ( tables.length ) {
			        for ( var i = 0; i < tables.length; i++ ) {
			            goedemorgenTheme.addClass( tables[i], 'table' );

			            var originalHTML = tables[i].outerHTML;
			            tables[i].outerHTML = '<div class="table-responsive">' + originalHTML + '</div>';
			        }
			    }
			};

			setUpResponsiveTables( document.getElementById( 'page' ) );

			var mainContainer = document.getElementById( 'main' );

			if ( null == mainContainer ) {
				return;
			}

			var counter = 0;

			var responsiveTableLoadEvent = function() {
				var loader = mainContainer.querySelectorAll( '.infinite-loader' )[counter];

				if ( ! loader ) {
					return;
				}

				var nextElement = loader.nextSibling;

				do {
					if ( null != nextElement && 1 === nextElement.nodeType ) {
						setUpResponsiveTables( nextElement );
					}

					nextElement = nextElement.nextSibling;
				} while ( nextElement );

				counter++;
			};

			jQuery( document.body ).on( 'post-load', responsiveTableLoadEvent );
		},

		// Create a header search form.
		displayHeaderSearchForm: function() {
			var searchButtonEvent = function(e) {
				e.preventDefault();
				goedemorgenTheme.toggleClass( document.getElementById( 'site-navigation' ), 'active-search-form' );
			};

			document.getElementById( 'header-search-button' ).addEventListener( 'click', searchButtonEvent, false );
		},

		// Create a mobile menu.
		displayMobileMenu: function() {
			var toggleMenu = document.getElementById( 'toggle-menu' );
			var mobileMenuContainer = document.getElementById( 'mobile-navigation' );
			var primaryMenu = document.getElementById( 'site-navigation' ).querySelector( '.menu' ).cloneNode( true );
			primaryMenu.removeAttribute( 'id' );
			mobileMenuContainer.insertBefore( primaryMenu, mobileMenuContainer.firstChild );

			var toggleMobileMenuEvent = function() {
				goedemorgenTheme.toggleClass( document.body, 'toggle-mobile-menu' );
				goedemorgenTheme.toggleClass( toggleMenu, 'visible' );

				if ( -1 !== toggleMenu.className.indexOf( 'visible' ) ) {
					toggleMenu.setAttribute( 'aria-hidden', false );
				} else {
					toggleMenu.setAttribute( 'aria-hidden', true );
				}
			};
			document.getElementById( 'mobile-menu-toggle' ).addEventListener( 'click', toggleMobileMenuEvent, false );
			document.getElementById( 'close-toggle-menu' ).addEventListener( 'click', toggleMobileMenuEvent, false );

			// Add dropdown toggle that displays child menu items.
			var parentMenuItems = mobileMenuContainer.querySelectorAll( '.menu-item-has-children' );

			if ( parentMenuItems.length ) {
				for ( var i = 0; i < parentMenuItems.length; i++ ) {
					var buttonScreenReaderText = document.createElement( 'span' );
					buttonScreenReaderText.className = 'screen-reader-text';
					buttonScreenReaderText.appendChild( document.createTextNode( goedemorgenScreenReaderText.expand ) );

					var dropdownToggle = document.createElement( 'button' );
					dropdownToggle.className = 'dropdown-toggle clean-button has-icon';
					dropdownToggle.setAttribute( 'aria-expanded', false );
					dropdownToggle.appendChild( buttonScreenReaderText );

					parentMenuItems[i].appendChild( dropdownToggle );
					parentMenuItems[i].setAttribute( 'aria-haspopup', true );
				}
			}

			// Toggle buttons and submenu items with active children menu items.
			var activeToggleButtons = mobileMenuContainer.querySelectorAll( '.current-menu-ancestor > button' );
			var activeToggleSubMenus = mobileMenuContainer.querySelectorAll( '.current-menu-ancestor > .sub-menu' );

			if ( activeToggleButtons.length ) {
			    for ( var i = 0; i < activeToggleButtons.length; i++ ) {
			        goedemorgenTheme.addClass( activeToggleButtons[i], 'toggled-on' );
			        activeToggleButtons[i].setAttribute( 'aria-expanded', true );
			    }
			}

			if ( activeToggleSubMenus.length ) {
			    for ( var i = 0; i < activeToggleSubMenus.length; i++ ) {
			        goedemorgenTheme.addClass( activeToggleSubMenus[i], 'toggled-on' );
			    }
			}

			var dropdownToggleButtons = mobileMenuContainer.getElementsByTagName( 'button' );

			if ( dropdownToggleButtons.length ) {
				var dropdownToggleEvent = function(e) {
					e.preventDefault();

					var screenReader = e.target.querySelector( '.screen-reader-texty' );

					if ( -1 !== e.target.className.indexOf( 'toggled-on' ) ) {
						e.target.setAttribute( 'aria-expanded', false );

						if ( null != screenReader ) {
							screenReader.textContent = goedemorgenScreenReaderText.collapse;
						}
					} else {
						e.target.setAttribute( 'aria-expanded', true );

						if ( null != screenReader ) {
							screenReader.textContent = goedemorgenScreenReaderText.expand;
						}
					}

					goedemorgenTheme.toggleClass( e.target, 'toggled-on' );

					var parentItem = e.target.parentNode;

					for ( var i = 0; i < parentItem.childNodes.length; i++ ) {
						if ( 'UL' === parentItem.childNodes[i].nodeName ) {
							goedemorgenTheme.toggleClass( parentItem.childNodes[i], 'toggled-on' );
							break;
						}
					}
				};

				for ( var i = 0; i < dropdownToggleButtons.length; i++ ) {
					dropdownToggleButtons[i].addEventListener( 'click', dropdownToggleEvent, false );
				}
			}
		},

		// Add Back to Top button functionality.
		addBackToTopButton: function() {
			var backToTopButton = document.getElementById( 'backtotop-button' );

			if ( null == backToTopButton ) {
				return;
			}

			var setButtonStyles = function() {
				var scrollTop = window.scrollY || document.documentElement.scrollTop;

				if ( scrollTop > 300 ) {
			        backToTopButton.style.opacity = '1';
			        backToTopButton.style.visibility = 'visible';
			    } else {
			        backToTopButton.style.opacity = '0';
			        backToTopButton.style.visibility = 'hidden';
			    }
			};

			var scrollEvent = function(e) {
				window.requestAnimationFrame( setButtonStyles );
			};
			window.addEventListener( 'scroll', scrollEvent, false );

			var scrollToTop = function() {
				var scrollTop = window.scrollY || document.documentElement.scrollTop;

				if ( scrollTop > 0 ) {
					window.requestAnimationFrame( scrollToTop );
					window.scrollTo( 0, Math.floor( scrollTop - scrollTop / 2 ) ) ;
				}
			};

			var buttonEvent = function(e) {
				e.preventDefault();
				scrollToTop();
			};
			backToTopButton.addEventListener( 'click', buttonEvent, false );
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
		},

		// Create requestAnimationFrame polyfill (by Erik Möller, Paul Irish and Tino Zijdel).
		requestAnimationFramePolyfill: function() {
			var x, lastTime, vendors;

			lastTime = 0;
    		vendors = ['webkit', 'moz'];

			for( x = 0; x < vendors.length && ! window.requestAnimationFrame; ++x ) {
				window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
				window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame']
											|| window[vendors[x]+'CancelRequestAnimationFrame'];
			}

			if ( ! window.requestAnimationFrame ) {
				window.requestAnimationFrame = function( callback, element ) {
		 		   var currTime = new Date().getTime();
		 		   var timeToCall = Math.max( 0, 16 - ( currTime - lastTime ) );
		 		   var id = window.setTimeout( function() {
					   callback( currTime + timeToCall );
				   }, timeToCall );

		 		   lastTime = currTime + timeToCall;

		 		   return id;
		 	   };
			}

			if ( ! window.cancelAnimationFrame ) {
				window.cancelAnimationFrame = function( id ) {
		            clearTimeout( id );
		        };
			}
		},

		// Add a class to the element.
		addClass: function( element, className ) {
			if ( element.classList ) {
				element.classList.add( className );
			} else {
				element.className += ' ' + className;
			}
		},

		// Remove a class from the element.
		removeClass: function( element, className ) {
			if ( element.classList ) {
				element.classList.remove( className );
			} else {
				element.className = element.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
			}
		},

		// Toggle a class of the element.
		toggleClass: function( element, className ) {
			if ( -1 !== element.className.indexOf( className ) ) {
				goedemorgenTheme.removeClass( element, className );
			} else {
				goedemorgenTheme.addClass( element, className );
			}
		}
	};

	// Things that need to happen when the document is ready.
	jQuery( function() {
		goedemorgenTheme.onReady();
	});
})();
