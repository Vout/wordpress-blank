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
        load_theme_textdomain('wpblank', get_template_directory() . '/languages');
    }

    /* ======================================================================
        LOAD ASSETS (CSS, JS)
    ====================================================================== */
    function wpblank_styles() {
        // Normalize is loaded in Bootstrap and both are imported into the style.css via Sass
        wp_register_style('wpblankCss', get_template_directory_uri() . '/dist/style.min.css', array(), '1.0.0', 'all');
        wp_enqueue_style('wpblankCss'); // Enqueue it!
    }

    // Remove 'text/css' from our enqueued stylesheet
    function wpblank_styles_remove($tag) {
        return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
    }

    // Load theme js
    function wpblank_scripts() {
        if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
            wp_register_script('wpblankJs', get_template_directory_uri() . '/dist/main.bundle.js', array('jquery'), '1.0.0', true);
            wp_enqueue_script( array('wpblankJs') );

        }
    }

    // Load conditional scripts
    function wpblank_conditional_scripts() {
        if (is_page('pagenamehere')) {
            wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0');
            wp_enqueue_script('scriptname'); // Enqueue it!
        }
    }

    // Async scripts
    function wpblank_add_script_tag_attributes($tag, $handle) {
        switch ($handle) {
            case ('wpblankJs'):
                return str_replace( ' src', ' async="async" src', $tag );
            break;

            // example adding CDN integrity and crossorigin attributes
            // Note: popper.js is loaded into the main.bundle.js from npm
            // Below are just examples
            case ('popper-js'):
                return str_replace( ' min.js', 'min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"', $tag );
            break;

            case ('bootstrap-js'):
                return str_replace( ' min.js', 'min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"', $tag );
            break;

            default:
                return $tag;

        }
    }

    // Remove all query strings
    function wpblank_script_version($src){
        $parts = explode('?ver', $src);
        return $parts[0];
    }

    /* ======================================================================
        CUSTOM MENU WALKER TO GET AN PROPER BOOTSTRAP MENU
	====================================================================== */
    // Register Custom Navigation Walker
    require_once('inc/class-wp-bootstrap-navwalker.php');

    // WP Bootstrap Sass navigation
    function wpblank_nav() {
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

    // Register WP Bootstrap Sass Navigation
    function wpblank_register_menu() {
        register_nav_menus(array( // Using array to specify more menus if needed
            'header-menu' => __('Header Menu', 'wpblank'), // Main Navigation
            'sidebar-menu' => __('Sidebar Menu', 'wpblank'), // Sidebar Navigation
            'extra-menu' => __('Extra Menu', 'wpblank') // Extra Navigation if needed (duplicate as many as you need!)
        ));
    }

    // Remove the <div> surrounding the dynamic navigation to cleanup markup
    function wpblank_nav_menu_args($args = '') {
        $args['container'] = false;
        return $args;
    }

    // Remove Injected classes, ID's and Page ID's from Navigation <li> items
    function my_css_attributes_filter($var) {
        return is_array($var) ? array() : '';
    }

    /* ======================================================================
        ADD SLUG TO BODY CLASS
	====================================================================== */
    function wpblank_add_slug_to_body_class($classes) {
        global $post;
        if (is_home()) {
            $key = array_search('blog', $classes);
            if ($key > -1) {
                unset($classes[$key]);
            }
        } elseif (is_page()) {
            $classes[] = sanitize_html_class($post->post_name);
        } elseif (is_singular()) {
            $classes[] = sanitize_html_class($post->post_name);
        }

        return $classes;
    }

    /* ======================================================================
        REMOVE ADMIN BAR
	====================================================================== */
    function wpblank_remove_admin_bar() {
        return false;
    }

    /* ======================================================================
        ENABLE THREADED COMMENTS
	====================================================================== */
    function wpblank_enable_threaded_comments() {
        if (!is_admin()) {
            if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
                wp_enqueue_script('comment-reply');
            }
        }
    }

    /* ======================================================================
        ADD BOOTSTRAP 4 .img-fluid CLASS TO IMAGES INSIDE POST CONTENT
	====================================================================== */
    function wpblank_add_class_to_image_in_content($content) {
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML(utf8_decode($content));

        $imgs = $document->getElementsByTagName('img');
        foreach ($imgs as $img) {           
            $img->setAttribute('class','img-fluid');
        }

        $html = $document->saveHTML();
        return $html;  	
    }

    /* ======================================================================
        REMOVE RECENT COMMENT STYLES
	====================================================================== */
    function wpblank_remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action('wp_head', array(
            $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
            'recent_comments_style'
        ));
    }

    /* ======================================================================
        DELETE ALL YOAST PLUGIN SPAM
    ====================================================================== */
    if (defined('WPSEO_VERSION')) {
        add_action('get_header', function() {
            ob_start(function($o) {
                return preg_replace('/\n?<.*?yoast.*?>/mi','',$o);
            });
        });

        add_action('wp_head',function() {
            ob_end_flush();
        }, 999);
    }

    function wpblank_remove_yoast_json($data){
        $data = array();
        return $data;
    }

    /* ======================================================================
        STOP CONTACTFORM7 ADDING OWN STYLES
    ====================================================================== */  
    add_filter('wpcf7_form_elements', function($content) {
        $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);
        return $content;
    });

    /* ======================================================================
        ACTIONS AND CLEANING
	====================================================================== */
    // Add Actions
    add_action('wp_enqueue_scripts', 'wpblank_styles'); // Add Theme Stylesheet
    add_action('init', 'wpblank_scripts'); // Add Custom Scripts to wp_head
    add_action('wp_print_scripts', 'wpblank_conditional_scripts'); // Add Conditional Page Scripts
    add_action('get_header', 'wpblank_enable_threaded_comments'); // Enable Threaded Comments
    add_action('init', 'wpblank_register_menu'); // Add WP Bootstrap Sass Menu
    add_action('widgets_init', 'wpblank_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
    // add_action('init', 'wpbootstrapsass_pagination'); // Add our wpbootstrapsass Pagination

    // Remove Actions
    remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
    remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
    remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
    remove_action('wp_head', 'index_rel_link'); // Index link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
    remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
    remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    // // Add Filters
    add_filter('script_loader_tag', 'wpblank_add_script_tag_attributes', 10, 2); // Add attributes to CDN script tag
    // add_filter('avatar_defaults', 'wpbootstrapsassgravatar'); // Custom Gravatar in Settings > Discussion
    add_filter('body_class', 'wpblank_add_slug_to_body_class'); // Add slug to body class (Starkers build)
    add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
    add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
    add_filter('wp_nav_menu_args', 'wpblank_nav_menu_args'); // Remove surrounding <div> from WP Navigation
    // add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
    // add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
    // add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
    add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
    add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
    add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
    // add_filter('excerpt_more', 'wpbootstrapsass_view_article'); // Add 'View Article' button instead of [...] for Excerpts
    add_filter('show_admin_bar', 'wpblank_remove_admin_bar'); // Remove Admin bar
    add_filter('style_loader_tag', 'wpblank_styles_remove'); // Remove 'text/css' from enqueued stylesheet
    add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
    add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
    add_filter('the_content', 'wpblank_add_class_to_image_in_content'); // Add .img-fluid class to images in the content
    add_filter('wpseo_json_ld_output', 'wpblank_remove_yoast_json', 10, 1); // Rwmove Yoast spam
    add_filter( 'wpcf7_load_js', '__return_false' ); // Remove contactform7 js if no form on page
    add_filter( 'wpcf7_load_css', '__return_false' ); // Remove contactform7 css if no form on page
    add_filter('script_loader_src', 'wpblank_script_version', 15, 1); // Remove query strings
    add_filter('style_loader_src', 'wpblank_script_version', 15, 1); // Remove query strings

    // Remove Filters
    remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether
