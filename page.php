<?php get_header(); ?>
<main>
    <section>
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <?php comments_template('', true);
                // Remove if you don't want comments
                ?>
                <?php edit_post_link(); ?>

            </article>
        <?php
            endwhile; ?>
        <?php
        else:
             ?>
            <article>
                <h1><?php _e('Sorry, nothing to display.', 'wpblank'); ?></h1>
            </article>
        <?php
        endif; ?>
    </section>
    <?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>
