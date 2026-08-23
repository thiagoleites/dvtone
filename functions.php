<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acesso direto ao arquivo
}


define( 'DVTONE_THEME_VERSION', '1.0.0' );
define( 'DVTONE_THEME_DIR', get_template_directory() );
define( 'DVTONE_THEME_URI', get_template_directory_uri() );

require_once DVTONE_THEME_DIR . '/functions/setup.php';
require_once DVTONE_THEME_DIR . '/functions/enqueue.php';
require_once DVTONE_THEME_DIR . '/functions/customizer.php';
require_once DVTONE_THEME_DIR . '/functions/shortcodes.php';
require_once DVTONE_THEME_DIR . '/functions/template-tags.php';
require_once DVTONE_THEME_DIR . '/functions/portfolio-cpt.php';
/*
require_once DVTONE_THEME_DIR . '/functions/widgets.php';
require_once DVTONE_THEME_DIR . '/functions/hooks.php';
require_once DVTONE_THEME_DIR . '/functions/ajax.php';
require_once DVTONE_THEME_DIR . '/functions/filters.php';
require_once DVTONE_THEME_DIR . '/functions/actions.php';
require_once DVTONE_THEME_DIR . '/functions/custom-post-types.php';
*/