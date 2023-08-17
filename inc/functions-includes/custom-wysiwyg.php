<?php


// create new toolbar

add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars)
{
  // Uncomment to view format of $toolbars

  // echo '< pre >';
  //     print_r($toolbars);
  // echo '< /pre >';
  // die;


  // Add a new toolbar called "Very Simple"
  // - this toolbar has only 1 row of buttons
  $toolbars['Very Simple'] = array();
  $toolbars['Very Simple'][1] = array('bold', 'italic', 'underline', 'formatselect');

  // Edit the "Full" toolbar and remove 'code'
  // - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
  if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
    unset($toolbars['Full'][2][$key]);
  }

  // remove the 'Basic' toolbar completely
  unset($toolbars['Basic']);

  // return $toolbars - IMPORTANT!
  return $toolbars;
}

//add wysiwyg format select options

add_filter('tiny_mce_before_init', function ($init_array) {
  $init_array['formats'] = json_encode([
    // add new format to formats

    'h3marked' => [
      'selector' => 'h3',
      'block'    => 'h3',
      'classes'  => 'heading-3-marked',
      'styles' => array('color' => '#ff0000')
    ],
  ], JSON_THROW_ON_ERROR);

  // remove from that array not needed formats
  $block_formats = [
    'Paragraph=p',
    'Heading 1=h1',
    'Heading 2=h2',
    'Heading 3=h3',
    'Heading 3 marked=h3marked',    // use the new format in select
    'Heading 4=h4',
    'Heading 5=h5',
    'Heading 6=h6',
    'Preformatted=pre',
  ];
  $init_array['block_formats'] = implode(';', $block_formats);

  return $init_array;
});
