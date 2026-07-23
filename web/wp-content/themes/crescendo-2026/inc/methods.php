<?php
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function checkNonce($nonceContext) {
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : 0;
    if (!wp_verify_nonce($nonce, $nonceContext)) {
        exit(__('not authorized', 'domain'));
    }
}

function dateMonthInFr($date) {
    $english_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
    $french_months = array('Janv', 'Févr', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc');
    return str_replace($english_months, $french_months,  $date);
}

function lsdDebugBloc($folder = '', $slug, $name, $args = '') {
    $datasDebug['path'] = 'template-parts/'. $folder . '/' .  $slug .'-'.$name.'.php';
    $datasDebug['args'] = $args;
    return $datasDebug;
}

function lsdGetTemplatePart($folder = '', $slug, $name, $args = '') {
    if (is_plugin_active('lsd-debug-template-part/index.php')) {
        if (LSD_DEBUG === true) {
            $lsdDebugBloc = lsdDebugBloc($folder, $slug, $name, $args);
        }
    }

    if (!empty($args)) {
        set_query_var('args', $args);
    }

    if (isset($lsdDebugBloc)) {
        echo '<div style="border: 1px solid red; padding: 10px">';
        echo '<div style="padding-left: 5px; padding-top: 5px; font-size: 12px; font-weight: 800;">' . $lsdDebugBloc['path'] . '</div>';

        if ($lsdDebugBloc['args']) {
            echo '<div style="padding-top: 5px; padding-left: 5px; font-size: 11px; font-weight: 100; color: green; ">Params :</div>';
            foreach ($lsdDebugBloc['args'] as $key => $arg){
                echo "<div style='padding-left: 5px; font-size: 10px;'>". $key . " : <span style='font-weight: 800;'>". $arg . "</span></div>";
            }
        }
    }

    get_template_part('template-parts/'. $folder . '/' .  $slug .'', $name, $args);

    if (isset($lsdDebugBloc)) {
        echo '</div>';
    }
}
