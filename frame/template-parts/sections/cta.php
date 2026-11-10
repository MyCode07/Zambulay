<?php
$cta = get_field('cta');
$btn = $cta['knopka'];
?>
<style>
    .cta__bg-image {
        background-image: url(<?php echo esc_url($cta['fon_desktop']) ?>);

        @media (max-width:1024px) {
            background-image: url(<?php echo esc_url($cta['fon_mobajl']) ?>);
        }

        @media (max-width:767px) {
            background-image: url(<?php echo esc_url($cta['fon_360']) ?>);
        }
    }
</style>
<section class="section white cta" id="cta">
    <div class="cta__bg">
        <div class="cta__bg-image"></div>
    </div>
    <div class="pixelated-scroll-transition" data-pixelated-scroll-transition data-color="#ffffff"
        data-direction="up" aria-hidden="true">
    </div>
    <div class="section__container _container">
        <div class="section__body">
            <div class="section__top">
                <h2><?php echo $cta['zagolovok'] ?></h2>
                <div class="line"><span></span></div>
                <p><?php echo $cta['podzagolovok'] ?></p>
            </div>
            <?php get_template_part('template-parts/_btn', null, ['btn' => $btn]) ?>
        </div>
    </div>
    <div class="pixelated-scroll-transition" data-pixelated-scroll-transition data-color="#ffffff"
        data-direction="down" aria-hidden="true">
    </div>
</section>