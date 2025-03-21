<?php
/**
 * @file
 */

/**
 *
 */
function _flickity_carousels_populate_formatter_form_default(array $field, array $instance, $view_mode) {
  $display = $instance['display'][$view_mode];
  $settings = $display['settings'];
  $element = array();

  if ($field['type'] == 'image') {
    $image_styles = image_style_options(FALSE, PASS_THROUGH);
    $element['image_style'] = array(
      '#type' => 'select',
      '#title' => t('Image style'),
      '#default_value' => $settings['image_style'],
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
    );
    $caption_options = array(
      'none' => t('None'),
      'filename' => t('File name'),
    );
    if ($instance['settings']['alt_field']) {
      $caption_options['alt'] = t('Image alt');
    }
    if ($instance['settings']['title_field']) {
      $caption_options['title'] = t('Image title');
    }
    $element['image_caption'] = array(
      '#type' => 'select',
      '#title' => t('Image caption'),
      '#default_value' => $settings['image_caption'],
      '#options' => $caption_options,
    );
  }

  $element['effect'] = array(
    '#type' => 'radios',
    '#title' => t('Effect'),
    '#options' => array(
      'slide' => t('Slide'),
      'fade' => t('Fade'),
    ),
    '#default_value' => $settings['effect'],
  );
  $element['prevnext'] = array(
    '#type' => 'checkbox',
    '#title' => t('Previous / next buttons'),
    '#default_value' => $settings['prevnext'],
    '#description' => t('Arrow shaped navigation buttons on the left and right side.'),
  );
  $element['pagedots'] = array(
    '#type' => 'checkbox',
    '#title' => t('Dots per slide'),
    '#default_value' => $settings['pagedots'],
    '#description' => t('Small dot shaped buttons below carousel.'),
  );
  $element['perpage'] = array(
    '#type' => 'number',
    '#title' => t('Items per slide'),
    '#min' => 0,
    '#max' => 7,
    '#step' => 1,
    '#field_suffix' => t('items'),
    '#default_value' => $settings['perpage'],
    '#description' => t('Set to zero (0) for "as many items as fit".'),
  );
  $element['moveby'] = array(
    '#type' => 'number',
    '#title' => t('Move by'),
    '#min' => 0,
    '#max' => 7,
    '#step' => 1,
    '#field_suffix' => t('items'),
    '#default_value' => $settings['moveby'],
    '#description' => t('Set to zero (0) to move by the amount of visible items in slide. This setting is ignored with <em>fade</em> effect.'),
  );
  $element['wraparound'] = array(
    '#type' => 'checkbox',
    '#title' => t('Wrap around'),
    '#default_value' => $settings['wraparound'],
    '#description' => t('When the last slide is reached, move on indefinitely. Uncheck to stop at the end. If unchecked, autoplay will still jump back to first item.'),
  );
  $element['freescroll'] = array(
    '#type' => 'checkbox',
    '#title' => t('Free scrolling'),
    '#default_value' => $settings['freescroll'],
    '#description' => t('Freely scroll and flick forward and back without item alignment (no position snapping).'),
  );
  $element['breakpoint'] = array(
    '#type' => 'number',
    '#title' => 'Mobile breakpoint',
    '#min' => 32,
    '#max' => 75,
    '#step' => 1,
    '#default_value' => $settings['breakpoint'],
    '#field_suffix' => t('em viewport width'),
    '#description' => t('If "items per slide" is greater than 1, this is the breakpoint where only single items will be shown per slide. Has no effect otherwise.'),
  );
  $element['cellalignmiddle'] = array(
    '#type' => 'checkbox',
    '#title' => t('Cell content center aligned'),
    '#default_value' => $settings['cellalignmiddle'],
    '#description' => t('Center alignment for cell content, vertically and horizontally. Looks good with images, but odd with teasers.'),
  );
  $element['cellpadding'] = array(
    '#type' => 'checkbox',
    '#title' => t('Cell padding'),
    '#default_value' => $settings['cellpadding'],
    '#description' => t('Horizontal space between items to prevent them sticking to each other. Recommended with text content. Can be overridden via CSS.'),
  );
  $element['direction'] = array(
    '#type' => 'radios',
    '#title' => t('Direction'),
    '#options' => array(
      'ltr' => t('Left to right'),
      'rtl' => t('Right to left'),
      'follow_lang' => t('Follow language direction'),
    ),
    '#default_value' => $settings['direction'],
    '#description' => t('Horizontal direction of slide movement and prev/next button order.'),
    '#description_display' => 'after',
  );
  $element['autoplay'] = array(
    '#type' => 'number',
    '#title' => t('Autoplay'),
    '#min' => 0,
    '#max' => 15,
    '#step' => 1,
    '#field_suffix' => t('Second(s)'),
    '#default_value' => $settings['autoplay'],
    '#description' => t('Set to zero (0) to disable. Time in seconds after which to move on to the next item. Autoplay stops when viewers interact with the carousel.'),
  );
  $element['speed'] = array(
    '#type' => 'radios',
    '#title' => t('Animation speed'),
    '#options' => array(
      'default' => t('Default'),
      'faster' => t('Faster'),
      'slower' => t('Slower'),
    ),
    '#default_value' => $settings['speed'],
    '#description' => t('The speed of side movement or blending. Applies to autoplay, button click and swipe.'),
    '#description_display' => 'after',
  );

  return $element;
}

/**
 *
 */
function _flickity_carousels_populate_formatter_form_gallery(array $field, array $instance, $view_mode) {
  $element = array();
  $display = $instance['display'][$view_mode];
  $settings = $display['settings'];
  $image_styles = image_style_options(FALSE, PASS_THROUGH);
  $element['image_style_main'] = array(
    '#type' => 'select',
    '#title' => t('Image style main'),
    '#default_value' => $settings['image_style_main'],
    '#empty_option' => t('None (original image)'),
    '#options' => $image_styles,
  );
  $element['image_style_thumbs'] = array(
    '#type' => 'select',
    '#title' => t('Image style thumbnails'),
    '#default_value' => $settings['image_style_thumbs'],
    '#empty_option' => t('None (original image)'),
    '#options' => $image_styles,
  );
  $element['effect'] = array(
    '#type' => 'radios',
    '#title' => t('Effect'),
    '#options' => array(
      'slide' => t('Slide'),
      'fade' => t('Fade'),
    ),
    '#default_value' => $settings['effect'],
  );
  $element['prevnext_main'] = array(
    '#type' => 'checkbox',
    '#title' => t('Previous / next buttons for main item'),
    '#default_value' => $settings['prevnext_main'],
  );
  $element['prevnext_thumbs'] = array(
    '#type' => 'checkbox',
    '#title' => t('Previous / next buttons for thumbnails'),
    '#default_value' => $settings['prevnext_thumbs'],
    '#description' => t('Arrow shaped navigation buttons on the left and right side.'),
  );

  return $element;
}
