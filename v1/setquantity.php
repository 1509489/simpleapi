<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $db = new DbOperations();

    if($db->setQuantity($_POST['quantity'], $_POST['customer'], $_POST['product_id'])){
        $result = $db->setQuantity($_POST['quantity'], $_POST['customer'], $_POST['product_id']);

        /* if($result > 0){
            
            foreach($result as $product){
                $response['id'] = $product['id'];
                $response['name'] = $product['name'];
                $response['description'] = $product['description'];
                $response['quantity'] = $product['quantity'];
                $response['price'] = $product['price'];
                $response['img_url'] = $product['img_url'];
                $response['customer'] = $product['customer'];
                $response['product_id'] = $product['product_id'];

                $products[] = $response;
                $output['cart_items'] = $products;
            }

            $finalOutput = $output;
            $finalOutput['error'] = false; 
            $finalOutput['message'] = "Quantity Updated Succefully";

        }elseif($result == 0){
            $finalOutput['error'] = true; 
            $finalOutput['message'] = "Quantity Update Failed";
        } */

        if($result == 1){
            $response['error'] = false;
            $response['message'] = "Quantity Updated Succefully";
        }elseif($result == 0){
            $response['error'] = true;
            $response['message'] = "Quantity Update Failed";
        }
    }

    echo json_encode($response);
    //echo json_encode($finalOutput);
?>