<?php do_action('get_footer'); ?>

<footer class="footer" role="contentinfo">
  <div class="footer__top container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
  </div>
  <div class="footer__bottom container">
    <p>
      &copy; <?php echo date("Y") . ' ' . get_bloginfo('name') . '.'; ?> 
      <?php _e('All rights reserved.', 'startkit');?>
    </p>
  </div>
</footer>

<?php get_template_part('templates/html-footer'); ?>
