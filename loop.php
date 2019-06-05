<?php if (have_posts()): while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('article'); ?>>
		<?php if (!is_singular()) : ?>
			<a class="article__link" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a>
		<?php endif; ?>

		<h1 class="article__title">
			<?php the_title(); ?>
		</h1>

		<div class="article__author">
            <?php _e( 'Published by', 'wpblank' ); ?> <?php the_author_posts_link(); ?>
        </div>

		<div class="article__publish-date">
			<time><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></time>
		</div>

        <div class="article__comment-count">
            <?php if (comments_open(get_the_ID())) comments_popup_link( __('Leave your thoughts', 'wpblank'), __('1 Comment', 'wpblank'), __('% Comments', 'wpblank')); ?>
        </div>

		<?php if (has_post_thumbnail()) : ?>
			<a class="article__featured-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_post_thumbnail('medium_large', array('class' => 'img-fluid')); ?>
			</a>
		<?php endif; ?>

        <div class="article__content">
		    <?php wpblank_excerpt('wpblankwp_index'); ?>
        </div>

		<?php edit_post_link(); ?>
	</article>
<?php endwhile; ?>

<?php else: ?>
	<article>
		<h1><?php _e( 'Sorry, nothing to display.', 'wpblank' ); ?></h1>
	</article>
<?php endif; ?>
