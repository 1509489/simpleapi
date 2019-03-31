<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $results = array();
    $db = new DbOperations();

    if($db->getOrderDetails($_POST['order_number'])){
        $orders = $db->getOrderDetails($_POST['order_number']);

        foreach($orders as $order){
            $response['id'] = $order['id'];
            $response['orderNumber'] = $order['order_number'];
            $response['name'] = $order['name'];
            $response['description'] = $order['description'];
            $response['quantity'] = $order['quantity'];
            $response['price'] = $order['price'];
            $response['imgUrl'] = $order['img_url'];

            $results[] = $response;
            $output['orders_details'] = $results;
        }

        /* if($orders > 0){

        } */

        $finalOutput = $output;
        $finalOutput['error'] = false; 
        $finalOutput['message'] = "Retrieval success";
    }else{
        $finalOutput['error'] = true; 
		$finalOutput['message'] = "Fail: Invalid customer id";
    }
    echo json_encode($finalOutput);
?>