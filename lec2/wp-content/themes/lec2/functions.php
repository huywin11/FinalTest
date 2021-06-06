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



//  function send_smtp_email( $phpmailer ) {
//    $phpmailer->IsSMTP();
//    $phpmailer->Host       = 'smtp.gmail.com';
//    $phpmailer->Port       = 465;
//    $phpmailer->SMTPAuth   = true;
//    $phpmailer->Username   = 'admin@elinext.com'; // Email bạn dùng đăng ký mật khẩu ứng dụng
//    $phpmailer->Password   = 'admin123456!@#'; // Mật khẩu ứng dụng Gmail
//    $phpmailer->SMTPSecure = "ssl";
//  }
//  add_action( 'phpmailer_init', 'send_smtp_email' );
//
// wp_mail("caohuyle11@gmail.com", "Subject", "Message");


// $query = <<<EOT
// SELECT * FROM `wp_postmeta` WHERE `meta_key` LIKE 'buy_as_gift'
// EOT;
// // SELECT *  FROM `wp_postmeta` WHERE `post_id` = 2170 AND `meta_key` LIKE 'buy_as_gift'
//  $gift = $wpdb->get_results( $query );
//  foreach($gift as $g)
//  {
//                $query = <<<EOT
//                SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt ON p.id = mt.post_id
//                WHERE   post_type = 'product'
//                        AND post_status = 'publish'
//                        AND ID = ('{$g->post_id}')
//                EOT;
//                $products = $wpdb->get_results( $query );
//   }



 // debug($gift);
 // debug($products,true);
 // $coupon_code = "HELLOCODE"; // Code
 //          $amount = '100%'; // Amount
 //          $discount_type = 'percent_product'; // Type: fixed_cart, percent, fixed_product, percent_product
 //          $expDate = date('Y-m-d', strtotime("+90 days"));
 //
 //          $coupon = array(
 //          'post_title' => $coupon_code,
 //          'post_content' => '',
 //          'post_status' => 'publish',
 //          'post_author' => 1,
 //          'post_type' => 'shop_coupon');
 //
 //          $new_coupon_id = wp_insert_post( $coupon );
 //
 //          // Add meta
 //          update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
 //          update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
 //          update_post_meta( $new_coupon_id, 'individual_use', 'no' );
 //          update_post_meta( $new_coupon_id, 'product_ids', '' );
 //          update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
 //          // update_post_meta( $new_coupon_id, 'usage_limit','usage_limit_per_user', "");
 //          update_post_meta( $new_coupon_id, 'usage_limit','1');
 //          update_post_meta( $new_coupon_id, 'expiry_date', $expDate );
 //          update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
 //          update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
 //
 //          function send_smtp_email( $phpmailer ) {
 //            $phpmailer->IsSMTP();
 //            $phpmailer->Host       = 'smtp.gmail.com';
 //            $phpmailer->Port       = 465;
 //            $phpmailer->SMTPAuth   = true;
 //            $phpmailer->Username   = 'admin@elinext.com'; // Email bạn dùng đăng ký mật khẩu ứng dụng
 //            $phpmailer->Password   = 'admin123456!@#'; // Mật khẩu ứng dụng Gmail
 //            $phpmailer->SMTPSecure = "ssl";
 //          }
 //          add_action( 'phpmailer_init', 'send_smtp_email' );
 //
 //          wp_mail("caohuyle11@gmail.com", "Subject", "Hello");
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
  // $coupon_code = "HELLOCODE"; // Code
  //          $amount = '100%'; // Amount
  //          $discount_type = 'percent_product'; // Type: fixed_cart, percent, fixed_product, percent_product
  //          $expDate = date('Y-m-d', strtotime("+90 days"));
  //
  //          $coupon = array(
  //          'post_title' => $coupon_code,
  //          'post_content' => '',
  //          'post_status' => 'publish',
  //          'post_author' => 1,
  //          'post_type' => 'shop_coupon');
  //
  //          $new_coupon_id = wp_insert_post( $coupon );
  //
  //          // Add meta
  //          update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
  //          update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
  //          update_post_meta( $new_coupon_id, 'individual_use', 'no' );
  //          update_post_meta( $new_coupon_id, 'product_ids', '' );
  //          update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
  //          // update_post_meta( $new_coupon_id, 'usage_limit','usage_limit_per_user', "");
  //          update_post_meta( $new_coupon_id, 'usage_limit','1');
  //          update_post_meta( $new_coupon_id, 'expiry_date', $expDate );
  //          update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
  //          update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
  //
  //          function send_smtp_email( $phpmailer ) {
  //            $phpmailer->IsSMTP();
  //            $phpmailer->Host       = 'smtp.gmail.com';
  //            $phpmailer->Port       = 465;
  //            $phpmailer->SMTPAuth   = true;
  //            $phpmailer->Username   = 'admin@elinext.com'; // Email bạn dùng đăng ký mật khẩu ứng dụng
  //            $phpmailer->Password   = 'admin123456!@#'; // Mật khẩu ứng dụng Gmail
  //            $phpmailer->SMTPSecure = "ssl";
  //          }
  //          add_action( 'phpmailer_init', 'send_smtp_email' );
  //
  //          wp_mail("caohuyle11@gmail.com", "Subject", $items);

