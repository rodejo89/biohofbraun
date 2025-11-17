<?php
/**
 * Replace last instance of search from a given string
 *
 * @param string $search String to search for.
 * @param string $replace String to replace with.
 * @param string $subject Subject.
 * @return string
 */
function str_replace_last( $search, $replace, $subject ) {
	if ( ( $pos = strrpos( $subject, $search ) ) !== false ) { // phpcs:ignore
		$search_length = strlen( $search );
		$subject       = substr_replace( $subject, $replace, $pos, $search_length );
	}
	return $subject;
}

/**
 * Enqueue scripts for query carousel block
 *
 * @return void
 */
function query_carousel_block_scripts() {
	// Splide JS.
	wp_enqueue_script( 'splide', '//cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js', array(), null, true );
	
	// Splide CSS.
	wp_enqueue_style( 'splide', '//cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css', array(), null );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\query_carousel_block_scripts' );

/**
 * Initialize query carousel block
 *
 * @return void
 */
function query_carousel_block_init() {
	?>
	<script>
		document.addEventListener( 'DOMContentLoaded', function() {
			var splide = new Splide( '.splide.is-style-carousel', {
				type: '',
				perPage: 4,
				perMove: 1,
				gap: 25,
				pagination: false,
				breakpoints: {
					'640': {
						perPage: 1,
					},
					'1024': {
						perPage: 2,
					},
				},
			} );
			splide.mount();
		} );
	</script>
	<?php
}
add_action( 'wp_footer', __NAMESPACE__ . '\query_carousel_block_init' );

/**
 * Add Splide markup to query carousel
 *
 * @param string $block_content Block content.
 * @param array  $block Block object.
 * @return string
 */
function query_carousel_block( $block_content, $block ) {
	$is_carousel = false !== strpos( $block['attrs']['className'] ?? '', 'is-style-carousel' );

	if ( $is_carousel ) {
		$block_content = preg_replace( '/is\-style\-carousel/', 'is-style-carousel splide', $block_content, 1 );
		$block_content = preg_replace( '/wp\-block\-post\-template/', 'wp-block-post-template splide__list', $block_content, 1 );
		$block_content = preg_replace( '/\<ul/', '<div class="splide__track"><ul', $block_content, 1 );
		$block_content = str_replace_last( '</ul>', '</ul></div>', $block_content );
		$block_content = preg_replace( '/wp\-block\-post\s/', 'wp-block-post splide__slide ', $block_content );
	}

	return $block_content;
}
add_filter( 'render_block_core/query', __NAMESPACE__ . '\query_carousel_block', 10, 2 );

