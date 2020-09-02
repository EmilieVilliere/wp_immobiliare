<?php get_header(); ?>

    <div class="flex flex-wrap">
        <?php if (have_posts()) : ?>
        <!-- S'il y a des articles, on exécute cette partie -->
            <?php while (have_posts()) : the_post(); ?>
                <div class="md:w-6/12 lg:w-3/12">
                    <div class="mx-2 mb-6">
                        <?php
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
                            // Opérateur null coalesce
                            // Equivalent à isset($image[0]) ? $image[0] : null;
                            $image_src = $image[0] ?? null;
                            if ($image_src) { ?>
                                <img class="w-full h-48 object-cover rounded-lg shadow-md" src="<?= $image_src; ?>" />
                            <?php } else { ?>
                                <div class="h-48"></div>
                            <?php } ?>
                        <div class="-mt-16 relative px-4">
                            <div class="bg-white rounded-lg p-4 shadow-lg">
                                <!-- Pour chaque article, on affiche ceci -->
                                <div class="flex items-center">
                                    <span class="text-xs bg-teal-200 text-teal-800 rounded-full px-2 py-1">
                                        <?php the_category(); ?>
                                    </span>
                                    <p class="ml-2 text-xs text-gray-600"><?php echo get_the_date(); ?></p>
                                </div>
                                <h1 class="font-bold text-gray-900"><?php the_title(); ?></h1>
                                <a href="<?php the_permalink(); ?>">Voir l'article</a>
                            </div>
                        </div>
                    </div> <!-- Fin de la div mx-2 mb-6 -->
                </div>
            <?php endwhile; ?>
        <?php else : ?>
        <!-- S'il n'y a pas d'articles, on affiche ceci -->
        <?php endif; ?>
    </div>

<?php get_footer(); ?>
