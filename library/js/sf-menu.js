/**
 * Enable superfish on larger screens, but only if it exists
 * 
 * See @link{http://stackoverflow.com/questions/6748301/disable-superfish-on-resize-event}
 */
( function( $ ) {
   var body = $( 'body' );
   var breakpoint = parseInt( deciduousOptions.mobileMenuBreakpoint );
   var sf = $( 'ul.sf-menu' );
   
   // only activate superfish if scripts are loaded
   if( typeof( sf.superfish ) === 'function' ) {

   	if( body.width() >= breakpoint ) {
   		
   		// enable superfish when the page first loads if we're on desktop
   		sf.superfish({ 
   			animation:    deciduousOptions['superfish'].animation, 
   			hoverClass:   deciduousOptions['superfish'].hoverClass,
   			pathClass:    deciduousOptions['superfish'].pathClass,
   			pathLevels:   parseInt( deciduousOptions['superfish'].pathLevels ),
   			delay:        parseInt( deciduousOptions['superfish'].delay ),
   			speed:        deciduousOptions['superfish'].speed,
   			cssArrows:    deciduousOptions['superfish'].cssArrows,
   			disableHI:    deciduousOptions['superfish'].disableHI
   		});
   	}

   	$( window ).resize( function() {
   		if( body.width() >= breakpoint && !sf.hasClass('sf-js-enabled') ) {
   			// you only want SuperFish to be re-enabled once (sf.hasClass)
   			sf.superfish( 'init' );
   		} else if( body.width() < breakpoint ) {
   			// smaller screen, disable SuperFish
   			sf.superfish( 'destroy' );
   		}
   	});
   }
} )( jQuery );