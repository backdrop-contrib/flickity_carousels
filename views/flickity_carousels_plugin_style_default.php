<?php
/**
 * @file
 * Defines a views style plugin for Flickity carousels.
 */

/**
 * Default carousel type.
 */
class flickity_carousels_plugin_style_default extends views_plugin_style {

  /**
   * {@inheritdoc}
   */
  public function option_definition() {
    $options = parent::option_definition();

    $options['is_nav'] = array('default' => FALSE, 'bool' => TRUE);
    $options['effect'] = array('default' => 'slide');
    $options['prevnext'] = array('default' => TRUE, 'bool' => TRUE);
    $options['pagedots'] = array('default' => TRUE, 'bool' => TRUE);
    $options['perpage'] = array('default' => 1);
    $options['moveby'] = array('default' => 1);
    $options['wraparound'] = array('default' => FALSE, 'bool' => TRUE);
    $options['freescroll'] = array('default' => FALSE, 'bool' => TRUE);
    $options['breakpoint'] = array('default' => 48);
    $options['cellalignmiddle'] = array('default' => FALSE, 'bool' => TRUE);
    $options['cellpadding'] = array('default' => FALSE, 'bool' => TRUE);
    $options['direction'] = array('default' => 'ltr');
    $options['autoplay'] = array('default' => 0);
    $options['speed'] = array('default' => 'default');

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    if (isset($form['uses_fields'])) {
      // The setting "Force using fields" makes no sense, as this style doesn't
      // even support grouping. It's only confusing.
      $form['uses_fields']['#access'] = FALSE;
    }
    $form['info'] = array(
      '#type' => 'markup',
      '#markup' => '<div class="form-item">' . t('Flickity carousel') . '</div>',
    );

    if (strpos($this->view->current_display, 'attachment_') === 0) {
      $form['is_nav'] = array(
        '#type' => 'checkbox',
        '#title' => t('Is navigation for main carousel'),
        '#default_value' => $this->options['is_nav'],
        '#description' => t('Make this attachment a clickable navigation for Flickity carousels, it is attached to (like block, page).'),
      );
    }

    $form['effect'] = array(
      '#type' => 'radios',
      '#title' => t('Effect'),
      '#options' => array(
        'slide' => t('Slide'),
        'fade' => t('Fade'),
      ),
      '#default_value' => $this->options['effect'],
    );
    $form['prevnext'] = array(
      '#type' => 'checkbox',
      '#title' => t('Previous / next buttons'),
      '#default_value' => $this->options['prevnext'],
      '#description' => t('Arrow shaped navigation buttons on the left and right side.'),
    );
    $form['pagedots'] = array(
      '#type' => 'checkbox',
      '#title' => t('Dots per slide'),
      '#default_value' => $this->options['pagedots'],
      '#description' => t('Small dot shaped buttons below carousel.'),
    );
    $form['perpage'] = array(
      '#type' => 'number',
      '#title' => t('Items per slide'),
      '#min' => 0,
      '#max' => 7,
      '#step' => 1,
      '#field_suffix' => t('items'),
      '#default_value' => $this->options['perpage'],
      '#description' => t('Set to zero (0) for "as many items as fit".'),
    );
    $form['moveby'] = array(
      '#type' => 'number',
      '#title' => t('Move by'),
      '#min' => 0,
      '#max' => 7,
      '#step' => 1,
      '#field_suffix' => t('items'),
      '#default_value' => $this->options['moveby'],
      '#description' => t('Set to zero (0) to move by the amount of visible items in slide. This setting is ignored with <em>fade</em> effect.'),
    );
    $form['wraparound'] = array(
      '#type' => 'checkbox',
      '#title' => t('Wrap around'),
      '#default_value' => $this->options['wraparound'],
      '#description' => t('When the last slide is reached, move on indefinitely. Uncheck to stop at the end. If unchecked, autoplay will still jump back to first item.'),
    );
    $form['freescroll'] = array(
      '#type' => 'checkbox',
      '#title' => t('Free scrolling'),
      '#default_value' => $this->options['freescroll'],
      '#description' => t('Freely scroll and flick forward and back without item alignment (no position snapping).'),
    );
    $form['breakpoint'] = array(
      '#type' => 'number',
      '#title' => 'Mobile breakpoint',
      '#min' => 32,
      '#max' => 75,
      '#step' => 1,
      '#default_value' => $this->options['breakpoint'],
      '#field_suffix' => t('em viewport width'),
      '#description' => t('If "items per slide" is greater than 1, this is the breakpoint where only single items will be shown per slide. Has no effect otherwise.'),
    );
    $form['cellalignmiddle'] = array(
      '#type' => 'checkbox',
      '#title' => t('Cell content center aligned'),
      '#default_value' => $this->options['cellalignmiddle'],
      '#description' => t('Center alignment for cell content, vertically and horizontally. Looks good with images, but odd with teasers.'),
    );
    $form['cellpadding'] = array(
      '#type' => 'checkbox',
      '#title' => t('Cell padding'),
      '#default_value' => $this->options['cellpadding'],
      '#description' => t('Horizontal space between items to prevent them sticking to each other. Recommended with text content. Can be overridden via CSS.'),
    );
    $form['direction'] = array(
      '#type' => 'radios',
      '#title' => t('Direction'),
      '#options' => array(
        'ltr' => t('Left to right'),
        'rtl' => t('Right to left'),
        'follow_lang' => t('Follow language direction'),
      ),
      '#default_value' => $this->options['direction'],
      '#description' => t('Horizontal direction of slide movement and prev/next button order.'),
      '#description_display' => 'after',
    );
    $form['autoplay'] = array(
      '#type' => 'number',
      '#title' => t('Autoplay'),
      '#min' => 0,
      '#max' => 15,
      '#step' => 1,
      '#field_suffix' => t('Second(s)'),
      '#default_value' => $this->options['autoplay'],
      '#description' => t('Set to zero (0) to disable. Time in seconds after which to move on to the next item. Autoplay stops when viewers interact with the carousel.'),
    );
    $form['speed'] = array(
      '#type' => 'radios',
      '#title' => t('Animation speed'),
      '#options' => array(
        'default' => t('Default'),
        'faster' => t('Faster'),
        'slower' => t('Slower'),
      ),
      '#default_value' => $this->options['speed'],
      '#description' => t('The speed of side movement or blending. Applies to autoplay, button click and swipe.'),
      '#description_display' => 'after',
    );
  }
}
