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
 class GetProductFormat extends AbstractAjax
 {
     protected $functions = [ 'get_products_format' =>  'getProductFormat'];

     /**
      * getMorePartner
      */
     public function getProductFormat(){
       $trainingTypeId = $_GET['training_type_id'];
       $formatID = $_GET['format_id'];
       global $wpdb;
       // $sql = "SELECT `post_title` FROM `wp_posts` WHERE `ID` = '{$formatID}' LIMIT 1";
       // $formats = $wpdb->get_results($sql);
       // debug($formats[0]->post_title);
       if(empty($formats)){
         $products = array();
       }else{
         $query = <<<EOT
         SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
         WHERE
             p.post_type = 'product' AND
             ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value = {$_GET['training_type_id']} ) AND
             ( mt2.meta_key LIKE 'training_types_%_format' AND mt2.meta_id = '{$formatID}')
         GROUP BY p.id
         EOT;

         $products = $wpdb->get_results( $query );
       }




       // debug($query,true);
       wp_send_json([
         'status'  =>  '200',
         'function'  =>  'GetProductsFormat',
         'message' =>  'Successfully',
         'total_items' => count($products),
         'products'  => $products
       ]);
   }
 }



 ?>
