<?php 
get_template_part('templates/html-header');
do_action('get_header');
?>

<header class="header" role="banner">
  <div class="container">

    <a class="header__brand" href="<?= esc_url(home_url('/')); ?>">
      <?php bloginfo('name'); ?>
    </a>
    
    <nav id="nav" class="nav nav--main" role="navigation">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation']);
      endif;
      ?>
    </nav>
    
  </div>
</header>
