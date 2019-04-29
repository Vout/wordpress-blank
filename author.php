<?php get_header(); ?>
<main class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<!-- section -->
				<section>

				<?php if (have_posts()): the_post(); ?>

					<h1 class="page-header"><?php _e( 'Author Archives for ', 'wpbootstrapsass' ); echo get_the_author(); ?></h1>

				<?php if ( get_the_author_meta('description')) : ?>

				<?php echo get_avatar(get_the_author_meta('user_email')); ?>

					<h2><?php _e( 'About ', 'wpbootstrapsass' ); echo get_the_author() ; ?></h2>
					<hr>

					<?php echo wpautop( get_the_author_meta('description') ); ?>

				<?php endif; ?>

				<?php rewind_posts(); while (have_posts()) : the_post(); ?>

					<!-- article -->
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<!-- post title -->
						<h2>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h2>
						<!-- /Post title -->
						<!-- post details -->
						<p class="lead">
							<span class="author"><?php _e( 'by', 'wpbootstrapsass' ); ?> <?php the_author_posts_link(); ?></span>
						</p>
						<p>
							<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
							<span class="text-muted">|</span>
							<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'wpbootstrapsass' ), __( '1 Comment', 'wpbootstrapsass' ), __( '% Comments', 'wpbootstrapsass' )); ?></span>
						</p>
						<!-- /post details -->
						<hr>
						<!-- post thumbnail -->
						<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail('medium_large', array('class' => 'img-fluid') ); // Declare pixel size you need inside the array ?>
							</a>
							<hr>
						<?php endif; ?>
						<!-- /post thumbnail -->

						<?php wpbootstrapsass_excerpt('wpbootstrapsasswp_index'); // Build your custom callback length in functions.php ?>

						<br class="clear">

						<?php edit_post_link(); ?>
						<hr>

					</article>
					<!-- /article -->

				<?php endwhile; ?>

				<?php else: ?>

					<!-- article -->
					<article>

						<h2><?php _e( 'Sorry, nothing to display.', 'wpbootstrapsass' ); ?></h2>

					</article>
					<!-- /article -->

				<?php endif; ?>

					<?php get_template_part('pagination'); ?>

				</section>
				<!-- /section -->
			</div><!-- /.col-md-8 -->
			<?php get_sidebar(); ?>
		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
<?php get_footer(); ?>
