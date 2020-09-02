<?php get_header(); ?>

    <div class="flex flex-wrap">
        <?php if (have_posts()) : ?>
        <!-- S'il y a des articles, on exécute cette partie -->
            <?php while (have_posts()) : the_post(); ?>
                <div class="md:w-6/12 lg:w-3/12">
                    <div class="mx-2 mb-6">
                        <a href="<?php the_permalink(); ?>">
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
                                    <!--
                                        Pour chaque annonce, on va ajouter le prix et la surface comme sur la maquette
                                        Le prix doit être formatté : 100000 -> 100 000,00 €
                                        Pour les "étoiles", on aura un champ note dans le BO entre 1 et 5
                                        La surface s'affiche à côté des étoiles
                                        A la place de la catégorie dans le badge vert, on a besoin du type de l'annonce
                                        (T2, T3, T4)
                                        BONUS: On ajoute un champ "Chambre" et "SDB" par annonces
                                     -->
                                    <?php
                                        $surface = get_post_meta($post->ID, 'surface', true) ?? 1;
                                        $rawPrice = get_post_meta($post->ID, 'price', true) ?? 1;
                                        $price = number_format(
                                            $rawPrice,
                                            2,
                                            ',',
                                            ' '
                                        );
                                        $priceByM = number_format(
                                            $rawPrice / $surface,
                                            2,
                                            ',',
                                            ' '
                                        );
                                        $beds = get_post_meta($post->ID, 'beds', true) ?? 0;
                                        $baths = get_post_meta($post->ID, 'baths', true) ?? 1;
                                        $note = get_post_meta($post->ID, 'note', true) ?? 0;
                                    ?>
                                    <div class="flex items-center">
                                        <span class="text-xs bg-teal-200 text-teal-800 rounded-full px-2 py-1 uppercase">
                                            <?php echo get_the_terms($post->ID, 'types')[0]->name ?? 'Aucun'; ?>
                                        </span>
                                        <p class="ml-2 text-xs text-gray-600 uppercase">
                                            <?php if ($beds > 0) {
                                                echo $beds.' chambres - ';
                                            } ?>
                                            <?= $baths; ?> SDB
                                        </p>
                                    </div>
                                    <h1 class="font-bold text-gray-900 text-lg"><?php the_title(); ?></h1>
                                    <div>
                                        <span class="text-gray-900"><?= 
                                        $price; ?> €</span>
                                        <span class="ml-1 text-sm text-gray-600"><?= $priceByM; ?> € le m2</span>
                                    </div>
                                    <div class="mt-2 text-sm flex items-center text-sm text-gray-600">
                                        <?php for ($i = 1; $i <= 5; ++$i) {
                                            $color = ($note >= $i) ? 'text-teal-500' : 'text-gray-400';
                                            ?>
                                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current <?= $color; ?>"><path d="M8.128 19.825a1.586 1.586 0 0 1-1.643-.117 1.543 1.543 0 0 1-.53-.662 1.515 1.515 0 0 1-.096-.837l.736-4.247-3.13-3a1.514 1.514 0 0 1-.39-1.569c.09-.271.254-.513.475-.698.22-.185.49-.306.776-.35L8.66 7.73l1.925-3.862c.128-.26.328-.48.577-.633a1.584 1.584 0 0 1 1.662 0c.25.153.45.373.577.633l1.925 3.847 4.334.615c.29.042.562.162.785.348.224.186.39.43.48.704a1.514 1.514 0 0 1-.404 1.58l-3.13 3 .736 4.247c.047.282.014.572-.096.837-.111.265-.294.494-.53.662a1.582 1.582 0 0 1-1.643.117l-3.865-2-3.865 2z"></path></svg>
                                        <?php } ?>

                                        <span class="ml-2"><?= $surface; ?> m2</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> <!-- Fin de la div mx-2 mb-6 -->
                </div>
            <?php endwhile; ?>
        <?php else : ?>
        <!-- S'il n'y a pas d'articles, on affiche ceci -->
        <?php endif; ?>
    </div>

<?php get_footer(); ?>
