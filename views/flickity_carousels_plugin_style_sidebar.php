<?php
/**
 * @file
 * Defines views style plugins for Flickity carousels.
 */

/**
 * Default carousel type.
 */
class flickity_carousels_plugin_style_sidebar extends views_plugin_style {

  /**
   * {@inheritdoc}
   */
  public function option_definition() {
    $options = parent::option_definition();

    $options['sidebar_pos'] = array('default' => 'right');
    $options['effect'] = array('default' => 'slide');
    $options['autoplay'] = array('default' => 0);
    $options['speed'] = array('default' => 'default');
    $options['button_field'] = array('default' => NULL);

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
      '#markup' => '<div class="form-item">' . t('Flickity carousel with sidebar') . '</div>',
    );

    if ($this->uses_fields()) {
      $field_options = $this->display->handler->get_field_labels(TRUE);
      $form['button_field'] = array(
        '#type' => 'select',
        '#title' => t('Button label field'),
        '#options' => $field_options,
        '#default_value' => $this->options['button_field'],
        '#required' => TRUE,
        '#description' => t('Field content will be used as label for the sidebar buttons.'),
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
    $form['sidebar_pos'] = array(
      '#type' => 'radios',
      '#title' => t('Sidebar position'),
      '#options' => array(
        'right' => t('Right'),
        'left' => t('Left'),
      ),
      '#default_value' => $this->options['sidebar_pos'],
    );
  }

}
