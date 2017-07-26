<?php get_template_part('templates/header'); ?>
  <main id="main" class="main" role="main">
    <div class="container">
      <?php while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting" aria-labelledby="<?php echo 'post-' . get_the_ID() . '-title'; ?>">

        <header class="post__header">
          <h1 id="<?php echo 'post-' . get_the_ID() . '-title'; ?>" class="post__title p-name" itemprop="headline"><?php the_title(); ?></h1>
          <?php get_template_part('templates/post/post', 'meta'); ?>
        </header>

        <div class="post__content e-content" itemprop="articleBody">
          <?php the_content(); ?>
        </div>

      </article>
      <?php endwhile; ?>
    </div>
  </main>
<?php get_template_part('templates/footer'); ?>
