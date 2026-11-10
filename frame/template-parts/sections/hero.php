<?php
$post_type = get_post_type() ?? 'post';

$hero = get_field('banner');

$hero_classes = 'hero-page hero-text';
if (is_front_page()) {
    $hero_classes = 'hero-home';
}
// остальные классы через ацф - так проще
?>
<section class="hero <?php echo $hero_classes ?>" data-<?php echo $post_type; ?>-id="<?php the_ID() ?>">
    <div class="hero-img">
        <img src="<?php echo esc_url(frame_asset('img/hero2.png')); ?>" class="_desktop" alt="">
        <img src="<?php echo esc_url(frame_asset('img/hero-mb.png')); ?>" class="_mobile" alt="">
    </div>
    <div class="hero__container _container">
        <div class="hero__body">
            <h1>Больше, чем банковское
                обслуживание</h1>
            <p>Оплачивайте рекламу без ограничений, и получайте доступ к кредитам и вкладам в одном сервисе</p>
            <a href="" class="_btn _btn-black">Стать клиентом</a>
        </div>
    </div>
</section>