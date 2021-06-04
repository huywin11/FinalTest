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
        'get_product_by_format' => 'getproduct_by_format_and_training_type_id'
    ];


    /**
     * getMorePartner
     */
    public function getProducts(){
      // $product = new ListProductAjax();
      $product = new ListProductAjax();
      $data = $product->execute();
      debug($data,true);
       }
       public function getproduct_by_format_and_training_type_id()
    {
        $product = new ListProductFormat();
        $products = $product->execute();
          debug($products,true);
      }
}
