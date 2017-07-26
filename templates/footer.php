<?php do_action('get_footer'); ?>

<footer class="footer" role="contentinfo">
  <div class="footer__bottom container">

    <?php if (has_nav_menu('footer_links')) : ?>
    <nav class="nav nav--footer">
      <?php wp_nav_menu(['theme_location' => 'footer_links']); ?>
    </nav>
    <?php endif; ?>

    <p>
      &copy; <?php echo date("Y") . ' ' . get_bloginfo('name') . '.'; ?> 
      <?php _e('All rights reserved.', 'startkit');?>
    </p>

  </div>
</footer>

<?php get_template_part('templates/html-footer'); ?>
