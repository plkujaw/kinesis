<?php

/**
 * Hero Block
 * 
 */
$background_image = get_field('hero_background_image');
$decorative_text = get_field('hero_decorative_text');
$title = get_field('hero_title');
$subheader = get_field('hero_subheader');
$buttons = get_field('hero_buttons');
?>

<section class="hero-block acf-block">
  <div class="hero-block__bg block-bg">
    <?php echo wp_get_attachment_image($background_image, 'hero'); ?>
  </div>
  <div class="container">
    <div class="hero-block__content">
      <span><?php echo $decorative_text; ?></span>
      <h1><?php echo $title; ?></h1>
      <p class="subheader subheader--light"><?php echo $subheader; ?></p>
      <div class="buttons">
        <?php foreach ($buttons as $button) : ?>
          <a href="<?php echo $button['url']; ?>" class="btn"><?php echo $button['title']; ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>