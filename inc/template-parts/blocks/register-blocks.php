<?php

register_block_type(get_template_directory() . '/inc/template-parts/blocks/cta/block.json');
register_block_type(get_template_directory() . '/inc/template-parts/blocks/hero/block.json');
register_block_type(get_template_directory() . '/inc/template-parts/blocks/perks/block.json');
register_block_type(get_template_directory() . '/inc/template-parts/blocks/table/block.json');
register_block_type(get_template_directory() . '/inc/template-parts/blocks/zig-zag/block.json');

// disable default WordPress blocks and enable only custom blocks

add_filter('allowed_block_types', 'theme_blocks');

function theme_blocks($allowed_blocks)
{
  return array(
    'acf/cta',
    'acf/hero',
    'acf/perks',
    'acf/table',
    'acf/zig-zag',
  );
}
