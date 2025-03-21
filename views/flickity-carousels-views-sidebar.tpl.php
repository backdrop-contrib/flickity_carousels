<?php
/**
 * @file
 * Views style plugin template file for Flickity carousels with sidebar.
 *
 * Available variables:
 * - $rows: Array of items to display.
 * - $wrapper_classes: Array of CSS classes for the wrapper div.
 * - $button_labels: Array of strings to use as button text.
 * - $classes: Array of CSS classes for the slider div.
 * - $attributes: Array of HTML attributes for the slider div.
 *
 * This template supports theme hook suggestions.
 */
?>
<?php if (isset($rows)) : ?>
<div class="<?php print implode(' ', $wrapper_classes); ?>">
  <div class="button-sidebar">
    <?php foreach ($button_labels as $index => $label) : ?>
      <button class="toggle" type="button" data-index="<?php print $index; ?>"><?php print $label; ?></button>
    <?php endforeach; ?>
  </div>
  <div class="<?php print implode(' ', $classes); ?>"<?php print backdrop_attributes($attributes); ?>>
    <?php foreach ($rows as $index => $item) : ?>
    <div class="carousel-item item-<?php print $index + 1; ?>"><div class="cell-inner">
      <?php print $item; ?>
    </div></div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>
