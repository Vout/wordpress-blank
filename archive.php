<?php get_header(); ?>
<main class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<section>
					<h1 class="page-header"><?php _e( 'Archives', 'wpblank' ); ?></h1>
					<?php get_template_part('loop'); ?>
					<?php get_template_part('pagination'); ?>

				</section>
			</div>
		<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
