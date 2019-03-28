<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $results = array();
    $db = new DbOperations();

    if($db->deleteFromCart($_POST['id'], $_POST['customer'])){
        $results = $db->deleteFromCart($_POST['id'], $_POST['customer']);
        
        if($results ==1 ){
            
            /* foreach($results as $product){
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
            $finalOutput['message'] = "Delete successful";
 */
            $finalOutput['error'] = false; 
            $finalOutput['message'] = "Delete successful";

        }elseif($results == 0){
            $finalOutput['error'] = true; 
            $finalOutput['message'] = "No item with such id";
        }
    }else{
        $finalOutput['error'] = true; 
        $finalOutput['message'] = "Cart Empty";
    }
    echo json_encode($finalOutput);

?>