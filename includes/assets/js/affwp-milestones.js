jQuery( document ).ready( function( $ ) {
	$( function() {
		for ( var i = 0; i < 100; i++ ) {
			$( '.affwp-milestones-notice' ).append( "<div class='balloon balloon" + i + "'></div>" );
		}
	} );
} );
