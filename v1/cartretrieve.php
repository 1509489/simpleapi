<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $results = array();
    $db = new DbOperations();
    
    if($db->getCartItems($_POST['customer'])){
        $products = $db->getCartItems($_POST['customer']);
            
        foreach($products as $product){
            $response['id'] = $product['id'];
            $response['name'] = $product['name'];
            $response['description'] = $product['description'];
            $response['quantity'] = $product['quantity'];
            $response['price'] = $product['price'];
            $response['img_url'] = $product['img_url'];
            $response['customer'] = $product['customer'];
            $response['product_id'] = $product['product_id'];

            $results[] = $response;
            $output['cart_items'] = $results;
        }
        
        $finalOutput = $output;
        $finalOutput['error'] = false; 
        $finalOutput['message'] = "Retrieval successful";
    }else{
        $finalOutput['error'] = true; 
		$finalOutput['message'] = "Required fields are missing";
    }
    echo json_encode($finalOutput);

?>