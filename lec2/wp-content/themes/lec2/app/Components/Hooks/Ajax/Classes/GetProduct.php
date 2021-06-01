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
      $product = new ListProductFormat();
      $data = $product->execute();
      debug($data,true);
       }
       public function getproduct_by_format_and_training_type_id()
    {
        $product = new ListProductFormat();
        $products = $product->execute();
          debug($products,true);
       //  wp_send_json([
       // 'function'  =>  'GetFormat ',
       //  'total_items' => count($products),
       // 'products'  => $products,]);

       // for($i=0;$i<= count($products);$i++ )
       // {
       // foreach ($products as $p) {
       //   $format = $products[$i]['custom_data']['training_types'][$i]['format'];
       //   // $format = $products[$i]['custom_data']['training_types'][$i]['format']->post_title;
       //   // debug($products[0]['custom_data']['training_types'][0]['format']->post_title,true);
       //   debug($format,true);
       // }}
       // foreach ($variable as $key => $value) {
       //   // code...
       // }
       // for($i=0; $i<count($products);$i++)
       // { $training_type = $products[$i]['custom_data']['training_types'];
       //   // debug($products[$i]['custom_data']['training_types']
       //   foreach ($products as $p) {
       //
       //       $format =   $products[$i]['custom_data']['training_types'] =   $products[$i]['custom_data']['training_types'][$i]['format']->post_title;
       //     // $t['format'] = $t['format']->post_title;
       //     // debug( $products[$i]['custom_data']['training_types'][$i]['format']);
       //     debug($format);
       //
       //
       //   }
       // }
       // debug()
       //  debug($products, true);
    }



      // $args = array(
      //   'post_type'      => 'Format',
      //   'post'     =>       "",
      //        );
      //
      // $products = query_posts( $args );
      // $h = $products['post_id'];
      // debug($products,true);
      //
      //
      //
      // global  $wpdb;
      // $query = <<<EOT
      // SELECT DISTINCT(meta_value) FROM wp_postmeta WHERE meta_key = 'format'
      // EOT;
      // $query1 = <<<EOT
      //  INSERT INTO wp_posts (post_title,post_date,post_date_gmt,post_modified,post_modified_gmt,post_content,post_excerpt,to_ping,pinged,post_content_filtered)  SELECT DISTINCT(meta_value),'2021-05-21 10:25:58','2021-05-21 10:25:58','2021-05-21 10:25:58','2021-05-21 10:25:58','','','','','' FROM wp_postmeta WHERE meta_key = 'format'
      // EOT;
      // $objs = $wpdb->get_results( $query );
      // $objs1 = $wpdb->get_results( $query1);
      // debug($objs,true);

      // add_action( 'init', 'lc_custom_post_movie' );
      //
      // // The custom function to register a movie post type
      // function lc_custom_post_movie() {
      //
      //   // Set the labels, this variable is used in the $args array
      //   $labels = array(
      //     'name'               => __( 'Movies' ),
      //     'singular_name'      => __( 'Movie' ),
      //     'add_new'            => __( 'Add New Movie' ),
      //     'add_new_item'       => __( 'Add New Movie' ),
      //     'edit_item'          => __( 'Edit Movie' ),
      //     'new_item'           => __( 'New Movie' ),
      //     'all_items'          => __( 'All Movies' ),
      //     'view_item'          => __( 'View Movie' ),
      //     'search_items'       => __( 'Search Movies' ),
      //     'featured_image'     => 'Poster',
      //     'set_featured_image' => 'Add Poster'
      //   );
      //
      //   // The arguments for our post type, to be entered as parameter 2 of register_post_type()
      //   $args = array(
      //     'labels'            => $labels,
      //     'description'       => 'Holds our movies and movie specific data',
      //     'public'            => true,
      //     'menu_position'     => 5,
      //     'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
      //     'has_archive'       => true,
      //     'show_in_admin_bar' => true,
      //     'show_in_nav_menus' => true,
      //     'has_archive'       => true,
      //     'query_var'         => 'film'
      //   );
      //
      //   // Call the actual WordPress function
      //   // Parameter 1 is a name for the post type
      //   // Parameter 2 is the $args array
      //   register_post_type( 'movie', $args);
      // }
      //
      // // Hook <strong>lc_custom_post_movie_reviews()</strong> to the init action hook
      // add_action( 'init', 'lc_custom_post_movie_reviews' );
      //
      // // The custom function to register a movie review post type
      // function lc_custom_post_movie_reviews() {
      //
      //   // Set the labels, this variable is used in the $args array
      //   $labels = array(
      //     'name'               => __( 'Movie Reviews' ),
      //     'singular_name'      => __( 'Movie Review' ),
      //     'add_new'            => __( 'Add New Movie Review' ),
      //     'add_new_item'       => __( 'Add New Movie Review' ),
      //     'edit_item'          => __( 'Edit Movie Review' ),
      //     'new_item'           => __( 'New Movie Review' ),
      //     'all_items'          => __( 'All Movie Reviews' ),
      //     'view_item'          => __( 'View Movie Reviews' ),
      //     'search_items'       => __( 'Search Movie Reviews' )
      //   );
      //
      //   // The arguments for our post type, to be entered as parameter 2 of register_post_type()
      //   $args = array(
      //     'labels'            => $labels,
      //     'description'       => 'Holds our movie reviews',
      //     'public'            => true,
      //     'menu_position'     => 6,
      //     'supports'          => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
      //     'has_archive'       => true,
      //     'show_in_admin_bar' => true,
      //     'show_in_nav_menus' => true,
      //     'has_archive'       => true
      //   );
      //
      //   // Call the actual WordPress function
      //   // Parameter 1 is a name for the post type
      //   // $args array goes in parameter 2.
      //   register_post_type( 'review', $args);
      // }

      // global $wpdb;
      // // global $count;
      // 	// echo  $count ;
      //      // $float = (float)$_GET['cost'];
      //      $cost = $_GET['cost'];
      //      $cost = floatval($cost);
      //      if(is_float($cost) == true)
      //      {
      //        $query = <<<EOT
      //        SELECT * FROM wp_posts AS p LEFT JOIN wp_postmeta AS mt1 ON p.id = mt1.post_id LEFT JOIN wp_postmeta AS mt2 ON mt1.post_id = mt2.post_id
      //        WHERE
      //          p.post_type = 'product' AND
      //            ( mt1.meta_key LIKE 'training_types_%_training_type' AND mt1.meta_value = {$_GET['training_type_id']} ) AND
      //            ( mt2.meta_key LIKE 'training_types_%_cost' AND   lec2_floatval("$,%,#",mt2.meta_value) > '{$cost}' ) AND
      //            ( REPLACE(mt1.meta_key, '_training_type', '') = REPLACE(mt2.meta_key, '_cost', '') )
      //        GROUP BY p.id
      //        EOT;
      //        $products = $wpdb->get_results( $query );
      //        debug($products,true);
      //      }
      //      else
      //      {
      //        wp_send_json([
      //          'status'  =>  'false',
      //          'message'  =>  'test function',
      //        ]);
      //      }

    // }

