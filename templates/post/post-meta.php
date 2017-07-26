<div class="post__meta">
  <time class="post__pubdate dt-published" datetime="<?= get_post_time('c', true); ?>" itemprop="datePublished"><?= get_the_date(); ?></time>
  <p class="post__author vcard"><?= __('By', 'startkit'); ?> <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?= get_the_author(); ?></a></p>
</div>