<?php
/**
 * Ensure dependencies are loaded
 */
const LEC2_DOMAIN = 'lec2';

$error_text = function ($message) {
    wp_die($message);
};

if (!file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    $error_text(sprintf(__('You must run <code>composer install</code> in %s theme folder, Autoloader not found !!!', LEC2_DOMAIN), LEC2_DOMAIN));
}
require_once $composer;

array_map(function ($file) use ($error_text) {
    $file = "/app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $error_text(sprintf(__('Error locating <code>%s</code> for inclusion.', LEC2_DOMAIN), $file));
    }
}, ['App','TwigLoader']);

\App\Container::getInstance()->bindConfig('config', [
    'assets' => require get_template_directory().'/config/assets.php',
    'theme' => require get_template_directory().'/config/theme.php',
    'view' => require get_template_directory().'/config/view.php',
])->bindApp();

/*--------------------------------------------------------------------------------------------------------------------*/



add_action( 'woocommerce_email_after_order_table', 'mm_email_after_order_table', 10, 4 );
function mm_email_after_order_table( $order, $sent_to_admin, $plain_text, $email ) {
       echo "<p> Hey! Thanks for shopping with us. As a way of saying thanks, here’s a coupon code for your next purchase: FRESH15</p>";}




/**
 * This is used for debug
 *
 * @param $var
 * @param $isDie
 */
function debug($var, $isDie = false) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';

    if ($isDie) {
        die;
    }
}


add_action('woocommerce_checkout_order_processed', 'enroll_student', 10, 1);

function enroll_student($order_id)
{
  /**
  * Create a coupon programatically
  */


  $order = wc_get_order( $order_id );
  $items = $order->get_items();

  foreach ($items as $item) {
     $product_id = $item->get_product_id();
    // $product_id = $item['product_id'];
     break;
  }
