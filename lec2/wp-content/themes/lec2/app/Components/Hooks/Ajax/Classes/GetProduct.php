<?php
/**
 * Created by PhpStorm.
 * User: Lê Cao Huy
 * Date: 2021-06-1
 * Time: 23:01
 */

namespace App\Components\Hooks\Ajax\Classes;

use App\Components\Hooks\Ajax\AbstractAjax;
use App\Services\Training\ListTrainingsAjax;
use App\Services\Product\ListProductAjax;
use App\Services\Product\GetLiveCourseDays;
use App\Services\Product\ListProductFormat;
/**
 * Class GetPartnerListing - Get more partner
 *
 * @package App\Components\Hooks\Ajax\Classes
 */
class GetProduct  extends AbstractAjax
{
    protected $functions = [
        'get_products' =>  'getProducts',
        'get_product_by_format' => 'getproduct_by_format_and_training_type_id',
        'get_product_by_date' => 'getproduct_by_live_courses_days',
    ];
    /**
     * getMorePartner
     */
     public function to_hour($datetime){
      $datetime = str_replace("/","-",$datetime);
      $date = substr($datetime, 0, 10);
      $hours = substr($datetime, 11, 2);
      $minutes = substr($datetime, 14, 2);
      $seconds = '00';
      $meridiem = (strtolower($meridiem)=='am') ? 'am' : 'pm';
      return $date.date(' H:i:s', strtotime("{$hours}:{$minutes}:{$seconds} {$meridiem}"));
    }
    public function getProducts(){
      // $product = new ListProductAjax();

      $products = new ListProductAjax();
      $data = $products->execute();
      $time_zone_client = $products->getTimeZone();
      $timezoneWPSetting = $products->getTimeZoneWPSetting();
      foreach($data as $item_key=>$item_value){
            foreach($item_value['custom_data']['training_types'] as $training_type_key=>$training_type_value){
                  $item_value['custom_data']['training_types'][$training_type_key]['execution_of_training']['live_course_dates'] = [];
                      foreach($training_type_value['execution_of_training']['live_course_dates'] as $key=>$value){
                            $new_date = $this->to_hour($value['date']);
                            $date = date_create($new_date, timezone_open($timezoneWPSetting));
                            date_timezone_set($date, timezone_open($time_zone_client));
                            $date = $date->format('d-m-Y H:i:s');
                            $item_value['custom_data']['training_types'][$training_type_key]['execution_of_training']['live_course_dates'][]['date'] = $date;
                      }
            }
            $data[$item_key] = $item_value;
      }
          wp_send_json([
         'status'  =>  '200',
         'function'  =>  'Function test',
         'message' =>  'Successfully',
         'total_items' => count($data),
         'products'  => $data
       ]);
      debug($data,true);
       }
       public function getproduct_by_format_and_training_type_id()
    {
        $product = new ListProductFormat();
        $products = $product->execute();
        debug($products,true);
      }
       public function getproduct_by_live_courses_days()
    {
      $products = new GetLiveCourseDays();
    $data = $products->execute();
    // $time_zone_client = $product->getTimeZone();
    // $timezoneWPSetting = $product->getTimeZoneWPSetting();
    foreach($data as $item){
    foreach($item['custom_data']['training_types'] as $training_type){
        foreach($training_type['execution_of_training']['live_course_dates'] as $live_course_date){
            $date = new DateTime('12:10:20 02/10/2021');
            echo $date->format('h:i:s a m/d/Y') ;
        }
    }
  }
          wp_send_json([
         'status'  =>  '200',
         'function'  =>  'Function test',
         'message' =>  'Successfully',
         'total_items' => count($data),
         'products'  => $data
       ]);
      }
}
