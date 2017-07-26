<?php 
get_template_part('templates/html-header');
do_action('get_header');
?>

<header class="header" role="banner">
  <div class="container">

    <a class="brand" href="<?= esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
    <nav id="nav" class="nav" role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
    
  </div>
</header>
