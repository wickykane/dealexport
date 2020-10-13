<article <?php post_class('post clearfix et_pb_post clearfix post type-post'); ?>>
  <?php if (has_post_thumbnail()) { ?>
    <div class="et_pb_image_container">
      <a href="<?php the_permalink(); ?>" class="entry-featured-image-url"><?php the_post_thumbnail('normal'); ?></a>
    </div>
  <?php } ?>
  <h4 class="entry-title">
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
    </a>
  </h4>
  <div class="post-content clearfix">
    <?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>" class="more-link">
      <?php _e('[:en]Read More[:fr]lire plus[:vi]Đọc tiếp[:]', 'dealexport'); ?>
    </a>
  </div>
  <div class="post-footer clearfix">
    <?php if (!ThemedbCore::checkOption('post_date')) { ?>
      <time class="post-date left" datetime="<?php the_time('Y-m-d'); ?>">
        <span class="fa fa-calendar"></span>
        <span><?php the_time(get_option('date_format')); ?></span>
      </time>
    <?php } ?>
    <?php if (false && !ThemedbCore::checkOption('post_author')) { ?>
      <div class="post-author left">
        <span class="fa fa-pencil"></span>
        <span><?php the_author_posts_link(); ?></span>
      </div>
    <?php } ?>
    <?php if (comments_open()) { ?>
      <div class="comments-number left">
        <span class="fa fa-comments-o"></span>
        <span><a href="<?php comments_link(); ?> "><?php comments_number('0', '1', '%'); ?></a></span>
      </div>
    <?php } ?>
  </div>
</article>