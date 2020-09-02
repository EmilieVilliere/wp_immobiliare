<nav class="flex items-center justify-between flex-wrap bg-teal-500 p-2 mb-8">
  <div class="flex items-center flex-shrink-0 text-white mr-6">
    <a href="<?= home_url() ?>">
      <?php
        $custom_logo_url = wp_get_attachment_url(get_theme_mod('custom_logo'));
      ?>
      <?php if ($custom_logo_url) { ?>
        <img class="h-12" src="<?= $custom_logo_url ?>" alt="<?php bloginfo('name'); ?>">
      <?php } else { ?>
        <span class="font-semibold text-xl tracking-tight"><?php bloginfo('name'); ?></span>
      <?php } ?>
    </a>
  </div>
  <div class="block lg:hidden">
    <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white" id="hamburger">
      <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    </button>
  </div>
  <div class="w-full hidden lg:block flex-grow lg:flex lg:items-center lg:w-auto" id="menu">
    <div class="text-md lg:flex-grow">
        <?php wp_nav_menu([
            'theme_location' => 'main-menu',
            // 'menu_class' => 'TEST',
        ]); ?>
    </div>
    <div>
      <a href="<?= get_post_type_archive_link('housing'); ?>" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
        Voir nos annonces
      </a>
    </div>
  </div>
</nav>
