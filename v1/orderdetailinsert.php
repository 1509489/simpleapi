<?php

    require_once '../includes/DbOperations.php';

    $response = array();

    if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['order_number']) and isset($_POST['name']) and isset($_POST['description']) and 
		isset($_POST['quantity']) and isset($_POST['price']) and isset($_POST['img_url'])){

            $db = new DbOperations(); 
            
            $results = $db->insertOrderDetails($_POST['order_number'], $_POST['name'], $_POST['description'], 
            $_POST['quantity'], $_POST['price'], $_POST['img_url']);

            if($results == 1){
                $response['error'] = false; 
				$response['message'] = "Order detail insert success";
            }else{
                $response['error'] = true; 
				$response['message'] = "Order detail insert fail";
            }
        }
    }
    echo json_encode($response);

?>