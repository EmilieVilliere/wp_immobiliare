<?php get_header(); ?>

    <div>
        <?php if (have_posts()) : ?>
        <!-- S'il y a des articles, on exécute cette partie -->
            <?php while (have_posts()) : the_post(); ?>
                <!-- Pour chaque article, on affiche ceci -->
                <h1><?php the_title(); ?></h1>
                <p>Date: <?php echo get_the_date(); ?></p>
                <p>Catégories: <?php the_category(); ?></p>
                <div>
                    <?php the_content(); ?>
                </div>

                <a href="<?= home_url(); ?>">Retour aux articles</a>
            <?php endwhile; ?>
        <?php else : ?>
        <!-- S'il n'y a pas d'articles, on affiche ceci -->
        <?php endif; ?>
    </div>

<?php get_footer(); ?>
