<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $db = new DbOperations();
    $products = $db->getProductsfeatured();
    $results = array();

    /*
    if(!empty($products)){
        $response['products'] = $products;
    }*/
/*
    for($i = 0; $i < count($products); ++$i){
        $response['id'] = $products[$i]['product_id'];
        $response['name'] = $products[$i]['product_name'];
        $response['description'] = $products[$i]['description'];
        $response['price'] = $products[$i]['price'];
        $response['imageUrl'] = $products[$i]['img_url'];

        $results[] = $response;
        $output['products'] = $results;
        
    }*/
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
    //echo json_encode($response);
?>