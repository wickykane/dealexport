<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

global $product;

if (!comments_open()) {
    return;
}	
?>
<div id="reviews" class="item-reviews">
    <div class="element-title">
        <h1><?php _e('Reviews', 'dealexport'); ?></h1>
    </div>
    <div id="comments" class="comments-wrap">
        <?php if(have_comments()) { ?>
            <ul>
                <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments'))); ?>
            </ul>
            <?php if(get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
            <nav class="pagination">
                <?php
                paginate_comments_links(apply_filters('woocommerce_comment_pagination_args', array(
                    'prev_text' => '',
                    'next_text' => '',
                    'type' => 'plain',
                )));
                ?>
            </nav>
            <?php } ?>
        <?php } else { ?>
        <p class="woocommerce-noreviews secondary"><?php _e('There are no reviews yet.', 'dealexport'); ?></p>
        <?php } ?>
        <div class="clear"></div>
    </div>
    <?php if(get_option('woocommerce_review_rating_verification_required')=== 'no' || wc_customer_bought_product('', get_current_user_id(), $product->id)){ ?>
    <div class="reviews-form">
        <a href="#review_form" class="element-button element-colorbox"><?php _e('Add Review', 'dealexport'); ?></a>
    </div>
    <div class="site-popups hidden">
        <div id="review_form">
            <div class="site-popup large">
                <div class="site-form">
                    <?php
                    $commenter=wp_get_current_commenter();

                    $comment_form=array(
                        'title_reply' => '',
                        'title_reply_to' => '',
                        'comment_notes_before' => '',
                        'comment_notes_after' => '',
                        'fields' => array(
                            'author' => '<div class="column fourcol static"><label for="author">'.__('Name', 'dealexport').'</label></div><div class="eightcol column static last"><div class="field-wrap"><input id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30" aria-required="true" /></div></div>',
                            'email' => '<div class="column fourcol static"><label for="email">'.__('Email', 'dealexport').'</label></div><div class="eightcol column static last"><div class="field-wrap"><input id="email" name="email" type="text" value="'.esc_attr($commenter['comment_author_email']).'" size="30" aria-required="true" /></div></div>',
                        ),
                        'label_submit' => __('Add Review', 'dealexport'),
                        'name_submit' => 'submit',
                        'class_submit' => '',
                        'logged_in_as' => '',
                        'comment_field' => '',
                    );

                    if(get_option('woocommerce_enable_review_rating')=== 'yes'){
                        $comment_form['comment_field']='<div class="column fourcol static"><label for="rating">'.__('Rating', 'dealexport').'</label></div>
                        <div class="column eightcol static last"><div class="element-select"><span></span>
                        <select name="rating" id="rating">
                            <option value="">&ndash;</option>
                            <option value="5">'.__('Perfect', 'dealexport').'</option>
                            <option value="4">'.__('Good', 'dealexport').'</option>
                            <option value="3">'.__('Average', 'dealexport').'</option>
                            <option value="2">'.__('Not that bad', 'dealexport').'</option>
                            <option value="1">'.__('Very Poor', 'dealexport').'</option>
                        </select></div></div><div class="clear"></div>';
                    }

                    $comment_form['comment_field'].= '<textarea id="comment" name="comment" cols="45" rows="6" aria-required="true" placeholder="'.__('Review', 'dealexport').'"></textarea>';
                    comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /popups -->
    <?php } else { ?>
        <p class="woocommerce-verification-required secondary"><?php _e('Only logged in customers who have purchased this product may leave a review.', 'dealexport'); ?></p>
    <?php } ?>
    <div class="clear"></div>
</div>