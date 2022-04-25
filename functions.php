<?php
	/**
	 * Functions and definitions.
	 */

	// Fires after the theme is initialized.
	add_action( 'after_setup_theme', 'wpsp_setup', 0 );

	function wpsp_setup() {

		/* ------------------------------ LANGUAGES ------------------------------ */

		// Load the theme’s translated strings.
		load_theme_textdomain( 'wpsp', get_template_directory() . '/languages' );

		/* ------------------------------ MENUS ------------------------------ */

		// Registers navigation menu locations for a theme (Appearance -> Menu).
		register_nav_menus( array(
			'main-menu' => __( 'Main navigation', 'wpsp' )
		) );

		/* ------------------------------ SIDEBARS ------------------------------ */

		// Builds the definition for a single sidebar and returns the ID.
		register_sidebar(
			array(
				'name' => __( 'Sidebar', 'wpsp' ),
				'description' => __( 'Default sidebar', 'wpsp' ),
				'id' => 'sidebar',
				'before_widget' => '<section id="%1$s" class="%2$s">',
				'after_widget' => '</section>'
			)
		);

	}

	/* ------------------------------ ASSETS ------------------------------ */

	// Sets/queues styles and scripts.
	add_action( 'wp_enqueue_scripts', 'wpsp_assets' );

	function wpsp_assets()
	{
		
		//-------------------------------------------------------------------
		// CSS
		//-------------------------------------------------------------------

		// CSS Normalize library for consistent styles in all modern browsers (https://necolas.github.io/normalize.css/).
		wp_enqueue_style( 'wpsp_normalize', get_template_directory_uri() . '/assets/css/normalize.css', null, null, 'all' );

		// Main CSS file.
		wp_enqueue_style( 'wpsp_main', get_template_directory_uri() . '/assets/css/main.css', null, null, 'all' );

		//-------------------------------------------------------------------
		// JS
		//-------------------------------------------------------------------

		// Main JS file.
		wp_enqueue_script( 'wpsp_main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), null, true );
	}

	/* ------------------------------ FEATURES ------------------------------ */

	// Allows theme to add document title tag to HTML <head>.
	add_theme_support( 'title-tag' );

	// Registers theme support for post thumbnails.
	add_theme_support( 'post-thumbnails', array( 'post' ) );

	// Registers theme support for excerpt feature in pages.
	//add_post_type_support( 'page', 'excerpt' );

	// Updates the default image sizes after theme is switched.
	add_action( 'after_switch_theme', 'wpsp_images_default_sizes' );

	function wpsp_images_default_sizes() {
		// Sets the thumbnail size and cropping.
		update_option( 'thumbnail_size_w', 300 );
		update_option( 'thumbnail_size_h', 300 );
		update_option( 'thumbnail_crop', 1 );
		// Sets the medium size.
		update_option( 'medium_size_w', 600 );
		update_option( 'medium_size_h', 600 );
		// Sets the large size.
		update_option( 'large_size_w', 1200 );
		update_option( 'large_size_h', 1200 );
	}

	// Removes archives labels from the_archive_title() function.
	add_filter( 'get_the_archive_title', 'wpsp_archives_titles' );

	function wpsp_archives_titles( $title ) {

		if ( is_author() ) {
			$title = get_the_author();
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_year() ) {
			$title = get_the_date( 'Y' );
		} elseif ( is_month() ) {
			$title = get_the_date( 'F Y' );
		} elseif ( is_day() ) {
			$title = get_the_date( 'j. F, Y' );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} else {
			$title = __( 'Archive', 'wpsp' );
		}

		return $title;
	}