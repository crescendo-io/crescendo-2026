<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php
    if (is_page() && function_exists('crescendo_is_service_page') && crescendo_is_service_page()) {
        $seo = crescendo_get_service_seo();
        $pageTitle = $seo['meta_title'];
        $siteDescription = $seo['meta_description'];
        $skipMetaDescription = true;
    } elseif (is_page() && function_exists('crescendo_is_secteur_page') && crescendo_is_secteur_page()) {
        $seo = crescendo_get_secteur_seo();
        $pageTitle = $seo['meta_title'];
        $siteDescription = $seo['meta_description'];
        $skipMetaDescription = true;
    } elseif (is_front_page()) {
        $pageTitle = get_bloginfo('description') . ' | ' . get_bloginfo('name');
        $siteDescription = 'Crescendo Studio, agence web à Nantes : sites WordPress sur mesure, CRM sur mesure et location dès 350€/mois.';
        $skipMetaDescription = false;
    } else {
        $pageTitle = wp_title('', false) . ' | ' . get_bloginfo('name');
        $siteDescription = 'description';
        $skipMetaDescription = false;
    }
    ?>
    <title><?php echo esc_html($pageTitle); ?></title>
    <?php if (empty($skipMetaDescription)) : ?>
    <meta name="description" content="<?php echo esc_attr($siteDescription); ?>">
    <?php endif; ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/favicon-32x32.png'); ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/favicon-16x16.png'); ?>" sizes="16x16">
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon/favicon.ico'); ?>">
    <meta name="theme-color" content="#f5e642">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-module="bugReport">
<div class="site">
