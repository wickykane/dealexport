<?php
/*
Template Name: Posts
*/

get_header();

$layout = ThemedbCore::getOption('posts_layout', 'right');
if ($layout == 'left') {
?>
  <aside class="sidebar column fourcol mt-3 mod-sidebar">
    <?php get_sidebar(); ?>
  </aside>
  <div class="column eightcol last">
  <?php } else if ($layout == 'right') { ?>
    <div class="column eightcol  mt-3">
    <?php } else { ?>
      <div class="fullcol">
      <?php } ?>
      <?php echo category_description(); ?>
      <div class="posts-wrap et_pb_blog_grid ">
        <?php
        if (true || is_page()) {
          query_posts(array(
            'post_type' => 'post',
            'orderby' => 'publish_date',
            'order' => 'ASC',
            'paged' => themedb_paged(),
          ));
        }
        ?>
        <div class="container">
          <div class="half-post sixcol">
            <?php
            $i = 0;
            if (have_posts()) {
              while (have_posts()) {
                the_post();
                if ($i % 2 == 0) {
                  get_template_part('content', 'post');
                }
                $i++;
              }
            } ?>
          </div>
          <div class="sixcol half-post">
            <?php
            $i = 0;
            if (have_posts()) {
              while (have_posts()) {
                the_post();
                if ($i % 2 == 1) {
                  get_template_part('content', 'post');
                }
                $i++;
              }
            }
            ?>
          </div>
        </div>
        <?php if (have_posts()) {
        } else {
        ?>
          <h3><?php _e('No posts found. Try a different search?', 'dealexport'); ?></h3>
          <p><?php _e('Sorry, no posts matched your search. Try again with some different keywords.', 'dealexport'); ?></p>
        <?php } ?>
      </div>
      <?php ThemedbInterface::renderPagination(); ?>
      </div>
      <?php if ($layout == 'right') { ?>
        <aside class="mt-3 sidebar column fourcol last  mod-sidebar">
          <?php get_sidebar(); ?>
        </aside>
      <?php } ?>
      <?php get_footer(); ?>