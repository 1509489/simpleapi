<?php
    require_once '../includes/DbOperations.php';
/* 
    $response = array();
    $db = new DbOperations();
    $products = $db->getProductsFoodMain(); */

    $response = array();
    $db = new DbOperations();
    $products = $db->getProductsFoodMain();
    $results = array();

    /* 
    if(!empty($products)){
        $response['products'] = $products;
    }
    echo json_encode($response); */

    foreach($products as $product){
        $response['id'] = $product['product_id'];
        $response['name'] = $product['product_name'];
        $response['description'] = $product['description'];
        $response['price'] = $product['price'];
        $response['imageUrl'] = $product['img_url'];

        $results[] = $response;
        $output['products'] = $results;
    }
    echo json_encode($output);
?>