<?php get_header(); ?>
<main>
    <section>
        <?php if (have_posts()): while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                </h1>

                <p>
                    <?php _e( 'Published by', 'wpblank' ); ?> <?php the_author_posts_link(); ?>
                </p>

                <p>
                    <?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?><br />
                    <?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'wpblank' ), __( '1 Comment', 'wpblank' ), __( '% Comments', 'wpblank' )); ?>
                </p>

                <?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <?php get_the_post_thumbnail('large', ['class' => 'img-fluid']); // Fullsize image for the single post ?>
                    </a>
                <?php endif; ?>

                <?php the_content(); ?>

                <p>
                    <?php the_tags( __( 'Tags: ', 'wpblank' ), ', ', '<br>'); ?>
                </p>

                <p>
                    <?php _e( 'Categorised in: ', 'wpblank' ); the_category(', '); // Separated by commas ?>
                </p>

                <p>
                    <?php _e( 'This post was written by ', 'wpblank' ); the_author(); ?>
                </p>

                <?php edit_post_link(); ?>

                <?php comments_template(); ?>

                </article>
            <?php endwhile; ?>

            <?php else: ?>
                <article>
                    <h1><?php _e( 'Sorry, nothing to display.', 'wpblank' ); ?></h1>
                </article>
            <?php endif; ?>
    </section>
    <?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>
