<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/favicon-32x32.png'); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/favicon-16x16.png'); ?>" sizes="16x16">
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/favicon.ico'); ?>">
    <meta name="theme-color" content="#f5e642">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-module="bugReport">
<div class="site">
