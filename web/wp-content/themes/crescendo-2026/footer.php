<?php

?>
                    <footer class="main-footer" role="contentinfo" data-module="footer" data-context="@visible true">
                        <?php
                        /*
                            wp_nav_menu(array(
                                'theme_location' => 'menu-footer',
                                'menu_id'        => 'menu-footer',
                                'menu_class'     => 'menu-footer',
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

                        <ul id="menu-footer" class="menu-footer">
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
                    </footer>
                    
                    <?php
                        // $ga_id = get_field('params_id_google_analytics', 'option');
                        // if($ga_id && ENV_PROD):
                    ?>
                    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=<?php // echo $ga_id; ?>"></script>
                    <script>
                        if (getCookie('hasConsent') == 'true') {
                            window.dataLayer = window.dataLayer || [];
                            function gtag() {
                                dataLayer.push(arguments);
                            }

                            gtag('js', new Date());
                            gtag('config', '<?php // echo $ga_id; ?>');
                        }
                    </script> -->
                    <?php // endif; ?>

                    <?php wp_footer(); ?>
                </div>
            </div>
        </div>
    </body>
</html>