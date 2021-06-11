<?php

/**
 * Created by PhpStorm.
 * User: Lê Cao Huy
 * Date: 9_6_2021
 * Time: 23:00
 */

namespace App\Services\Product;

use App\Services\AbstractService;


/**
 * Class GetLiveCourseDays
 * List all Training and paginate them.
 * If you want to get objects and paginate, please make your own class extend from AbstractListingObjects
 * - But we don't need paginate for training so that i  make this class extend from AbstractService
 *
 * @package App\Services\Training
 */
class GetLiveCourseDays extends AbstractService
{


  public function getTimeZone(){ ?>
       <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
       <script type="text/javascript">
       function createCookie(e,t,o){var i;if(o){
            var n=new Date;n.setTime(n.getTime()+24*o*60*60*1e3),i=";
            expires="+n.toGMTString()}else i="";
            url=window.location.href,document.cookie=escape(e)+"="+escape(t)+i+";
            path="+url}
            $(document).ready(function(){
               createCookie("time_zone_client",Intl.DateTimeFormat().resolvedOptions().timeZone,"1")
             });
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
       // $timezoneWPSetting = wp_timezone_string();
       //
       // if (strpos($timezoneWPSetting, '/') === false) {
       //   $option =  get_option('gmt_offset');
       //   // echo timezone_name_from_abbr("CET") . "\n";
       //   $count = $option*3600;
       //   $utc = timezone_name_from_abbr("", $count, 0) . "\n";
       //   switch($count){
       //            case 31500:   $utc = 'Australia/Eucla';break;
       //            case 49500:   $utc = 'ZoneWaqti';break;
       //            case 45900:   $utc = 'NewZealand/Owenga';break;
       //            case 37800:   $utc = 'NewZealand/Lord Howe Island';break;
       //            case 34200:   $utc = 'France/Ua Pou Island';break;
       //            case 27000:   $utc = 'Malaysia/ Peninsular Malaysia ';break;
       //            case 23400:   $utc = 'Myanmar/ Mandalay ';break;
       //            case 16200:   $utc = 'Iran/ Ahvaz ';break;
       //            default:    $utc = timezone_name_from_abbr("", $count, false);
       //        }
       //      }
       //
       //    return $utc;
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

  // public function getTimeZoneWPSetting(){
  //      $timezoneWPSetting = wp_timezone_string();
  //
  //      if (strpos($timezoneWPSetting, '/') === false) {
  //          // $tz_offset = get_option('gmt_offset');
  //          $tz_offset = wp_timezone_string();
  //          $format = "%H:%M:%S %d-%B-%Y";
  //              $time= time();
  //               $california_time_parts = time() - get_option('gmt_offset') * 3600;
  //          $strTime = strftime($format, $california_time_parts );
  //      }
  //      return $timezoneWPSetting;
  //  }
    public function execute()
   {

     global $wpdb, $wp_query;
         // if(isset($_GET['date_from']) || isset($_GET['date_to'])){
         $time_zone_client = $this->getTimeZone();
         $timezoneWPSetting = wp_timezone_string();
             // }
             $date_from = date_create($_GET['date_from'], timezone_open($time_zone_client));
             date_timezone_set($date_from, timezone_open($timezoneWPSetting));
             $date_from = $date_from->format('Y-m-d H:i:s');
             $date_to = date_create($_GET['date_to'], timezone_open($time_zone_client));
             date_timezone_set($date_to, timezone_open($timezoneWPSetting));
             $date_to = $date_to->format('Y-m-d H:i:s');
             $query = <<<EOT
             SELECT *  FROM `wp_postmeta` WHERE `meta_key` LIKE 'training_types_%_execution_of_training_live_course_dates_%_date'
             AND ( meta_value BETWEEN '{$date_from}' AND '{$date_to}' )
             EOT;
             $objs = $wpdb->get_results( $query );
             foreach($objs as $obj){
                 $date = date_create($obj->meta_value, timezone_open($timezoneWPSetting));
                 date_timezone_set($date, timezone_open($time_zone_client));
                 $date = $date->format('Y-m-d H:i:s');
                 $obj->meta_value = $date;
               }
    // debug($objs);
 //     $format = "%H:%M:%S %d-%B-%Y";
 //   $timestamp = time();
 //    $strTime = strftime($format, $timestamp );
 //   echo 'Thời gian ở thời điểm UTC +0  - - - - -- '.$strTime."</br>";
 //   echo 'Thời gian của user  - - - - -- '.$time_zone_client."<br>";
 //     $time_parts = localtime(); // California (PST) is three hours earlier
 //     $format = "%H:%M:%S %d-%B-%Y";
 //     $time= time(); // California (PST) is three hours earlier
 //      $california_time_parts = time() - get_option('gmt_offset') * 3600;
 // $strTime = strftime($format, $california_time_parts );
 // echo 'Thời gian ở thời điểm so với timezone ở admin  - - - - -- '.$strTime;
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
