<?php get_header(); ?>
<main>
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<section>
					<article id="post-404">
						<h1 class="page-header"><?php _e( 'Page not found', 'wpblank' ); ?></h1>
						<h2>
							<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'wpblank' ); ?></a>
						</h2>
					</article>
				</section>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
