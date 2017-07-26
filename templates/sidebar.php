<?php
if ( ! is_active_sidebar( 'sidebar-primary' ) ) {
  return;
}
?>

<aside class="sidebar" role="complementary">
  <?php dynamic_sidebar( 'sidebar-primary' ); ?>
</aside>