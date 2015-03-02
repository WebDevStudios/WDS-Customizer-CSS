( function( $ ) {
	wp.customize( 'wds_custom_css', function( value ) {
	value.bind( function( $new_styles ) {
		$('#wds-customizer-css').html( $new_styles );
	} );
} );

} )( jQuery );
