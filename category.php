<?php get_header(); ?>
<main>
	<section>
		<h1><?php
  _e('Categories for ', 'wpblank');
  single_cat_title();
  ?></h1>
		<?php get_template_part('loop'); ?>
		<?php get_template_part('pagination'); ?>
	</section>
	<?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>
