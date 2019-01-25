<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $db = new DbOperations();
    //$products = $db->getProductsfeatured();
    $results = array();

    if($db->getProductsfeatured()){
        $products = $db->getProductsfeatured();

        foreach($products as $product){
            $response['id'] = $product['product_id'];
            $response['name'] = $product['product_name'];
            $response['description'] = $product['description'];
            $response['price'] = $product['price'];
            $response['imageUrl'] = $product['img_url'];
    
            $results[] = $response;
            $output['products'] = $results;
        }

        $finalOutput = $output;
        $finalOutput['error'] = false; 
        $finalOutput['message'] = "Retrieval successful";
    }
    else{
        $finalOutput['error'] = true; 
        $finalOutput['message'] = "Some error occured";
    }
    
    echo json_encode($finalOutput);
    //echo json_encode($response);
?>