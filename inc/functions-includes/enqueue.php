<?php

// Styles/scripts enqueue

if (!function_exists('theme_styles')) :

  function theme_styles()
  {
    wp_enqueue_style(
      'theme-styles',
      get_stylesheet_directory_uri() . '/assets/dist/css/main.min.css',
      array(),
      filemtime(get_stylesheet_directory() . '/assets/dist/css/main.min.css'),
    );
  }

endif;

if (!function_exists('theme_scripts')) :

  function theme_scripts()
  {
    if (file_exists(get_stylesheet_directory() . '/assets/dist/js/vendor.min.js')) {
      wp_enqueue_script(
        'vendor-scripts',
        get_stylesheet_directory_uri() . '/assets/dist/js/vendor.min.js',
        false,
        false,
        true
      );
    }

    wp_enqueue_script(
      'theme-script',
      get_stylesheet_directory_uri() . '/assets/dist/js/main.min.js',
      array(),
      filemtime(get_stylesheet_directory() . '/assets/dist/js/main.min.js'),
      true
    );
  }

endif;

function block_script()
{
  wp_enqueue_script(
    'block-script',
    get_stylesheet_directory_uri() . '/inc/template-parts/blocks/table/table.js',
    array('jquery'),
    false,
    true
  );
}

add_action('wp_enqueue_scripts', 'theme_styles');
add_action('wp_enqueue_scripts', 'theme_scripts');
add_action('wp_enqueue_scripts', 'block_script');

/// Hook the enqueue functions into the editor
add_action('enqueue_block_editor_assets', 'theme_styles');
add_action('enqueue_block_editor_assets', 'block_script');
