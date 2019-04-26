<?php
    /* ======================================================================
        EXTERNAL MODULES AND FILES BELOW
	====================================================================== */

    /* here*/

    /* ======================================================================
        THEME SETTINGS
	====================================================================== */
    if (!isset($content_width)) {
        $content_width = 900;
    }

    if (function_exists('add_theme_support')) {
    
        // Add Menu Support
        add_theme_support('menus');

        // Add Thumbnail Theme Support
        add_theme_support('post-thumbnails');
        add_image_size('large', 700, '', true); // Large Thumbnail
        add_image_size('medium', 250, '', true); // Medium Thumbnail
        add_image_size('small', 120, '', true); // Small Thumbnail
        add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

        // Enables post and comment RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Localisation Support
        load_theme_textdomain('wordpressblank', get_template_directory() . '/languages');
    }

    /* ======================================================================
        CUSTOM MENU WALKER TO GET AN PROPER BOOTSTRAP MENU
	====================================================================== */
    // Register Custom Navigation Walker
    require_once('inc/class-wp-bootstrap-navwalker.php');

    // WP Bootstrap Sass navigation
    function wordpressblank_nav() {
        wp_nav_menu(
        array(
            'theme_location'  => 'header-menu',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'collapse navbar-collapse',
            'container_id'    => 'bs-example-navbar-collapse-1',
            'menu_class'      => 'navbar-nav ml-auto',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'depth'           => 2,
            'walker'          => new WP_Bootstrap_Navwalker()
            )
        );
    }

    /* ======================================================================
        LOAD ASSETS (CSS, JS)
    ====================================================================== */
    /* Frontend scripts and styles */
    add_action('wp_enqueue_scripts', 'vout_frontend_scripts');
    function vout_frontend_scripts() {
        wp_enqueue_style('wordpressblank', get_template_directory_uri() .'/dist/style.min.css', null, null, true);

        if( !is_admin()){
            wp_deregister_script('jquery');
            wp_register_script('jquery', get_template_directory_uri() .'/dist/main.bundle.js', null, null, true);
            wp_enqueue_script('jquery');
        }

        // load script that serves inline comments
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
