<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-08-14
 * Time: 16:33
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Training\ListTrainingsAjax;
use App\Services\Product\ListProductAjax;
use App\Services\Product\ListProductFormat;
/**
 * Class GetPartnerListing - Get more partner
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetFormat  extends AbstractAjax
{
    protected $functions = [ 'get_format' =>  'getFormat'];

    /**
     * getMorePartner
     */
    public function getFormat(){

     global  $wpdb;
      // $query = <<<EOT
      // SELECT DISTINCT(post_title),ID FROM wp_posts
      // WHERE
      // post_type = 'format' AND
      // `post_status` LIKE 'publish' AND
      // post_title != 'Auto Draft' LIMIT 0, 25
      //
      // EOT;

      $query =  array(
          'post_title'    => "",
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type' => 'format'
      );
      // $args = array(
      //   'post_type'      => 'Format',
      //   'post'     =>       "",
      //        );

      // $getformat = $wpdb->get_results( $query );
      $getformat = query_posts( $query );
      // $h = $products['post_title'];
      // debug($getformat,true);
      wp_send_json([
     'function'  =>  'GetFormat ',
      'total_items' => count($getformat),
     'products'  => $getformat,]);
    }

}
