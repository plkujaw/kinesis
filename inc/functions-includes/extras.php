<?php

/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Theme
 * @since Theme 1.0
 */

/**
 * Clickjacking protection
 *
 * Add header to stop site loading in an iFrame.
 **/
function theme_headers()
{
  header('X-Frame-Options: SAMEORIGIN');
  header('X-UA-Compatible: IE=edge,chrome=1');
  header('Content-Security-Policy: frame-ancestors \'self\'  ;');
}
add_action('send_headers', 'theme_headers', 10);

// Add brand colours to Colour-Picker Pallettes in admin area
function klf_acf_input_admin_footer()
{ ?>
  <script type="text/javascript">
    (function() {
      acf.add_filter('color_picker_args', function(args, $field) {
        // add the hexadecimal codes here for the colors you want to appear as swatches
        args.palettes = ['#000000', '#FFFFFF', '#002D5B', '#1F8649', '#EF3742', '#F4D3D6']
        // return colors
        return args;
      });
    })();
  </script>
<?php }

add_action('acf/input/admin_footer', 'klf_acf_input_admin_footer');

// Disable Notification Emails for Plugin Updates
add_filter('auto_plugin_update_send_email', '__return_false');


// change max width of editor
function wide_editor()
{
  echo '
        <style>
            /* Main column width */
            .wp-block { max-width: 1440px;
          }

        </style>
    ';
}

add_action('admin_head', 'wide_editor');


function get_previous_price_for_symbol($symbol)
{
  if (isset($_COOKIE["previous_prices"][$symbol])) {
    return $_COOKIE["previous_prices"][$symbol];
  } else {
    return null;
  }
}

function set_previous_price_for_symbol($symbol, $price)
{
  $_COOKIE["previous_prices"][$symbol] = $price;
  setcookie("previous_prices[$symbol]", $price, time() + 3600, "/"); // Store the cookie for 1 hour
}

function get_table()
{

  $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
  $parameters = [
    'convert' => 'USD',
    'symbol' => 'BTC,ETH,LTC,USDT,DASH'
  ];

  $headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: 8f432bae-73ca-4905-817f-714a9a15e7eb'
  ];
  $qs = http_build_query($parameters); // query string encode the parameters
  $request = "{$url}?{$qs}"; // create the request URL


  $curl = curl_init(); // Get cURL resource
  // Set cURL options
  curl_setopt_array($curl, array(
    CURLOPT_URL => $request,            // set the request URL
    CURLOPT_HTTPHEADER => $headers,     // set the headers 
    CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
  ));

  $response = json_decode(curl_exec($curl), true); // Send the request, save the response
  $data = $response['data'];

  curl_close($curl); // Close request

  $output = '<table class="table">
            <thead class="table__header">
              <tr class="table__row">
                <th class="table__cell">Coin Details</th>
                <th class="table__cell">Last Price</th>
                <th class="table__cell">24h Change</th>
                <th class="table__cell">Market Cap</th>
                <th class="table__cell">Markets</th>
              </tr>
            </thead>
            <tbody class="table__body">';

  foreach ($data as $symbol => $coin) {
    $symbol = $coin['symbol'];
    $name = $coin['name'];
    $current_price_raw = $coin['quote']['USD']['price'];
    $current_price_preformatted = number_format($current_price_raw, 5, '.', ',');
    $current_price = substr_replace($current_price_preformatted, '000', -3);
    $percent_change_raw = $coin['quote']['USD']['percent_change_24h'];
    $percent_change_value = number_format($percent_change_raw, 2);
    $percent_change_value < 0 ? $percent_change = 'price-down' : $percent_change = 'price-up';
    $market_cap = number_format($coin['quote']['USD']['market_cap'] / 1000000, 2, '.', ',') . "M";
    $icon = "<img src='" . get_template_directory_uri() . '/assets/icons/' . $symbol . '.svg' . "' class='table__icon' width='32' height='32'>";

    $previous_price_raw = get_previous_price_for_symbol($symbol);
    $previous_price_preformatted = number_format($previous_price_raw, 5, '.', ',');
    $previous_price = substr_replace($previous_price_preformatted, '000', -3);
    $price_change_class = 'price-same';

    if ($previous_price !== null) {
      if ($current_price > $previous_price) {
        $price_change_class = 'price-up';
      } elseif ($current_price < $previous_price) {
        $price_change_class = 'price-down';
      }
    }

    $output .= "<tr class='table__row'>";
    $output .= "<td class='table__cell id'>$icon<span class='symbol'>$symbol</span><span class='name'>$name</span></td>";
    $output .= "<td class='table__cell price $price_change_class'>$$current_price</td>";
    $output .= "<td class='table__cell price-change $percent_change'>$percent_change_value%</td>";
    $output .= "<td class='table__cell market-cap'>$$market_cap</td>";
    $output .= "<td class='table__cell graph' data-symbol=$symbol></td>
                </tr>";

    set_previous_price_for_symbol($symbol, $current_price_raw); // Store the current price as previous for next comparison
  }

  $output .= '</tbody>
          </table>';

  return $output;
}
