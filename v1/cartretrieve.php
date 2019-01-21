<?php
    require_once '../includes/DbOperations.php';
/* 
    $response = array();
    $db = new DbOperations();
    $products = $db->getProductsFoodMain(); */

    $response = array();
    $results = array();
    $db = new DbOperations();
    //$customer = $_POST('customer');
    
    if($db->getCartItems($_POST['customer'])){
        $products = $db->getCartItems($_POST['customer']);

            
        foreach($products as $product){
            $response['error'] = false; 
			$response['message'] = "Retrieval successful";
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
    }else{
        $response['error'] = true; 
		$response['message'] = "Required fields are missing";
    }
    
    echo json_encode($output);
    /*
    if(isset($_POST['customer'])){
       
    }*/

    /* 
    if(!empty($products)){
        $response['products'] = $products;
    }
    echo json_encode($response); */

?>