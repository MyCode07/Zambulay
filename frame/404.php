<?php
get_header();
?>

<main>

    <?php
    $err = get_localized_field('stranicza_404');
    ?>
    <section class="hero hero-page hero-404">
        <div class="hero-img">
            <img src="<?php echo esc_url(frame_asset('img/page-hero.png')); ?>" class="_desktop" alt="">
            <img src="<?php echo esc_url(frame_asset('img/page-hero-mb.png')); ?>" class="_mobile" alt="">
        </div>
        <div class="hero__container _container">
            <div class="hero__body">
                <h1>404</h1>
                <p>Ничего не найдено</p>
                <a href="<?php echo get_home_page_url() ?>" class="_btn _btn-black">Вернутся на главный</a>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
