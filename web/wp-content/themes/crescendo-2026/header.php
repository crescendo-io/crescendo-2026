<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php $favicon_uri = get_template_directory_uri() . '/assets/favicon'; ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($favicon_uri . '/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo esc_url($favicon_uri . '/favicon-32x32.png'); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo esc_url($favicon_uri . '/favicon-16x16.png'); ?>" sizes="16x16">
    <link rel="shortcut icon" href="<?php echo esc_url($favicon_uri . '/favicon.ico'); ?>">
    <link rel="mask-icon" href="<?php echo esc_url($favicon_uri . '/safari-pinned-tab.svg'); ?>" color="#f5e642">
    <link rel="manifest" href="<?php echo esc_url($favicon_uri . '/site.webmanifest'); ?>">
    <meta name="theme-color" content="<?php echo (function_exists('crescendo_uses_studio_design') && crescendo_uses_studio_design()) ? '#f6f4ed' : '#f5e642'; ?>">
    <meta name="msapplication-TileColor" content="#f5e642">
    <meta name="msapplication-config" content="<?php echo esc_url($favicon_uri . '/browserconfig.xml'); ?>">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-module="bugReport">
<?php wp_body_open(); ?>
<div class="site">
