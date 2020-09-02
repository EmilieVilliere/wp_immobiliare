<?php

/*
Plugin Name: Merry Christmas
Plugin URI: https://wp.boxydev.com/plugins/merry-christmas
Description: An amazing plugin.
Author: Matthieu Mota
Author URI: https://matthieumota.fr
Version: 1.0.0
*/

function snowfall_script() {
    wp_enqueue_script(
        'snowfall',
        'https://cdnjs.cloudflare.com/ajax/libs/JQuery-Snowfall/1.7.4/snowfall.jquery.min.js',
        ['jquery'],
        false,
        true
    );
}

add_action('wp_enqueue_scripts', 'snowfall_script');

// Configurer le JS du plugin
add_action('wp_print_scripts', function () {
    ob_start(); ?>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            // var $ = jQuery;
            $(document).snowfall({
                flakeColor: '<?= get_option('snowfall_color'); ?>',
                flakeCount: 100,
                maxSize: 5,
                round: true,
            });
        });
    </script>

    <?php
        echo ob_get_clean();
});

// Ajout d'une page d'options
function snowfall_menu() {
    add_options_page('Snowfall options', 'Snowfall', 'manage_options', 'snowfall', 'snowfall_options');
    register_setting('snowfall', 'snowfall_color');
}

function snowfall_options() { ?>
    <div>
        <h1>Snowfall options</h1>

        <form method="POST" action="options.php">
            <?php settings_fields('snowfall'); ?>
            <input type="text" name="snowfall_color" value="<?= get_option('snowfall_color'); ?>">

            <?php submit_button(); ?>
        </form>
    </div>
<?php }

add_action('admin_menu', 'snowfall_menu');
