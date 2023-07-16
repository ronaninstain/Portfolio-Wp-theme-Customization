<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';


class PortfolioProjects {
    public function __construct() {
        add_action('init', array($this, 'create_project_post_type'));
        add_action('add_meta_boxes', array($this, 'add_project_meta_boxes'));
        add_action('save_post', array($this, 'save_project_meta_data'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_load_project_details', array($this, 'load_project_details'));
        add_action('wp_ajax_nopriv_load_project_details', array($this, 'load_project_details'));
        add_action('wp_ajax_sort_projects', array($this, 'sort_projects'));
        add_action('wp_ajax_nopriv_sort_projects', array($this, 'sort_projects'));
        add_action('wp_ajax_filter_projects', array($this, 'filter_projects'));
        add_action('wp_ajax_nopriv_filter_projects', array($this, 'filter_projects'));
    }

    public function create_project_post_type() {
        $labels = array(
            'name' => 'Projects',
            'singular_name' => 'Project',
            'menu_name' => 'Projects',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Project',
            'edit_item' => 'Edit Project',
            'new_item' => 'New Project',
            'view_item' => 'View Project',
            'view_items' => 'View Projects',
            'search_items' => 'Search Projects',
            'not_found' => 'No projects found',
            'not_found_in_trash' => 'No projects found in Trash',
            'all_items' => 'All Projects',
            'archives' => 'Project Archives',
            'attributes' => 'Project Attributes',
            'insert_into_item' => 'Insert into project',
            'uploaded_to_this_item' => 'Uploaded to this project',
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use as featured image',
            'filter_items_list' => 'Filter projects list',
            'items_list_navigation' => 'Projects list navigation',
            'items_list' => 'Projects list'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-portfolio',
            'supports' => array('title', 'editor', 'thumbnail'),
            'has_archive' => true,
            'rewrite' => array('slug' => 'projects'),
        );

        register_post_type('project', $args);
    }

    public function add_project_meta_boxes() {
        add_meta_box(
            'project_external_url',
            'External URL',
            array($this, 'render_project_external_url_meta_box'),
            'project',
            'normal',
            'default'
        );

        add_meta_box(
            'project_preview_images',
            'Preview Images',
            array($this, 'render_project_preview_images_meta_box'),
            'project',
            'normal',
            'default'
        );
    }

    public function render_project_external_url_meta_box($post) {
        $external_url = get_post_meta($post->ID, 'external_url', true);

        echo '<label for="project_external_url">External URL:</label>';
        echo '<input type="text" id="project_external_url" name="project_external_url" value="' . esc_attr($external_url) . '" style="width: 100%;" />';
    }

    public function render_project_preview_images_meta_box($post) {
        $preview_images = get_post_meta($post->ID, 'preview_images', true);

        echo '<label for="project_preview_images">Preview Images:</label>';
        echo '<input type="text" id="project_preview_images" name="project_preview_images" value="' . esc_attr($preview_images) . '" style="width: 100%;" />';
    }

    public function save_project_meta_data($post_id) {
        if (isset($_POST['project_external_url'])) {
            update_post_meta($post_id, 'external_url', sanitize_text_field($_POST['project_external_url']));
        }

        if (isset($_POST['project_preview_images'])) {
            update_post_meta($post_id, 'preview_images', sanitize_text_field($_POST['project_preview_images']));
        }
    }

    public function enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('portfolio-scripts', get_stylesheet_directory_uri() . '/portfolio-scripts.js', array('jquery'), '1.0', true);
        wp_localize_script('portfolio-scripts', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    public function load_project_details() {
        $project_id = $_POST['project_id'];

        $thumbnail = get_the_post_thumbnail_url($project_id, 'thumbnail');
        $title = get_the_title($project_id);
        $description = get_the_content($project_id);
        $external_url = get_post_meta($project_id, 'external_url', true);
        $preview_images = get_post_meta($project_id, 'preview_images', true);

        ob_start();
        include('project-details.php');
        $content = ob_get_clean();

        wp_send_json_success($content);
    }

    public function sort_projects() {
        $sort_by = $_POST['sort_by'];

        $projects = new WP_Query(array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'orderby' => $sort_by,
            'order' => 'ASC'
        ));

        ob_start();
        while ($projects->have_posts()) : $projects->the_post();
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $title = get_the_title();
            $category_terms = get_the_terms(get_the_ID(), 'category');
            $category_list = array();

            foreach ($category_terms as $term) {
                $category_list[] = $term->name;
            }
            include('project-item.php');
        endwhile;
        $content = ob_get_clean();

        wp_send_json_success($content);
    }

    public function filter_projects() {
        $category_slug = $_POST['category_slug'];

        $args = array(
            'post_type' => 'project',
            'posts_per_page' => -1,
        );

        if ($category_slug) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category_slug
                )
            );
        }

        $projects = new WP_Query($args);

        ob_start();
        while ($projects->have_posts()) : $projects->the_post();
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
            $title = get_the_title();
            $category_terms = get_the_terms(get_the_ID(), 'category');
            $category_list = array();

            foreach ($category_terms as $term) {
                $category_list[] = $term->name;
            }
            include('project-item.php');
        endwhile;
        $content = ob_get_clean();

        wp_send_json_success($content);
    }
}

new PortfolioProjects();
