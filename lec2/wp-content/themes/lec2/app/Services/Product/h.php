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
  public function getTimeZone(){ ?>
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
         <script type="text/javascript">
         function createCookie(e,t,o){var i;if(o){var n=new Date;n.setTime(n.getTime()+24*o*60*60*1e3),i="; expires="+n.toGMTString()}else i="";url=window.location.href,document.cookie=escape(e)+"="+escape(t)+i+"; path="+url}$(document).ready(function(){createCookie("time_zone_client",Intl.DateTimeFormat().resolvedOptions().timeZone,"1")});
         </script>
         <?php
         return $_COOKIE["time_zone_client"];
     }
     public function to_hour($datetime){
      $datetime = str_replace("/","-",$datetime);
      $date = substr($datetime, 0, 10);
      $hours = substr($datetime, 11, 2);
      $minutes = substr($datetime, 14, 2);
      $seconds = '00';
      $meridiem = (strtolower($meridiem)=='am') ? 'am' : 'pm';
      return $date.date(' H:i:s', strtotime("{$hours}:{$minutes}:{$seconds} {$meridiem}"));
    }

     public function getTimeZoneWPSetting(){
         $timezoneWPSetting = wp_timezone_string();

         if (strpos($timezoneWPSetting, '/') === false) {
             $tz_offset = get_option('gmt_offset');
             switch($tz_offset){
                 case -12:   $timezoneWPSetting = 'Etc/GMT+12';break;
                 case -11.5: $timezoneWPSetting = 'Etc/GMT+11.5';break;
                 case -11:   $timezoneWPSetting = 'Etc/GMT+11';break;
                 case 12.75: $timezoneWPSetting = 'Pacific/Chatham';break;
                 case 13:    $timezoneWPSetting = 'Pacific/Chatham';break;
                 case 13.75: $timezoneWPSetting = 'Pacific/Chatham';break;
                 case 14:    $timezoneWPSetting = 'Pacific/Kiritimati';break;
                 default:    $timezoneWPSetting = timezone_name_from_abbr("", $tz_offset * 3600, false);
             }
         }
         return $timezoneWPSetting;
     }

     public function execute()
     {
         global $wpdb, $wp_query;
         if(isset($_GET['cost_from']) || isset($_GET['cost_to'])){
             $costFrom = $_GET['cost_from'];
             $costTo = $_GET['cost_to'];
             if(!isset($_GET['cost_from'])){
                 $costFrom = 0;
             }
             $compare = "BETWEEN $costFrom AND $costTo";

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
             $time_zone_client = $this->getTimeZone();
             $timezoneWPSetting = $this->getTimeZoneWPSetting();


             $date_from = date_create($_GET['date_from'], timezone_open($time_zone_client));
             date_timezone_set($date_from, timezone_open($timezoneWPSetting));
             $date_from = $date_from->format('Y-m-d H:i:s');

             $date_to = date_create($_GET['date_to'], timezone_open($time_zone_client));
             date_timezone_set($date_to, timezone_open($timezoneWPSetting));
             $date_to = $date_to->format('Y-m-d H:i:s');

             $query = <<<EOT
             SELECT p.ID,mt1.meta_value FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON ( p.ID = mt1.post_id )
             LEFT JOIN wp_postmeta AS mt2 ON ( mt1.post_id = mt2.post_id )
             WHERE ( ( mt1.meta_key LIKE 'training_types_%_execution_of_training_live_course_dates_%_date'
             AND mt1.meta_value BETWEEN '{$date_from}' AND '{$date_to}' )
             AND ( mt2.meta_key LIKE 'training_types_%_execution_of_training_has_live_course'
             AND mt2.meta_value = '1' )
             AND (SUBSTRING_INDEX(mt1.meta_key,'_execution',1) = REPLACE(mt2.meta_key, '_execution_of_training_has_live_course', '')) )
             AND p.post_type = 'product' AND p.post_status = 'publish'
             GROUP BY p.ID
             EOT;
             $objs = $wpdb->get_results( $query );
         }else{
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
