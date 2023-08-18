<?php

/**
 * Zig-Zag Block
 * 
 */

$title = get_field('zigzag_title');
$subheader = get_field('zigzag_subtitle');
$image = get_field('zigzag_image');
$rows = get_field('zigzag_rows');
$cta = get_field('zigzag_cta');
?>

<section class="zigzag-block acf-block">
  <div class="container">
    <div class="zigzag-block__inner">
      <div class="column">
        <div class="zigzag-block__heading block-heading">
          <h2 class="header"><?php echo $title; ?></h2>
          <p class="subheader"><?php echo $subheader; ?></p>
        </div>
        <div class="zigzag-block__rows">
          <?php foreach ($rows as $row) {
            $icon = $row['icon'];
            $title = $row['title'];
            $subtitle = $row['subtitle'];
          ?>
            <div class="row">
              <div class="row__icon">
                <img src="<?php echo $icon['url']; ?>">
              </div>
              <div class="row__text">
                <div class="row__title item-title">
                  <h3><?php echo $title; ?></h3>
                </div>
                <div class="row__subtitle item-subtitle">
                  <p><?php echo $subtitle; ?></p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <a href="<?php echo $cta['url']; ?>" class="link-arrow"><?php echo $cta['title']; ?></a>
      </div>
      <div class="column zigzag-block__image">
        <?php echo wp_get_attachment_image($image, 'entry') ?>
      </div>
    </div>
  </div>
</section>