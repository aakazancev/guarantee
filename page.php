<? get_header(); ?>

<main>
    <section class="page">
        <div class="container-page">
            <h1><? wp_title();?></h1>
            <? the_content();?>
        </div>
    </section>

    <? get_template_part('inc/cta-2'); ?>
    <? get_template_part('inc/sale'); ?>
    <? get_template_part('inc/step'); ?>
    
</main>

<? get_footer(); ?>