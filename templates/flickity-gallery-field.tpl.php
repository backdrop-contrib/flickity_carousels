<?php
/**
 * @file
 * flickity-gallery-field.tpl.php
 *
 * Available variables:
 * - label: Field label as sanitized string.
 * - label_hidden: Whether to hide or show the label.
 * - wrapper_classes: Array of CSS classes for outermost div.
 * - main_items: Array of images for main section.
 * - main_classes: Array of CSS classes for main section.
 * - main_attributes: Array of HTML attributes for main section.
 * - thumb_items: Array of images for thumbnail section.
 * - thumb_classes: Array of CSS classes for thumbnail section.
 * - thumb_attributes: Array of HTML attributes for thumbnail section.
 * - item_classes: Array of CSS classes for items.
 * - field_name: Machine name of the field.
 *
 * This template supports theme hook suggestions:
 *  - flickity-gallery-field--name--[field name].tpl.php
 *
 * Example template names by type or field name:
 *  - flickity-gallery-field--name--field_myimages.tpl.php
 */
?>
<div class="<?php print implode(' ', $wrapper_classes); ?>">
  <?php if (!$label_hidden) : ?>
    <div class="field-label"><?php print $label; ?>:&nbsp;</div>
  <?php endif; ?>
  <div class="<?php print implode(' ', $main_classes); ?>"<?php print backdrop_attributes($main_attributes); ?>>
    <?php foreach ($main_items as $index => $item) : ?>
    <div class="<?php print implode(' ', $item_classes); ?> item-<?php print $index + 1; ?>"><div class="cell-inner">
      <?php print $item; ?>
    </div></div>
    <?php endforeach; ?>
  </div>
  <div class="<?php print implode(' ', $thumb_classes); ?>"<?php print backdrop_attributes($thumb_attributes); ?>>
    <?php foreach ($thumb_items as $index => $item) : ?>
    <div class="<?php print implode(' ', $item_classes); ?> item-<?php print $index + 1; ?>"><div class="cell-inner">
      <?php print $item; ?>
    </div></div>
    <?php endforeach; ?>
  </div>
</div>