// debug($items);
    // $query = <<<EOT
    // SELECT *  FROM `wp_postmeta` WHERE `post_id` = $product_id AND `meta_key` LIKE 'buy_as_gift'  AND `meta_value` = '1'
    // EOT;
    //  $gift = $wpdb->get_results( $query );
    // debug($query,true);
// if(isset($gift))
// {
//           $coupon_code = "HELLOCODE"; // Code
//           $amount = '100%'; // Amount
//           $discount_type = 'percent_product'; // Type: fixed_cart, percent, fixed_product, percent_product
//           $expDate = date('Y-m-d', strtotime("+90 days"));
//
//           $coupon = array(
//           'post_title' => $coupon_code,
//           'post_content' => '',
//           'post_status' => 'publish',
//           'post_author' => 1,
//           'post_type' => 'shop_coupon');
//
//           $new_coupon_id = wp_insert_post( $coupon );
//
//           // Add meta
//           update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
//           update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
//           update_post_meta( $new_coupon_id, 'individual_use', 'no' );
//           update_post_meta( $new_coupon_id, 'product_ids', '' );
//           update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
//           // update_post_meta( $new_coupon_id, 'usage_limit','usage_limit_per_user', "");
//           update_post_meta( $new_coupon_id, 'usage_limit','1');
//           update_post_meta( $new_coupon_id, 'expiry_date', $expDate );
//           update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
//           update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
//
//           function send_smtp_email( $phpmailer ) {
//             $phpmailer->IsSMTP();
//             $phpmailer->Host       = 'smtp.gmail.com';
//             $phpmailer->Port       = 465;
//             $phpmailer->SMTPAuth   = true;
//             $phpmailer->Username   = 'admin@elinext.com'; // Email bạn dùng đăng ký mật khẩu ứng dụng
//             $phpmailer->Password   = 'admin123456!@#'; // Mật khẩu ứng dụng Gmail
//             $phpmailer->SMTPSecure = "ssl";
//           }
//           add_action( 'phpmailer_init', 'send_smtp_email' );
//
//           wp_mail("caohuyle11@gmail.com", "Subject", "Message");
// }
//  else {
//    function send_smtp_email( $phpmailer ) {
//      $phpmailer->IsSMTP();
//            $phpmailer->Host       = 'smtp.gmail.com';
//            $phpmailer->Port       = 465;
//            $phpmailer->SMTPAuth   = true;
//            $phpmailer->Username   = 'admin@elinext.com'; // Email bạn dùng đăng ký mật khẩu ứng dụng
//            $phpmailer->Password   = 'admin123456!@#'; // Mật khẩu ứng dụng Gmail
//            $phpmailer->SMTPSecure = "ssl";
//          }
//          add_action( 'phpmailer_init', 'send_smtp_email' );
//
//          wp_mail("caohuyle11@gmail.com", "Subject", "Message");
// }
}
