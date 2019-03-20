<?php 

    require_once '../includes/DbOperations.php';
    
    $response = array();

    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['customer_id']) and isset($_POST['total_price']) and isset($_POST['total_items'])){
            $db = new DbOperations(); 

            $results = $db->insertOrder($_POST['customer_id'], $_POST['total_price'], $_POST['total_items']);
            
            if($results > 0){
                $response['orderNumber'] = $results[ "LAST_INSERT_ID()"]; 
                $response['error'] = false; 
				$response['message'] = "Order success";
            }else{
                $response['error'] = true; 
				$response['message'] = "Order fail";
            }
        }
    }

    echo json_encode($response);
?>