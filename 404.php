<?php get_template_part('templates/header'); ?>
  <main id="main" class="main" role="main">

    <div class="page">
      <?php get_template_part('templates/page/page', 'header'); ?>
      <div class="page__content">
        <?php _e('The page you are trying to view could not be found.', 'startkit'); ?>
      </div>
    </div>

  </main>
<?php get_template_part('templates/footer'); ?>
