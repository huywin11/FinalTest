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

/**
* Create a coupon programatically
*/
$coupon_code = 'Huy'; // Code
$amount = '100%'; // Amount
$discount_type = 'percent_product'; // Type: fixed_cart, percent, fixed_product, percent_product

$coupon = array(
'post_title' => $coupon_code,
'post_content' => '',
'post_status' => 'publish',
'post_author' => 1,
'post_type' => 'shop_coupon');

$new_coupon_id = wp_insert_post( $coupon );

// Add meta
update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
update_post_meta( $new_coupon_id, 'individual_use', 'no' );
update_post_meta( $new_coupon_id, 'product_ids', '' );
update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
update_post_meta( $new_coupon_id, 'usage_limit', '' );
update_post_meta( $new_coupon_id, 'expiry_date', '' );
update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

add_action( 'woocommerce_email_after_order_table', 'mm_email_after_order_table', 10, 4 );
function mm_email_after_order_table( $order, $sent_to_admin, $plain_text, $email ) {
       echo "<p> Hey! Thanks for shopping with us. As a way of saying thanks, here’s a coupon code for your next purchase: FRESH15</p>";}



 function send_smtp_email( $phpmailer ) {
   $phpmailer->IsSMTP();
   $phpmailer->Host       = 'smtp.gmail.com';
   $phpmailer->Port       = 465;
   $phpmailer->SMTPAuth   = true;
   $phpmailer->Username   = 'admin@elinext.com'; // Email bạn dùng đăng ký mật khẩu ứng dụng
   $phpmailer->Password   = 'admin123456!@#'; // Mật khẩu ứng dụng Gmail
   $phpmailer->SMTPSecure = "ssl";
 }
 add_action( 'phpmailer_init', 'send_smtp_email' );
wp_mail("caohuyle11@gmail.com", "Subject", "Message");
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
