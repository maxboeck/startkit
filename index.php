<?php get_template_part('templates/header'); ?>
  <main id="main" class="main" role="main">

      <?php get_template_part('templates/page/page', 'header'); ?>

      <?php if (!have_posts()) : ?>
        <div class="alert alert--warning">
          <?php _e('Sorry, no results were found.', 'startkit'); ?>
        </div>
        <?php get_search_form(); ?>
      <?php endif; ?>

      <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part('templates/post/post', 'preview'); ?>
      <?php endwhile; ?>

      <?php the_posts_navigation(); ?>

  </main>
<?php get_template_part('templates/footer'); ?>
