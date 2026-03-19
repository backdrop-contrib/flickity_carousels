<?php
/**
 * @file
 * Documentation for Flickity Carousels API.
 */

/**
 * Implements hook_flickity_carousels_views_styles_flickity_options_alter().
 *
 * Alter library options for Flickity Views styles.
 * Flickity carousel (flickity-carousels-views-default.tpl.php) or
 * Flickity carousel with sidebar (flickity-carousels-views-sidebar.tpl.php).
 * This allows tweaking options not available via admin UI for special
 * use-cases.
 * @see https://flickity.metafizzy.co/options
 *
 * @param array $options
 *   Options for Flickity before converted to JSON attribute string.
 * @param array $context
 *   Some information about the view:
 *   - view_name: Machine name of the view.
 *   - display_id: Name of current display, like 'page' or 'block'.
 *   - is_attachment: Whether the current display is an attachment or not.
 */
function hook_flickity_carousels_views_styles_flickity_options_alter(array &$options, array $context) {
  if ($context['view_name'] == 'my_flickity_view' && $context['display_id'] == 'page') {
    $options['pauseAutoPlayOnHover'] = FALSE;
    $options['friction'] = 0.25;
  }
}
