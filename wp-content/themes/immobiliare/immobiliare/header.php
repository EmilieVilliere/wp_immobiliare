<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php bloginfo('name') . wp_title('|'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body <?= body_class('bg-gray-200') ?>>
        <?php include 'menu.php'; ?>
