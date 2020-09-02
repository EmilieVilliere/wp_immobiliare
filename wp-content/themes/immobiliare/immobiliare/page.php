<?php get_header();

the_post(); // Requête SQL qui récupère les infos de la page
?>

<div class="max-w-3xl mx-auto">
    <h1 class="mb-6 text-2xl"><?php the_title(); ?></h1>
    <div class="prose max-w-none">
        <?php the_content(); ?>
    </div>
</div>

<?php get_footer(); ?>
