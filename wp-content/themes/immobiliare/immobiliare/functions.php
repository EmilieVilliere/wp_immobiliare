<?php

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'tailwind-typography', 'https://unpkg.com/@tailwindcss/typography@0.2.x/dist/typography.min.css' );
    wp_enqueue_style( 'tailwind', 'https://unpkg.com/tailwindcss@1.7.6/dist/tailwind.min.css' );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
    // Ajouter le js...
    wp_deregister_script('jquery'); // Supprime le jquery de wordpress
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', [], false, true);
    wp_enqueue_script('app', get_template_directory_uri().'/js/app.js', [], false, true);
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// Ajout des images à la une
add_theme_support( 'post-thumbnails' );

// Ajout emplacement de menu
function register_my_menu() {
    register_nav_menu('main-menu', 'Menu principal');
}

add_action( 'init', 'register_my_menu' );

// Ajout de classes CSS sur les li du menu
function add_tailwind_class_li_menu($classes, $item) {
    // var_dump($classes, $item);
    $classes[] = 'block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4';

    return $classes;
}

add_filter('nav_menu_css_class', 'add_tailwind_class_li_menu', 10, 2);

// Ajout de logo
add_theme_support( 'custom-logo' );

// On supprime la meta qui affiche la version de WordPress
// dans le <head> et aussi sur le flux RSS
function remove_wordpress_version() {
    return '';
}

add_filter('the_generator', 'remove_wordpress_version');

// Ajout d'un arrière plan
add_theme_support( 'custom-background' );

// Ajout de la table annonces
function register_housing() {
    register_post_type('housing', [
        'label' => 'Biens immobiliers',
        'labels' => [
            'name' => 'Biens immobiliers',
            'singular_name' => 'Bien immobilier',
            'all_items' => 'Tous les biens',
            'add_new_item' => 'Ajouter un bien',
            'edit_item' => 'Éditer le bien',
            'new_item' => 'Nouveau bien',
            'view_item' => 'Voir le bien',
            'search_items' => 'Rechercher parmi les biens',
            'not_found' => 'Pas de bien trouvé',
            'not_found_in_trash' => 'Pas de bien dans la corbeille',
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'author', 'thumbnail'],
        'has_archive' => 'annonces',
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-home',
    ]);

    register_taxonomy('city', 'housing', [
        'label' => 'Villes',
        'labels' => [
            'name' => 'Villes',
            'singular_name' => 'Ville',
            'all_items' => 'Toutes les villes',
            'edit_item' => 'Éditer la ville',
            'view_item' => 'Voir la ville',
            'update_item' => 'Mettre à jour la ville',
            'add_new_item' => 'Ajouter une ville',
            'new_item_name' => 'Nouvelle ville',
            'search_items' => 'Rechercher parmi les villes',
            'popular_items' => 'Villes les plus utilisées'
        ],
        'hierarchical' => false,
        'show_in_rest' => true, // Pour Gutenberg
    ]);

    register_taxonomy('types', 'housing', [
        'label' => 'Types',
        'labels' => [
            'name' => 'Types',
            'singular_name' => 'Type',
            'all_items' => 'Toutes les types',
            'edit_item' => 'Éditer le type',
            'view_item' => 'Voir le type',
            'update_item' => 'Mettre à jour le type',
            'add_new_item' => 'Ajouter un type',
            'new_item_name' => 'Nouveau type',
            'search_items' => 'Rechercher parmi les types',
            'popular_items' => 'Types les plus utilisés'
        ],
        'hierarchical' => false,
        'show_in_rest' => true, // Pour Gutenberg
    ]);
}  

add_action('init', 'register_housing');

// Ajout metaboxe
function init_meta_boxe() {
    add_meta_box('informations', 'Informations', 'display_meta_boxe', 'housing');
}

function display_meta_boxe($post) {
    $price = get_post_meta($post->ID, 'price', true);
    $surface = get_post_meta($post->ID, 'surface', true);
    $beds = get_post_meta($post->ID, 'beds', true);
    $baths = get_post_meta($post->ID, 'baths', true);
    $note = get_post_meta($post->ID, 'note', true);
    ?>
    <div>
        <label for="price">Prix :</label> <br />
        <input required type="text" name="price" id="price" value="<?= $price; ?>">
    </div> <br />

    <div>
        <label for="surface">Surface :</label> <br />
        <input required type="text" name="surface" id="surface" value="<?= $surface; ?>">
    </div>

    <div>
        <label for="beds">Chambres :</label> <br />
        <input required type="text" name="beds" id="beds" value="<?= $beds; ?>">
    </div>

    <div>
        <label for="baths">Salles de bain :</label> <br />
        <input required type="text" name="baths" id="baths" value="<?= $baths; ?>">
    </div>

    <div>
        <label for="note">Note :</label> <br />
        <input required type="text" name="note" id="note" value="<?= $note; ?>">
    </div>
<?php }

add_action('add_meta_boxes', 'init_meta_boxe');

// On fait le traitement du formulaire des annonces
function save_meta_boxe($id_post) {
    if ('housing' !== get_post_type($id_post)) {
        return;
    }

    if (isset($_POST['price'])) {
        update_post_meta($id_post, 'price', esc_html($_POST['price']));
    }

    if (isset($_POST['surface'])) {
        update_post_meta($id_post, 'surface', esc_html($_POST['surface']));
    }

    if (isset($_POST['beds'])) {
        update_post_meta($id_post, 'beds', esc_html($_POST['beds']));
    }

    if (isset($_POST['baths'])) {
        update_post_meta($id_post, 'baths', esc_html($_POST['baths']));
    }

    if (isset($_POST['note'])) {
        update_post_meta($id_post, 'note', esc_html($_POST['note']));
    }
}

add_action('save_post', 'save_meta_boxe');
