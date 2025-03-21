<?php
/**
 * @file
 */

/**
 * Implements hook_views_plugins().
 */
function flickity_carousels_views_plugins() {
  $path = backdrop_get_path('module', 'flickity_carousels');
  $plugins['style'] = array(
    'flickity_carousels_default' => array(
      'path' => $path . '/views',
      'type' => 'normal',
      'title' => 'Flickity carousel',
      'handler' => 'flickity_carousels_plugin_style_default',
      'theme' => 'flickity_carousels_views_default',
      'theme file' => 'flickity_carousels.theme.inc',
      'theme path' => $path . '/views',
      'uses options' => TRUE,
      'uses fields' => FALSE,// Misleading name - "uses custom fields".
      'uses row plugin' => TRUE,
      'uses row class' => FALSE,
      'uses grouping' => FALSE,
    ),
    'flickity_carousels_sidebar' => array(
      'path' => $path . '/views',
      'type' => 'normal',
      'title' => 'Flickity carousel with sidebar',
      'handler' => 'flickity_carousels_plugin_style_sidebar',
      'theme' => 'flickity_carousels_views_sidebar',
      'theme file' => 'flickity_carousels.theme.inc',
      'theme path' => $path . '/views',
      'uses options' => TRUE,
      'uses fields' => FALSE,
      'uses row plugin' => TRUE,
      'uses row class' => FALSE,
      'uses grouping' => FALSE,
    ),
  );
  return $plugins;
}
