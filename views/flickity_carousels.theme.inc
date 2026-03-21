<?php
/**
 * @file
 * Views theme preprocessors for Flickity carousels module.
 */

/**
 * Preprocess flickity-carousels-views-default.tpl.php
 */
function template_preprocess_flickity_carousels_views_default(&$variables) {
  $view = $variables['view'];
  $unique_class = 'flickity-' . $view->name . '-' . $view->current_display;
  $variables['classes'] = array('flickity-carousel', $unique_class);
  $settings = $variables['options'];

  if ($settings['perpage']) {
    $variables['classes'][] = 'perpage-' . $settings['perpage'];
  }
  if ($settings['cellalignmiddle']) {
    $variables['classes'][] = 'center-align';
  }
  if ($settings['cellpadding']) {
    $variables['classes'][] = 'cell-padding';
  }
  $variables['classes'][] = 'direction-' . $settings['direction'];

  // Options to hand over to Flickity via data attribute.
  $flk_options = _flickity_carousels_options_from_settings($settings);

  if (!empty($view->is_attachment) && !empty($view->old_view) && $settings['is_nav']) {
    // Within attachments $old_view seems to contain the parent view.
    // Unclear, how reliable that is, but there's no other child->parent
    // relationship available in views, it seems.
    $parent_view_display_id = '';
    // @todo is the one we want always the last? end()? or [1]?
    foreach ($view->old_view as $old_view) {
      if (!empty($old_view) && $old_view->style_plugin->plugin_name == 'flickity_carousels_default') {
        $parent_view_display_id = $old_view->current_display;
      }
    }
    if (!empty($parent_view_display_id)) {
      $flk_options['asNavFor'] = '.flickity-' . $view->name . '-' . $parent_view_display_id;
    }
  }

  // Let modules alter options for the Flickity library.
  $context = array(
    'view_name' => $view->name,
    'display_id' => $view->current_display,
    'is_attachment' => !empty($view->is_attachment),
  );
  backdrop_alter('flickity_carousels_views_styles_flickity_options', $flk_options, $context);

  $variables['attributes']['data-flickity-options'] = json_encode($flk_options);

  backdrop_add_library('flickity_carousels', 'backdrop.flickity');
}

/**
 * Preprocess flickity-carousels-views-sidebar.tpl.php
 */
function template_preprocess_flickity_carousels_views_sidebar(&$variables) {
  $view = $variables['view'];
  $settings = $variables['options'];

  $variables['wrapper_classes'] = array('flickity-carousel-sidebar-wrapper');
  $variables['wrapper_classes'][] = 'flickity-' . $view->name . '-' . $view->current_display;
  $variables['wrapper_classes'][] = 'sidebar-' . $settings['sidebar_pos'];
  $variables['classes'] = array('flickity-carousel');
  $variables['classes'][] = 'perpage-1';

  $flk_options = array(
    'breakpoint' => 0,
    'resize' => FALSE,
    'pageDots' => FALSE,
    'prevNextButtons' => FALSE,
    'fade' => ($settings['effect'] == 'fade'),
    'wrapAround' => TRUE,
  );
  if ($settings['autoplay'] > 0) {
    $flk_options['autoPlay'] = $settings['autoplay'] * 1000;
  }
  global $language;
  $flk_options['rightToLeft'] = ($language->direction == LANGUAGE_RTL);

  $variables['button_labels'] = array();
  if ($view->style_plugin->uses_fields()) {
    $field_name = $settings['button_field'];
    foreach ($view->result as $index => $record) {
      $field_output = $view->style_plugin->get_field($index, $field_name);
      // Buttons shouldn't contain markup.
      // The fallback is important, because views can't enforce required
      // fields of a display setting in the base views form. And field values
      // might be empty, too.
      $variables['button_labels'][$index] = ($field_output) ? strip_tags($field_output) : $index + 1;
    }
  }
  else {
    $row_plugin = $view->style_plugin->row_plugin;
    // @todo is there a more generic way to handle this?
    if (is_a($row_plugin, 'views_plugin_row_node_view')) {
      // Caution: the "nodes" propery might not be public forever.
      $nodes = $row_plugin->nodes;
      foreach ($nodes as $nid => $node) {
        $variables['button_labels'][] = check_plain($node->label());
      }
    }
    elseif (is_a($row_plugin, 'views_plugin_row_user_view')) {
      $users = $row_plugin->users;
      foreach ($users as $uid => $user) {
        $variables['button_labels'][] = check_plain($user->label());
      }
    }
    else {
      // Module entity_plus doesn't do us the favor with a public property.
      // We don't even get the entity type, so we can't do entity_load().
      foreach ($view->result as $index => $values) {
        $variables['button_labels'][] = $index + 1;// Generic fallback.
      }
    }
  }
  // Let modules alter options for the Flickity library.
  $context = array(
    'view_name' => $view->name,
    'display_id' => $view->current_display,
    'is_attachment' => !empty($view->is_attachment),
  );
  backdrop_alter('flickity_carousels_views_styles_flickity_options', $flk_options, $context);

  $variables['attributes']['data-flickity-options'] = json_encode($flk_options);

  backdrop_add_library('flickity_carousels', 'backdrop.flickity');
}
