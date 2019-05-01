<?php get_header(); ?>
<main>
    <section>
        <h1><?php _e( 'Tag Archive: ', 'wpblank' ); echo single_tag_title('', false); ?></h1>
        <?php get_template_part('loop'); ?>
        <?php get_template_part('pagination'); ?>
    </section>

    <?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>

