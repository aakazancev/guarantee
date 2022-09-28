<? get_header(); ?>

<main>
    <section class="page">
        <div class="container-page">
            <h1><? wp_title();?></h1>
            <? the_content();?>
        </div>
    </section>

    <? get_template_part('inc/sale'); ?>
    
</main>

<? get_footer(); ?>