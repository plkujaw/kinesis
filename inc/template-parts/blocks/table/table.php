<?php

/**
 * CTA Block
 * 
 */
$title = get_field('table_title');
$tabs = get_field('table_tabs');
$cta = get_field('table_cta');

?>


<section class="table-block acf-block">
  <div class="container">
    <div class="table-block__heading block-heading">
      <h2><?php echo $title; ?></h2>
    </div>
    <div class="table-block__tabs">
      <div class="tabs">
        <?php
        $count = 0;
        foreach ($tabs as $tab) {
          $count++;
          $title = $tab['title'];
        ?>
          <button class="tablink<?php echo $count == 1 ? ' active' : '' ?>"><?php echo $title; ?></button>
        <?php } ?>
      </div>
      
      <?php
      $count = 0;
      foreach ($tabs as $tab) {
        $count++;
        $content = $tab['content'];
      ?>
        <div id="tab-<?php echo $count ?>" class="tabcontent<?php echo $count == 1 ? ' active' : '' ?>">
          <?php echo $count == 1 ? get_table() : $content; // function in inc/functions-includes/extras.php 
          ?>
        </div>
      <?php } ?>
    </div>
    <div class="table-block__cta buttons buttons--centre">
      <a href="<?php echo $cta['url']; ?>" class="btn btn--gradient"><?php echo $cta['title']; ?></a>
    </div>
  </div>
</section>