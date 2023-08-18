<?php

/**
 * CTA Block
 * 
 */
$background_image = get_field('cta_background_image');
$text = get_field('cta_text');
$button = get_field('cta_button');
?>

<section class="cta-block acf-block">
  <div class="cta-block__bg block-bg">
    <?php echo wp_get_attachment_image($background_image, 'hero'); ?>
  </div>
  <div class="container">
    <div class="cta-block__content">
      <h2><?php echo $text; ?></h2>
      <a href="<?php echo $button['url']; ?>" class="btn btn--gradient"><?php echo $button['title']; ?></a>
    </div>
  </div>
</section>