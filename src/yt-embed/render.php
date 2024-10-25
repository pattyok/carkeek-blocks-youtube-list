<?php
/** Layout template for the youtube embeds */

$number = 'carousel' === $attributes['displayAs'] && 'edit' === $attributes['context'] ? $attributes['columns'] : $attributes['postsPerPage'];

$args = array(
	'numberposts' => $number,
	'post_type'   => 'yt_embed',
	'order'       => $attributes['order'],
	'post_status' => 'publish',
	'orderby'     => $attributes['sortBy'],
);

if ( ! empty( $attributes['taxTermsSelected'] ) ) {
	$args['tax_query'] = array(
		'relation' => 'AND',
		array(
			'taxonomy' => 'embed_cat',
			'field'    => 'term_id',
			'terms'    => explode( ',', $attributes['taxTermsSelected'] ),
		),
	);
}

$embeds     = get_posts( $args );
$data_attrs = '';
if ( $attributes['displayAs'] == 'grid' || $attributes['context'] == 'edit' ) {
	$wrapper_classes = 'ck-columns-grid has-' . $attributes['columns'] . '-columns has-' . $attributes['columnsTablet'] . '-columns-tablet has-' . $attributes['columnsMobile'] . '-columns-mobile';
} else {
	$wrapper_classes = 'slider-carousel';
	$data_attrs      = 'data-slick=\'{ "slidesToShow": ' . $attributes['columns'] . ', "slidesToScroll": ' . $attributes['columns'] . ', "responsive": [ { "breakpoint": 1024, "settings": { "slidesToShow": ' . $attributes['columnsTablet'] . ', "slidesToScroll": ' . $attributes['columnsTablet'] . ' } }, { "breakpoint": 600, "settings": { "slidesToShow": ' . $attributes['columnsMobile'] . ', "slidesToScroll": ' . $attributes['columnsMobile'] . ' } } ] }\'';
}

?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => $wrapper_classes ) ); ?> <?php echo $data_attrs; ?>>
 <?php
	foreach ( $embeds as $embed ) {

		$yt_uri    = get_field( 'yt_embed_oembed', $embed->ID, false );
		$yt_id = '';
		$host = wp_parse_url( $yt_uri, PHP_URL_HOST );

		/* Handle Shortlinks */
		if ( 'youtu.be' === $host ) {
			$yt_id = ltrim( wp_parse_url( $yt_uri, PHP_URL_PATH ), '/' );
		}

		$params = wp_parse_url( $yt_uri, PHP_URL_QUERY );
		parse_str( $params, $query );
		$yt_id = $query['v'] ?? '';


		$description = get_field( 'yt_embed_description', $embed->ID );
		if ( ! empty( $description ) ) {
			$description = '<div class="embed-description">' . $description . '</div>';
		}

		if ( ! empty( $yt_id ) ) {
			?>
			<div class="yt-embed"><lite-youtube
				videotitle="<?php echo esc_html( $embed->post_title ); ?>"
				videoid="<?php echo esc_attr( $yt_id ); ?>"
			></lite-youtube>
			<?php if ( true === $attributes['showTitle'] ) : ?>

					<p class="embed-title"><?php echo esc_html( $embed->post_title ); ?></p>
			<?php endif; ?>
			<?php if ( true === $attributes['showDescription'] ) : ?>
				<?php echo wp_kses_post( $description ); ?>
			<?php endif; ?>
					</div>

			<?php
		}
	}
	?>
</div>
