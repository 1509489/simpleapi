<?php
    require_once '../includes/DbOperations.php';

    $response = array();
    $results = array();
    $db = new DbOperations();

    if($db->deleteFromCart($_POST['id'])){
        $results = $db->deleteFromCart($_POST['id']);
        
        if($results == 1){
            $response['error'] = false; 
            $response['message'] = "Delete successful";
        }elseif($results == 0){
            $response['error'] = true; 
            $response['message'] = "No item with such id";
        }
    }else{
        $response['error'] = true; 
        $response['message'] = "Required fields are missing";
    }
    echo json_encode($response);

?>