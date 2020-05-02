<?php get_header(); ?>
<main>
	<section>
		<article id="post-404">
			<h1><?php _e('Page not found', 'wpblank'); ?></h1>
			<h2>
				<a href="<?php echo home_url(); ?>"><?php _e('Return home?', 'wpblank'); ?></a>
			</h2>
		</article>
	</section>
	<?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>
