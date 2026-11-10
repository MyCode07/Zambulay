<a href="" target="_blank">
    <svg width="20" height="20" viewBox="0 0 20 20">
        <use xlink:href="<?php echo esc_url(frame_asset('img/svg/icons.svg#tg')); ?>" />
    </svg>
    Telegram
</a>
<a href="" target="_blank">
    <svg width="20" height="20" viewBox="0 0 20 20">
        <use xlink:href="<?php echo esc_url(frame_asset('img/svg/icons.svg#email')); ?>" />
    </svg>
</a>
<a href="" target="_blank">
    <svg width="20" height="20" viewBox="0 0 20 20">
        <use xlink:href="<?php echo esc_url(frame_asset('img/svg/icons.svg#chat')); ?>" />
    </svg>
</a>
<?php
return;
$socials = get_global_field('soczseti');
foreach ($socials as $key => $item):
    if ($item): ?>
        <a href="<?php echo $item ?>" target="_blank" rel="nofollow">
            <svg width="20" height="20" viewBox="0 0 20 20">
                <use xlink:href="<?php echo esc_url(frame_asset('img/svg/icons.svg#' . $key . '')); ?>" />
            </svg>
        </a>
<?php endif;
endforeach; ?>