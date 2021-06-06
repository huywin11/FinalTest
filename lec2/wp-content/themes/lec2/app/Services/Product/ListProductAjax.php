<?php

/**
 * Created by PhpStorm.
 * User: Lê Cao Huy
 * Date: 1_6_2021
 * Time: 23:00
 */

namespace App\Services\Product;

use App\Services\AbstractService;


/**
 * Class ListProductAjax
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class ListProductAjax extends AbstractService
{

    // public function execute()
    // {
    //     global $wpdb;
    //     // global $wp_query;
    //     // $format_id = isset($_GET['format_id']) ? $_GET['format_id'] : 0;
    //     // $query = <<<EOT
    //     // SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
    //     // WHERE
    //     //   p.post_type = 'product' AND
    //     //     ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value = {$_GET['training_type_id']} ) AND
    //     //     ( mt2.meta_key LIKE 'training_types_%_format' AND mt2.meta_value  = '$format_id' )
    //     // GROUP BY p.id
    //     // EOT;
    //     // global $wpdb;
    //     // global $wp_query;
    //     // $date = isset($_GET['date']) ? $_GET['date'] : 0;
    //     // $to = isset($_GET['to']) ? $_GET['to'] : 0;
    //     // $query = <<<EOT
    //     // SELECT * FROM `wp_postmeta` WHERE (`meta_key` LIKE 'training_types_%_execution_of_training_live_course_dates_0_date' AND `meta_value` >= '$date')
    //     // EOT;
    //     //  $resultdate = $wpdb->get_results($query);
    //     //    // debug($query,true);
    //     // $query = <<<EOT
    //     // SELECT * FROM `wp_postmeta` WHERE
    //     //  (`meta_key` LIKE 'training_types_0_execution_of_training_live_course_dates_1_date' AND `meta_value` LIKE '%$to%')
    //     // EOT;
    //     // // debug($query,true);
    //     // $resultTo = $wpdb->get_results($query);
    //     // // $result[1]->post_id = 834;
    //     // $post_id = array();
    //     // // debug($resultto,true);
    //     // $dateTo = array_merge($resultdate,$resultTo);
    //     // // debug($dateTo,true);
    //     // // foreach ($dateTo as $r) {
    //     // //     $post_id[] = $r->post_id;
    //     // //     $dem = 1;
    //     // //     if($post_id[] == $post_id[]  )
    //     // //     {
    //     // //       echo $post_id[];
    //     // //     }
    //     // //     else {
    //     // //       echo "no";
    //     // //     }
    //     // // }
    //     // foreach ($resultdate as $d) {
    //     //     $datePost_id[] = $d->post_id;
    //     //   }
    //     //     $post_ids = implode(",",$datePost_id);
    //     //     // debug($resultdate,true);
    //     //     foreach ($resultTo as $t) {
    //     //         $toPost_id[] = $t->post_id;
    //     //       }
    //     //
    //     //         $post_id = implode(",",$toPost_id);
    //     //         debug($datePost_id[1]);
    //     //         debug($toPost_id,true);
    //
    //     //         for (int $i = 0; $i < count($datePost_id); $i++) {
    //     //     //       for (int $j = 0; $j < count($toPost_id); $j++) {
    //     //     //     if ($datePost_id[$i] == $toPost_id[$j])
    //     //     //         echo  $datePost_id[$i];
    //     //     // }
    //     // }
    //         // if( $datePost_id == $toPost_id  )
    //         // {
    //         //   // echo $post_ide = implode(",",$post_ids);
    //         //   echo "có";
    //         //
    //         //   break;
    //         // }
    //         // else {
    //         //   echo "no";
    //         // }
    //         // break;
    //
    //
    //     // $post_id = implode(",",$datePost_id);
    //      // debug($toPost_id,true);/
    //
    //     // $query = <<<EOT
    //     // SELECT *  FROM `wp_postmeta` WHERE `meta_id` = ($post_ide)
    //     //
    //     // EOT;
    //     // // debug($query,true);
    //     // $objs = $wpdb->get_results($query);
    //     // debug($objs,true);
    //
    //     // $args = array(
    //     //         'numberposts'   =>  -1,
    //     //         'post_type'   =>  'product',
    //     //         'meta_query'   =>  array(
    //     //             'relation'  =>  'AND',
    //     //             array(
    //     //                 'key'   =>  'training_types_&&_execution_of_training_live_course_dates_&&_date',
    //     //                 'compare'   =>  'BETWEEN',
    //     //                 'value' =>  array($_GET['date_from'],$_GET['date_to']),
    //     //             ),
    //     //             array(
    //     //                 'key'   =>  'training_types_&&_execution_of_training_has_live_course',
    //     //                 'compare'   =>  '=',
    //     //                 'value' =>  1,
    //     //             )
    //     //         )
    //     //     );
    //     //     $objs = get_posts($args);
    //     $query = <<<EOT
    //         SELECT SQL_CALC_FOUND_ROWS  p.ID FROM wp_posts AS p  INNER JOIN wp_postmeta AS mt1 ON ( p.ID = mt1.post_id )  INNER JOIN wp_postmeta AS mt2 ON ( mt1.post_id = mt2.post_id ) WHERE 1=1  AND (
    //         ( mt1.meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_%_date' AND mt1.meta_value BETWEEN '{$_GET['date_from']}' AND '{$_GET['date_to']}' )
    //         AND
    //         ( mt2.meta_key LIKE 'training_types_%_execution_of_training_has_live_course' AND mt2.meta_value = '1' )
    //            AND
    //           (SUBSTR(REPLACE(mt1.meta_key, '_execution_of_training_live_course_dates_', ''),1,16) = REPLACE(mt2.meta_key, '_execution_of_training_has_live_course', ''))
    //          )
    //          AND p.post_type = 'product' AND (p.post_status = 'publish' OR p.post_status = 'acf-disabled' OR p.post_status = 'future' OR p.post_status = 'draft' OR p.post_status = 'pending' OR p.post_status = 'private') GROUP BY p.ID
    //
    //         EOT;
    //
    //         $objs = $wpdb->get_results($query);
    //         // $objs = $wpdb->get_results( $query );
    //         // debug($objs,true);
    //           // $sendContactEmail = new ContactForm();
    //           // debug($sendContactEmail,true);
    //
    //           var genderMaleCheckbox = document.getElementById('acf-field_60b8a4d7f4381');
    //
    //             var isGenderMale = genderMaleCheckbox.checked;// true là đã tick
    //     $returnData = [];
    //     if (is_array($objs) && count($objs) > 0) {
    //         foreach ($objs as $obj) {
    //             $returnData[] = $this->parseData($obj);
    //         }
    //     }
    //
    //     $this->postsFound = $wp_query->found_posts;
    //
    //     wp_reset_postdata();
    //     return $returnData;
    // }

    public function execute()
   {
       global $wpdb, $wp_query;
       if(isset($_GET['from']) || isset($_GET['to'])){
           $costFrom = $_GET['from'];
           $costTo = $_GET['to'];
           if(!isset($_GET['from'])){
               $costFrom = 0;
           }
           $compare = "BETWEEN $costFrom AND $costTo";
           // $args = array(
           //             'numberposts'   =>  -1,
           //             'post_type'   =>  'product',
           //             'meta_query'   =>  array(
           //                 'relation'  =>  'AND',
           //                 array(
           //                     'key'   =>  'training_types_&&_execution_of_training_live_course_dates_&&_date',
           //                     'compare'   =>  'BETWEEN',
           //                     'value' =>  array($_GET['date_from'],$_GET['date_to']),
           //                 ),
           //                 array(
           //                     'key'   =>  'training_types_&&_execution_of_training_has_live_course',
           //                     'compare'   =>  '=',
           //                     'value' =>  1,
           //                 )
           //             )
           //         );
           //         $objs = get_posts($args);
           $query = <<<EOT
           SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
           WHERE
               p.post_type = 'product' AND
               ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value = {$_GET['training_type_id']} ) AND
               ( mt2.meta_key LIKE 'training_types_%_cost' AND lec2_floatval("$,d,Y",mt2.meta_value) $compare) AND
               ( REPLACE(mt1.meta_key, '_training_type', '') = REPLACE(mt2.meta_key, '_cost', '') )
           GROUP BY p.id
           EOT;
       }
       elseif(isset($_GET['date_from']) && isset($_GET['date_to'])){

           $query = "SELECT *,LEFT(REPLACE(`meta_key`,'training_types_','') , 1) as stt FROM wp_postmeta
           WHERE (`meta_key` LIKE 'training_types_%_execution_of_training_live_course_dates_%_date' )
           AND ( `meta_value` BETWEEN '{$_GET['date_from']}' AND '{$_GET['date_to']}')";

           $data = $wpdb->get_results( $query );
            // debug($data,true);
           $objs = array();
           foreach($data as $d)
           {
                     $dem = 0;
                     foreach($objs as $o)
                     {
                         if($o->ID == $d->post_id)
                             {
                                 $dem ++;
                             }
                     }
                     if($exist == 0)
                     {
                         $query = <<<EOT
                         SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt ON p.id = mt.post_id
                         WHERE   post_type = 'product'
                                 AND post_status = 'publish'
                                 AND ID = ('{$d->post_id}')
                                 AND mt.meta_key = 'training_types_{$d->stt}_execution_of_training_has_live_course'
                                 AND mt.meta_value = 1
                         EOT;
                         // $query = <<<EOT
                         //         SELECT SQL_CALC_FOUND_ROWS  p.ID FROM wp_posts AS p  INNER JOIN wp_postmeta AS mt1 ON ( p.ID = mt1.post_id )  INNER JOIN wp_postmeta AS mt2 ON ( mt1.post_id = mt2.post_id ) WHERE 1=1  AND (
                         //         ( mt1.meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_%_date' AND mt1.meta_value BETWEEN '{$_GET['date_from']}' AND '{$_GET['date_to']}' )
                         //         AND
                         //         ( mt2.meta_key LIKE 'training_types_%_execution_of_training_has_live_course' AND mt2.meta_value = '1' )
                         //            AND
                         //           (SUBSTR(REPLACE(mt1.meta_key, '_execution_of_training_live_course_dates_', ''),1,16) = REPLACE(mt2.meta_key, '_execution_of_training_has_live_course', ''))
                         //          )
                         //          AND p.post_type = 'product' AND (p.post_status = 'publish' OR p.post_status = 'acf-disabled' OR p.post_status = 'future' OR p.post_status = 'draft' OR p.post_status = 'pending' OR p.post_status = 'private') GROUP BY p.ID
                         //
                         //         EOT;
                         //
                         //         $objs = $wpdb->get_results($query);
                         $products = $wpdb->get_results( $query );
                          
                         if(!empty($products))
                             {
                                 array_push($objs,$products[0]);
                             }
                     }
           }

       }else
           {
               $objs = [];
           }




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
