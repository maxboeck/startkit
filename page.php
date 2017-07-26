<?php get_template_part('templates/header'); ?>
  <main id="main" class="main" role="main">

    <div class="page">
    <?php while (have_posts()) : the_post(); ?>

      <?php get_template_part('templates/page/page', 'header'); ?>
      <div class="page__content">
        <?php the_content(); ?>
      </div>
      
    <?php endwhile; ?>
    </div>

  </main>
<?php get_template_part('templates/footer'); ?>
