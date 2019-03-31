<?php
     require_once '../includes/DbOperations.php';

     $response = array();
     $results = array();
     $db = new DbOperations();

     if($db->getOrders($_POST['customer_id'])){
        $orders = $db->getOrders($_POST['customer_id']);

        foreach($orders as $order){
            $response['orderNumber'] = $order['order_number'];
            $response['customerId'] = $order['customer_id'];
            $response['totalPrice'] = $order['total_price'];
            $response['totalItems'] = $order['total_items'];

            $results[] = $response;
            $output['orders'] = $results;
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