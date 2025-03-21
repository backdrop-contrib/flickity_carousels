<?php
/**
 * @file
 * flickity-carousel-field.tpl.php
 *
 * Available variables:
 *  - label: Field label as sanitized string.
 *  - label_hidden: Whether to hide or show the label.
 *  - items: Array of field items to display.
 *  - wrapper_classes: Array of CSS classes for the outermost div.
 *  - carousel_classes: Array of CSS classes for the carousel div.
 *  - carousel_attributes: Array of HTML attributes.
 *  - item_classes: Array of CSS classes for all items.
 *  - field_type: Machine name of the field type.
 *  - field_name: Machine name of the field.
 *
 * This template supports theme hook suggestions:
 *  - flickity-carousel-field--type--[field type].tpl.php
 *  - flickity-carousel-field--name--[field name].tpl.php
 *
 * Example template names by type or field name:
 *  - flickity-carousel-field--type--text_long.tpl.php
 *  - flickity-carousel-field--name--field_myimages.tpl.php
 */
?>
<div class="<?php print implode(' ', $wrapper_classes); ?>">
  <?php if (!$label_hidden) : ?>
    <div class="field-label"><?php print $label; ?>:&nbsp;</div>
  <?php endif; ?>
  <div class="<?php print implode(' ', $carousel_classes); ?>"<?php print backdrop_attributes($carousel_attributes); ?>>
    <?php foreach ($items as $index => $item) : ?>
    <div class="<?php print implode(' ', $item_classes); ?> item-<?php print $index + 1; ?>"><div class="cell-inner">
      <?php print $item; ?>
    </div></div>
    <?php endforeach; ?>
  </div>
</div>
