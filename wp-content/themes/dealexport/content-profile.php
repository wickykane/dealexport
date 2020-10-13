<?php ThemedbUser::$data['active']=ThemedbUser::getUser($GLOBALS['user']->ID, true); ?>
<div class="image-border small">
    <div class="image-wrap">
        <a href="<?php echo ThemedbUser::$data['active']['links']['profile']['url']; ?>" title="<?php echo ThemedbUser::$data['active']['profile']['full_name']; ?>">
            <?php echo get_avatar(ThemedbUser::$data['active']['ID'], 200); ?>
        </a>
    </div>
</div>