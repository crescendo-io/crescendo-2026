<header class="main-header" role="banner">
    <nav class="main-navigation">
        <?php
        /*
            wp_nav_menu(array(
                'theme_location' => 'menu-header',
                'menu_id'        => 'menu-header',
                'menu_class'     => 'menu-header',
                'container'       => 'div',
                'container_class' => '',
                'container_id'    => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'item_spacing'    => 'preserve',
                'depth'           => 0,
                'walker'          => '',
            ));
        */
        ?>
        <ul id="menu-header" class="menu-header">
            <li class="menu-item current-menu-item">
                <a href="#">Element 1</a>
            </li>
            <li class="menu-item">
                <a href="#">Element 2</a>
            </li>
            <li class="menu-item">
                <a href="#">Element 3</a>
            </li>
            <li class="menu-item">
                <a href="#">Element 4</a>
            </li>
        </ul>
    </nav>
</header>