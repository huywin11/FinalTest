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
class ListProductFormat extends AbstractService
{

    public function execute()
    {
        // global $wpdb;
        // global $wp_query;
        // $format_id = isset($_GET['format_id']) ? $_GET['format_id'] : 0;
        // $query = <<<EOT
        // SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
        // WHERE
        //   p.post_type = 'product' AND
        //     ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value = {$_GET['training_type_id']} ) AND
        //     ( mt2.meta_key LIKE 'training_types_%_format' AND mt2.meta_value  = '$format_id' )
        // GROUP BY p.id
        // EOT;
        global $wpdb;
        global $wp_query;
        $date = isset($_GET['date']) ? $_GET['date'] : 0;
        $to = isset($_GET['to']) ? $_GET['to'] : 0;
        $query = <<<EOT
        SELECT * FROM `wp_postmeta` WHERE `meta_key` LIKE 'execution_of_training_live_course_dates_%_date' AND `meta_value` BETWEEN '$date' AND '$to'
        GROUP BY post_id
        EOT;
        // debug($query,true);
        $result = $wpdb->get_results($query);
        // $result[1]->post_id = 834;
        $post_id = array();
        // debug($result,true);
        foreach ($result as $r) {
            $post_id[] = $r->post_id;
        }

        $post_id = implode(",",$post_id);
         // debug($post_id,true);

        $query = <<<EOT
        SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
         WHERE
           p.post_type = 'product' AND
             ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value IN ($post_id) )
        EOT;
        // debug($query,true);
        $objs = $wpdb->get_results($query);
        debug($objs,true);

        // $value = array(
        //   'format' =  $objs->post_title,
        //   'post_type' = 'format'
        // );
        // $parse = query_posts($value);
        // debug($objs[0],true);
        // $format = $objs['custom_data']['training_types']['format']->post_title;
        $returnData = [];
        // $returnData[] = array('format' =>  $objs);
        // debug($objs[0],true);
        // debug($returnData,true);

        if (is_array($objs) && count($objs) > 0) {
            foreach ($objs as $obj) {
                $returnData[] = $this->parseData($obj);
            }
        }

        $this->postsFound = $wp_query->found_posts;

        wp_reset_postdata();
        return $returnData;
    }
}
