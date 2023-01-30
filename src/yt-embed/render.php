<?php
/** Layout template for the youtube embeds */

$number = 'carousel' === $attributes['displayAs'] && 'edit' === $attributes['context'] ? $attributes['columns'] : -1;

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
if ( $attributes['displayAs'] == 'grid' || $attributes['context'] == 'edit') {
	$wrapper_classes = 'ck-columns-grid has-' . $attributes['columns'] . '-columns has-' . $attributes['columnsTablet'] . '-columns-tablet has-' . $attributes['columnsMobile'] . '-columns-mobile';
} else {
	$wrapper_classes = 'slider-carousel';
	$data_attrs      = 'data-slick=\'{ "slidesToShow": ' . $attributes['columns'] . ', "slidesToScroll": ' . $attributes['columns'] . ', "responsive": [ { "breakpoint": 1024, "settings": { "slidesToShow": ' . $attributes['columnsTablet'] . ', "slidesToScroll": ' . $attributes['columnsTablet'] . ' } }, { "breakpoint": 600, "settings": { "slidesToShow": ' . $attributes['columnsMobile'] . ', "slidesToScroll": ' . $attributes['columnsMobile'] . ' } } ] }\'';
}

?>
<div <?php echo get_block_wrapper_attributes( array( 'class' => $wrapper_classes ) ); ?> <?php echo $data_attrs; ?>>
 <?php
	foreach ( $embeds as $embed ) {

		$yt    = get_field( 'yt_embed_oembed', $embed->ID, false );
		$yt_id = '';
		if ( strpos( $yt, 'youtu.be' ) !== false ) {
			$yt    = explode( '/', $yt );
			$yt_id = end( $yt );
		} else {
			$yt    = explode( 'v=', $yt );
			$yt_id = $yt[1];
		}
		$description = get_field( 'yt_embed_description', $embed->ID );
		if ( ! empty( $description ) ) {
			$description = '<div class="embed-description">' . $description . '</div>';
		}

		if ( ! empty( $yt_id ) ) {

			echo '<div class="yt-embed"><lite-youtube
						videotitle="' . $embed->post_title . '"
						videoid="' . $yt_id . '"
					></lite-youtube>
					<p class="embed-title">' . $embed->post_title . '</p>' . $description . '
					</div>';


		}
	}
	?>
</div>
