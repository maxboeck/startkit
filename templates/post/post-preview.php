<article <?php post_class('post--preview'); ?>>
  <header class="post__header">
    <h2 class="post__title p-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php get_template_part('templates/post', 'meta'); ?>
  </header>
  <div class="post__excerpt p-summary">
    <?php the_excerpt(); ?>
  </div>
</article>
