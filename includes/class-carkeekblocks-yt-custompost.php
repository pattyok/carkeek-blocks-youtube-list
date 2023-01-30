<?php
/**
 * Load assets for our blocks.
 *
 * @package CarkeekSiteBlocks
 * @author  Patty O'Hara
 * @Embed    https://carkeekstudios.com
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load general assets for our blocks.
 *
 * @since 1.0.0
 */
class CarkeekBlocksYT_CustomPost {


	/**
	 * This plugin's instance.
	 *
	 * @var CarkeekBlocksYT_CustomPost
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new CarkeekBlocksYT_CustomPost();
		}
	}

	/**
	 * The Plugin slug.
	 *
	 * @var string $slug
	 */
	private $slug;

	/**
	 * The base URL path (without trailing slash).
	 *
	 * @var string $url
	 */
	private $url;

	/**
	 * The Plugin version.
	 *
	 * @var string $version
	 */
	private $version;

	/**
	 * The Constructor.
	 */

	/**
	 * The Constructor.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'carkeek_blocks_register_customEmbeds' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'json_load_point' ) );
	}
	/**
	 * Register post type - TODO Admin Screen whether to activate or not
	 */
	public function carkeek_blocks_register_customEmbeds() {
		if ( ! post_type_exists( 'yt_embed' ) ) {
			$labels = array(
				'name'                  => _x( 'YouTube Embeds', 'Post Type General Name', 'text_domain' ),
				'singular_name'         => _x( 'YouTube Embed', 'Post Type Singular Name', 'text_domain' ),
				'menu_name'             => __( 'YouTube Embed', 'text_domain' ),
				'name_admin_bar'        => __( 'YouTube Embed', 'text_domain' ),
				'archives'              => __( 'Embed Archives', 'text_domain' ),
				'attributes'            => __( 'Embed Attributes', 'text_domain' ),
				'parent_item_colon'     => __( 'Parent Embed:', 'text_domain' ),
				'all_items'             => __( 'All Embeds', 'text_domain' ),
				'add_new_item'          => __( 'Add New Embed', 'text_domain' ),
				'add_new'               => __( 'Add New', 'text_domain' ),
				'new_item'              => __( 'New Embed', 'text_domain' ),
				'edit_item'             => __( 'Edit Embed', 'text_domain' ),
				'update_item'           => __( 'Update Embed', 'text_domain' ),
				'view_item'             => __( 'View Embed', 'text_domain' ),
				'view_items'            => __( 'View Embeds', 'text_domain' ),
				'search_items'          => __( 'Search Embed', 'text_domain' ),
				'not_found'             => __( 'Not found', 'text_domain' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
				'featured_image'        => __( 'Featured Image', 'text_domain' ),
				'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
				'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
				'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
				'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
				'items_list'            => __( 'Embeds list', 'text_domain' ),
				'items_list_navigation' => __( 'Embeds list navigation', 'text_domain' ),
				'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
			);

			$args      = array(
				'label'               => __( 'YouTube Embed', 'wp-rig' ),
				'description'         => __( 'Add YouTube Embeds to create dynamic lists of Embeds', 'wp-rig' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'page-attributes' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 10,
				'menu_icon'           => 'dashicons-video-alt3',
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'show_in_rest'        => true,
				'rest_base'           => 'yt-embeds',
			);
			$post_type = register_post_type( 'yt_embed', $args );
		}

		$labels = array(
			'name'          => _x( 'Embed Categories', 'Taxonomy General Name', 'wp-rig' ),
			'singular_name' => _x( 'Embed Category', 'Taxonomy Singular Name', 'wp-rig' ),
			'menu_name'     => __( 'Embed Categories', 'wp-rig' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_in_rest'      => true,
		);
		register_taxonomy( 'embed_cat', array( 'yt_embed' ), $args );

	}


	/** load our acf-json for the YouTube Embeds */
	function json_load_point( $paths ) {

		// append path
		$paths[] = plugin_dir_path( __DIR__ ) . 'acf-json';
		// return
		return $paths;

	}


	/**
	 * Make accordion panel
	 *
	 * @param string $header header content for the panel.
	 * @param string $content main content for the panel.
	 */
	public static function make_accordion_panel( $header, $content ) {

		$panel = '<div data-aria-accordion data-transition data-multi><div class="ck-custom-list-label" data-aria-accordion-heading>' . $header . '</div>
			<div class="ck-custom-list-notes" data-aria-accordion-panel>' . $content . '</div></div>';
		return $panel;
	}

	/**
	 * Buildt the YouTube Embed
	 *
	 * @param object  $Embed Embed post type object.
	 * @param boolean $collapse_title whether the title is collapsible.
	 */
	public static function make_custom_Embed( $Embed, $collapse_title = false ) {

		$href  = get_field( 'cl_external_Embed', $Embed->ID );
		$notes = get_field( 'cl_notes', $Embed->ID );
		if ( ! empty( $href ) ) {
			$Embed_type = 'external';
		} else {
			$href = get_field( 'cl_pdf_Embed', $Embed->ID );
			if ( ! empty( $href ) ) {
				$Embed_type = 'pdf';
			} else {
				$href      = get_field( 'cl_page_Embed', $Embed->ID );
				$Embed_type = 'page';
			}
		}
		$target = ( 'external' === $Embed_type || 'pdf' === $Embed_type ) ? 'target="_blank"' : '';
		if ( empty( $href ) && true == $collapse_title ) {
			$item = self::make_accordion_panel( $Embed->post_title, $notes );
		} else {
			if ( empty( $href ) ) {
				$item = '<div class="ck-custom-list-title">' . $Embed->post_title . '</div>';
			} else {
				$item = '<a class="ck-custom-list-title" href="' . esc_url( $href ) . '" ' . esc_attr( $target ) . '>' . $Embed->post_title . '</a>';
			}
			if ( ! empty( $notes ) ) {
				$item .= '<div class="ck-custom-list-notes">' . $notes . '</div>';
			}
		}
		return '<li>' . $item . '</li>';

	}

	/**
	 * Render YouTube Embed Lists
	 *
	 * @param array $attributes Attributes passed from the block.
	 */
	public static function carkeek_blocks_render_custom_Embedlist( $attributes ) {
		if ( empty( $attributes['listSelected'] ) ) {
			return;
		}
		$args      = array(
			'numberposts' => -1,
			'post_type'   => 'custom_Embed',
			'order'       => $attributes['order'],
			'post_status' => 'publish',
			'orderby'     => $attributes['sortBy'],
		);
		$post_args = $args;

		// first get all posts with no sub cat selected.

		$subcats           = get_term_children( $attributes['listSelected'], 'Embed_list' );
		$args['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'Embed_list',
				'field'    => 'term_id',
				'terms'    => explode( ',', $attributes['listSelected'] ),
			),
			array(
				'taxonomy' => 'Embed_list',
				'field'    => 'term_id',
				'terms'    => $subcats,
				'operator' => 'NOT IN',
			),
		);

		$Embeds      = get_posts( $args );
		$list_style = '';
		$data_atts  = array(
			'accordion' => '',
			'header'    => '',
			'panel'     => '',
		);
		if ( true == $attributes['makeCollapsible'] ) {
			$list_style .= ' carkeek-blocks-accordion mini';
			$data_atts   = array(
				'accordion' => 'data-aria-accordion data-transition data-multi',
				'header'    => 'data-aria-accordion-heading',
				'panel'     => 'data-aria-accordion-panel',
			);
		}

		if ( 'content' == $attributes['primaryContent'] ) {
			$list_style .= ' is-style-content';
		}

		$block_content = '<div class="wp-block-carkeek-custom-Embed-list' . esc_attr( $list_style ) . '"><div ' . esc_attr( $data_atts['accordion'] ) . '>';

		if ( ! empty( $attributes['headline'] ) ) {
			$tag_name       = 'h' . $attributes['headlineLevel'];
			$block_content .= '<' . $tag_name . ' class="ck-custom-headline">' . $attributes['headline'] . '</' . $tag_name . '>';
		}

		if ( ! empty( $Embeds ) ) {
			$block_content .= '<ul class="ck-custom-list no-bullets">';
			foreach ( $Embeds as $Embed ) {
				$block_content .= self::make_custom_Embed( $Embed, $attributes['makeTitlesCollapsible'] );
			}
			$block_content .= '</ul>';
		}

		if ( ! empty( $subcats ) ) {
			foreach ( $subcats as $cat ) {
				$term                   = get_term( $cat, 'Embed_list' );
				$post_args['tax_query'] = array(
					array(
						'taxonomy' => 'Embed_list',
						'field'    => 'term_id',
						'terms'    => explode( ',', $cat ),
					),
				);
				$sub_Embeds              = get_posts( $post_args );
				if ( ! empty( $sub_Embeds ) ) {
					$list_style = '';

					$block_content .= '<div class="ck-custom-list-label" ' . esc_attr( $data_atts['header'] ) . '>' . $term->name . '</div>';
					$block_content .= '<div class="ck-custom-list" ' . esc_attr( $data_atts['panel'] ) . '><ul class="no-bullets">';
					foreach ( $sub_Embeds as $sub ) {
						$block_content .= self::make_custom_Embed( $sub, $attributes['makeTitlesCollapsible'] );
					}
					$block_content .= '</ul></div>';
				}
			}
		}

		$block_content .= '</div></div>';
		return $block_content;

	}



}

CarkeekBlocksYT_CustomPost::register();


