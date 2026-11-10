<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <script>
        document.documentElement.classList.replace('no-js', 'js');
    </script>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    wp_body_open();
    $header_class = '';

    if (!is_front_page() && !is_404()) {
        $header_class = '';
    }
    if (is_404()) {
        $header_class = '';
    }

    get_template_part('template-parts/menu');
    get_template_part('template-parts/breadcrumbs');

    ?>
    <div class="wrapper">
        <header class="header <?php echo $header_class ?>">
            <div class="header__container _container">
                <div class="header__body">
                    <a href="<?php echo get_home_page_url() ?>" class="header__logo">Zambulay</a>

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

                    <?php
                    get_template_part('template-parts/lang-switcher');
                    get_template_part('template-parts/auth-btns');
                    ?>

                    <button class="header__burger">
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </header>