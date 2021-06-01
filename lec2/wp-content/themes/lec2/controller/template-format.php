<?php
/**
 * Template Name: Format Page Template
 */

use App\Services\Format\ListFormatsAjax;

$singlePage         = new \App\Services\Page\Single();
$data               = $singlePage->execute();

$formats = new ListFormatsAjax();

$data['custom_data']['format'] = $formats->execute();


// debug($data,true);
// foreach($data as $dt){
//     echo $dt['post_title'];
// }
return [
    'view' => 'pages/format/format.twig',
    'data' =>  $data
];

// debug($data,true);
