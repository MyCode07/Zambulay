<?php
$why = get_field('pochemu');
$why_subtitles = [$why['podzagolovok'], $why['podzagolovok_2']];
$list = $why['spisok'];
if (!$list) return;
?>
<section class="section why white" id="why">
    <div class="section__container _container">
        <div class="section__body">
            <div class="section__top">
                <h2><?php echo $why['zagolovok'] ?></h2>
                <div class="line"><span></span></div>
                <?php foreach ($why_subtitles as $item): if ($item) : ?>
                        <p><?php echo $item ?></p>
                <?php endif;
                endforeach; ?>
            </div>
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($list as $key => $item): ?>
                        <div class="swiper-slide">
                            <div class="why-item">
                                <div class="why-item__top">
                                    <span class="medium-nums">0<?php echo $key + 1 ?></span>
                                    <div>
                                        <h3><?php echo $item['zagolovok'] ?></h3>
                                        <p><?php echo $item['tekst'] ?></p>
                                    </div>
                                </div>
                                <div class="img">
                                    <?php echo wp_get_attachment_image(
                                        $item['foto']['id'],
                                        'large'
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php get_template_part('template-parts/swiper-navigation') ?>
            </div>
        </div>
    </div>
    <div class="pixelated-scroll-transition" data-pixelated-scroll-transition data-color="#ffffff"
        data-direction="down" aria-hidden="true">
    </div>
</section>