
<?php 

	require_once '../includes/DbOperations.php';

	$response = array(); 

	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['name']) and isset($_POST['description']) and 
		isset($_POST['quantity']) and isset($_POST['price']) and 
		isset($_POST['img_url']) and isset($_POST['customer']) and isset($_POST['product_id']))
			{
			//operate the data further 

			$db = new DbOperations(); 

			$result = $db->addToCart( $_POST['name'], $_POST['description'], $_POST['quantity'], 
				$_POST['price'], $_POST['img_url'], $_POST['customer'], $_POST['product_id'] );

			if($result == 1){
				$response['error'] = false; 
				$response['message'] = "Adding success";
			}elseif($result == 0){
				$response['error'] = true; 
				$response['message'] = "Some error occurred please try again";			
			}elseif($result == 2){
				$response['error'] = true; 
				$response['message'] = "This product is already in cart";						
			}

		}else{
			$response['error'] = true; 
			$response['message'] = "Required fields are missing";
		}
	}else{
		$response['error'] = true; 
		$response['message'] = "Invalid Request";
	}

	echo json_encode($response);
?>
