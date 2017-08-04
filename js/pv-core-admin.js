(function($, w) {
	'use strict';

	$(
		function() {

			// tabs
			var $tabBoxes = $( '.pv-metaboxes' ),
			$navTabWrapper = $( '.nav-tab-wrapper' ),
			$navTab = $( '.nav-tab' ),
			$tabLinkActive,
			$currentTab,
			$currentTabLink,
			$tabContent,
			$hash;

			// Tabs on load
			if ((w.location.hash).length) {
				$hash = w.location.hash;
				$tabBoxes.addClass( 'hidden' );
				$currentTab = $( $hash ).toggleClass( 'hidden' );
				$navTab.removeClass( 'nav-tab-active' );
				$( '.nav-tab[href=' + $hash + ']' ).addClass( 'nav-tab-active' );
			}

			// Tabs on click
			$navTabWrapper.on(
				'click', 'a', function(e){
					var $this = $( this );
					e.preventDefault();
					$tabContent = $this.attr( 'href' );
					$navTab.removeClass( 'nav-tab-active' );
					$tabBoxes.addClass( 'hidden' );
					$currentTab = $( $tabContent ).toggleClass( 'hidden' );
					$this.addClass( 'nav-tab-active' );
					if (history.pushState) {
						history.pushState( null, null, $tabContent );
					} else {
						location.hash = $tabContent;
					}
				}
			)

		}
	);

})(jQuery, window);
