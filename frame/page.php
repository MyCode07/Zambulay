<?php
get_header();
?>

<main>

    <?php get_template_part('template-parts/sections/hero') ?>

    <section class="section text">
        <div class="section__container _container">
            <div class="section__body">
                <div class="_text-box">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
