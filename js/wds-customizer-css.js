( function( $ ) {
	wp.customize( 'wds_custom_css', function( value ) {
	value.bind( function( $new_styles ) {
		console.log( $new_styles);
		$('#wds-custom-css').html( $new_styles );
	} );
} );

} )( jQuery );
