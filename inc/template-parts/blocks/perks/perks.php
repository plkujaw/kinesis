<?php

/**
 * Perks Block
 * 
 */
$title = get_field('perks_title');
$subheader = get_field('perks_subtitle');
$cards = get_field('perks_cards');
$buttons = get_field('perks_buttons');
?>

<section class="perks-block acf-block">
  <div class="container">
    <div class="perks-block__heading block-heading">
      <h2 class="header"><?php echo $title; ?></h2>
      <p class="subheader"><?php echo $subheader; ?></p>
    </div>
    <div class="perks-block__cards">
      <?php foreach ($cards as $card) {
        $icon = $card['icon'];
        $title = $card['title'];
        $subtitle = $card['subtitle'];
      ?>
        <div class="card">
          <div class="card__icon">
            <img src="<?php echo $icon['url']; ?>" width="64" height="64">
          </div>
          <div class="card__title item-title">
            <h3><?php echo $title; ?></h3>
          </div>
          <div class="card__subtitle item-subtitle">
            <p><?php echo $subtitle; ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="buttons buttons--centre">
      <?php foreach ($buttons as $button) : ?>
        <a href="<?php echo $button['url']; ?>" class="btn"><?php echo $button['title']; ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>