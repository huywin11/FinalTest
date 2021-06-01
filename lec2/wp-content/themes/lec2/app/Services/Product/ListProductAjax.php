<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019-07-29
 * Time: 17:00
 */

namespace App\Services\Product;

use App\Services\AbstractListingAjax;
use App\Services\Helper;

/**
 * Class ListTrainings
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListProductAjax extends AbstractListingAjax
{


    public function execute()
    {
        global $wp_query,$wpdb;
       $cost = $_GET['cost_form'];
       $cost = floatval($cost);
         $query = <<<EOT
         SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
         WHERE
           p.post_type = 'product' AND
             ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value = {$_GET['training_type_id']} ) AND
             ( mt2.meta_key LIKE 'training_types_%_cost' AND   lec2_floatval("$,%,#",mt2.meta_value) > '{$cost}' ) AND
             ( REPLACE(mt1.meta_key, '_training_type', '') = REPLACE(mt2.meta_key, '_cost', '') )
         GROUP BY p.id
         EOT;
         $format = array(
             // 'post_title'    => $fText->meta_value,
             'post_status'   => 'publish',
             'post_author'   => 1,
             'post_type' => 'product'
         );
         $objs = $wpdb->get_results( $query );
         // debug($objs,true);
         $returnData = [];
         if(is_array($objs) && count($objs) > 0){
             foreach ($objs as $obj){
                 $returnData[] = $this->parseData($obj);
             }
         }
         $this->postsFound = $wp_query->found_posts;
         wp_reset_postdata();
         return $returnData;
    }
    
}
