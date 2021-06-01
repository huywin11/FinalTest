<?php


namespace App\Components\Hooks\Admin\PostTypes\Classes;


use App\Components\AcfFields\Consts\PostTypes\Format as Field;
use App\Components\Hooks\Admin\PostTypes\Abstracts\AbstractPostType;

class Format extends AbstractPostType
{

    protected  $label           = 'Format';
    protected  $singleName      = 'Format';
    protected  $name            = Field::_NAME;
    protected  $time            = Field::_TIME;
    protected  $format          = Field::_FORMAT;
    protected  $cost            = Field::_COST;
    protected  $menuIcon        = 'dashicons-book';
    protected  $support         = array('title','thumbnail','custom-fields');




//
    public function selfHook()
    {
      // global  $wpdb;
      // $query = <<<EOT
      // SELECT DISTINCT(meta_value) FROM wp_postmeta WHERE meta_key = 'format'
      // EOT;
      //   $objs = $wpdb->get_results( $query );
      // $query = <<<EOT
      //  INSERT INTO wp_posts (post_title,post_date,post_date_gmt,post_modified,post_modified_gmt,post_content,post_excerpt,to_ping,pinged,post_content_filtered)  SELECT DISTINCT(meta_value),'2021-05-21 10:25:58','2021-05-21 10:25:58','2021-05-21 10:25:58','2021-05-21 10:25:58','','','','','' FROM wp_postmeta WHERE meta_key = 'format'
      // EOT;
      //
      // $objs = $wpdb->get_results( $query);

      // if($exist == 0){
            // $format = array(
            //     'post_title'    => $query->meta_value,
            //     'post_status'   => 'publish',
            //     'post_author'   => 1,
            //     'post_type' => 'format'
            // );
            //
            // // Insert the post into the database
            // wp_insert_post( $format );
    global $wpdb;
    // $sql = "SELECT DISTINCT(meta_value) FROM wp_postmeta WHERE meta_key = 'format'";
    $sql = "SELECT DISTINCT(meta_value) FROM `wp_postmeta` WHERE `meta_key` LIKE 'training_types_%_format'";
    $customFieldText = $wpdb->get_results($sql);
    //update custom field text to post(object)
    $sql = "SELECT post_title FROM wp_posts WHERE post_type = 'format' AND post_status = 'publish'";
    $customFieldObj = $wpdb->get_results($sql);
    foreach($customFieldText as $fText){
        $exist = 0;
        foreach($customFieldObj as $fObject)
        {
            if($fObject->post_title == $fText->meta_value)
            {
                $exist ++;
            }
        }
        if($exist == 0)
        {
            $format = array(
                'post_title'    => $fText->meta_value,
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type' => 'format'
            );

            // Insert the post into the database
            wp_insert_post( $format );
        }
    }

      //update custom field text to post(object)
      $customFieldObj = $wpdb->get_results($sql);
      // debug($customFieldObj,true);
      foreach($customFieldObj as $fObject){
          $exist = false;
            foreach($customFieldText as $fText)
            {
                if(strcmp($fObject->post_title, $fText->meta_value) == 0)
                {
                    $exist = true;
                    continue ;
                }
            }
            if($exist == false)
            {
                global $wpdb;
                // $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'format' AND post_title LIKE  '{$fObject->post_title}'");
            }
        }


          $sql = "SELECT DISTINCT(meta_value) FROM `wp_postmeta` WHERE `meta_key` LIKE 'training_types_%_format'";
          $format = array(
              'post_title'    => $customFieldObj,
              'post_status'   => 'publish',
              'post_author'   => 1,
              'post_type' => 'product'
          );
          $value = get_field( "post_type", 'product' );
          // debug($format,true);
          // Insert the post into the database
          // wp_insert_post( $format );

    }
    // public function training_types_format()
    // {
    //   global  $wpdb;
    //   $query = <<<EOT
    //   SELECT DISTINCT(meta_value) FROM wp_postmeta WHERE meta_key = 'format'
    //   EOT;
    //   $objs = $wpdb->get_results( $query );
    //   debug($objs,true);
    // }
    // debug("huy");
    // echo $support;

    public function adminColumns($defaults)
    {
        // // TODO: Implement adminColumns() method.
        // return [
        //     'cb'                =>  $defaults['cb'],
        //     'title'             =>  __('Name','lec2_text_domain'),
        //     'thumbnail'         =>  __('Thumbnail','lec2_text_domain'),
        //     'category'          =>  __('Categories','lec2_text_domain'),
        // ];
        //    debug("hello",true);
    }

    public function adminColumnsContent($columnName, $postID)
    {
        // // TODO: Implement adminColumnsContent() method.
        // if($columnName == 'thumbnail'){
        //     $url = get_the_post_thumbnail_url($postID);
        //     if($url){
        //         echo "<img src='{$url}' class='table-thumbnail' >";
        //     }
        // }
        // if($columnName == 'category'){
        //     $categories = get_the_terms($postID, 'training-category');
        //     $termNames = [];
        //     if($categories){
        //         foreach($categories as $term) {
        //             $termNames[] = $term->name;
        //         }
        //     }
        //     echo implode(', ', $termNames);
        // }
    }
}
