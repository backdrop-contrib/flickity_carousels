<?php
/**
 * @file
 * Views style plugin template file for Flickity carousels.
 *
 * Available variables:
 * - $rows: Array of items to display.
 * - $classes: Array of CSS classes.
 * - $attributes: Array of HTML attributes.
 *
 * This template supports theme hook suggestions.
 */
?>
<?php if (isset($rows)) : ?>
<div class="<?php print implode(' ', $classes); ?>"<?php print backdrop_attributes($attributes); ?>>
  <?php foreach ($rows as $index => $item) : ?>
  <div class="carousel-item item-<?php print $index + 1; ?>"><div class="cell-inner">
    <?php print $item; ?>
  </div></div>
  <?php endforeach; ?>
</div>
<?php endif; ?>
