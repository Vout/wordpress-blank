<?php get_header(); ?>
<main>
	<section>
		<?php if (have_posts()):
      the_post(); ?>
			<h1><?php
   _e('Author Archives for ', 'wpblank');
   echo get_the_author();
   ?></h1>
			<?php if (get_the_author_meta('description')): ?>
				<?php echo get_avatar(get_the_author_meta('user_email')); ?>
				<h2><?php
    _e('About ', 'wpblank');
    echo get_the_author();
    ?></h2>
				<?php echo wpautop(get_the_author_meta('description')); ?>
			<?php endif; ?>

			<?php
   rewind_posts();
   while (have_posts()):
       the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					</h1>

					<p>
						<?php _e('by', 'wpblank'); ?> <?php the_author_posts_link(); ?>
					</p>
					<p>
						<?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?><br />
						<?php if (comments_open(get_the_ID())) {
          comments_popup_link(
              __('Leave your thoughts', 'wpblank'),
              __('1 Comment', 'wpblank'),
              __('% Comments', 'wpblank')
          );
      } ?>
					</p>

					<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('medium_large', array('class' => 'img-fluid')); ?>
						</a>
						<hr>
					<?php endif; ?>

					<?php wpblank_excerpt('wpblankwp_index'); ?>

					<?php edit_post_link(); ?>
				</article>
			<?php
   endwhile;
   ?>

		<?php
  else:
       ?>
			<article>
				<h1><?php _e('Sorry, nothing to display.', 'wpblank'); ?></h1>
			</article>
		<?php
  endif; ?>

		<?php get_template_part('pagination'); ?>
	</section>
	<?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>
