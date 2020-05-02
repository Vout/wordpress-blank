<?php get_header(); ?>
<main>
    <section>
        <h1><?php
        echo sprintf(
            __('%s Search Results for ', 'wpblank'),
            $wp_query->found_posts
        );
        echo get_search_query();
        ?></h1>
        <?php get_template_part('loop'); ?>
        <?php get_template_part('pagination'); ?>
    </section>
    <?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>