// DELIMITER $$
// CREATE DEFINER=`root`@`localhost` FUNCTION `lec2_floatval`(symbols VARCHAR(20), cost VARCHAR(510)) RETURNS VARCHAR(510)
// BEGIN
//   SET cost = REPLACE(cost,',','.');
//   SET @total_symbols = LENGTH(symbols)  - LENGTH( REPLACE ( symbols, ",", "") );
//   SET @i = 0;
//   SET @p = 1;
//   REPEAT
//   SET @i = @i + 1;
//   SET @symbols = SUBSTRING(symbols,@p,1);
//   SET @p = @p + 2;
//   SET cost = REPLACE(cost, @symbols,'');
//   UNTIL @i > @total_symbols END REPEAT;
//     SET cost = CAST(cost AS DECIMAL(65,2));
//     RETURN cost;
//     END$$
// DELIMITER ;
    // public function lec2_floatval()
    // {
    //   $cost = $_GET['cost'];
    //   // $cost = floatval($cost);
		//   $count_symbols=",";
	  // 	$count=0;
		// for($i=1; $i < strlen($cost); $i++)
		//   {
		// 	if(substr($cost,$i,1) == $count_symbols)
		// 	{
		// 	$count = $count+1;
		// 	 }
		//   }
		// echo  $count ;
    //   $cost = floatval($cost);
    //   replace('$cost','',mt2.meta_value)
    // }
}
