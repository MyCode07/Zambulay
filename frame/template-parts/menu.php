<?php
// $menu_open = get_localized_field('menyu_otkryt');
?>
<div class="menu">
    <?php get_template_part('template-parts/lang-switcher') ?>

    <nav>
        <ul>
            <li>
                <a href="">Частным лицам</a>
                <ul>
                    <li><a href="">Карты для Google Ads</a></li>
                    <li><a href="">Карты для Meta</a></li>
                    <li><a href="">Карты для ApplePay</a></li>
                    <li><a href="">Карты для оплаты сервисов</a></li>
                </ul>
            </li>
            <li>
                <a href="">Арбитражным командам и баерам</a>
                <ul>
                    <li><a href="">Карты для Google Ads</a></li>
                    <li><a href="">Карты для Meta</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <?php get_template_part('template-parts/auth-btns') ?>

    <div class="_social">
        <?php get_template_part('template-parts/social-links') ?>
    </div>
</div>