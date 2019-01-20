<?php 

	require_once '../includes/DbOperations.php';

	$response = array(); 

	if($_SERVER['REQUEST_METHOD']=='POST'){
		if(isset($_POST['username']) and isset($_POST['password'])){
			$db = new DbOperations(); 

			if($db->userLogin($_POST['username'], $_POST['password'])){
				$user = $db->getUserByUsername($_POST['username']);
				$response['error'] = false; 
				$response['message'] = "Login successful";
				$response['id'] = $user['customerid'];
				$response['firstname'] = $user['firstname'];
				$response['lastname'] = $user['lastname'];
				$response['phonenumber'] = $user['phonenumber'];
				$response['email'] = $user['email'];
				$response['username'] = $user['username'];
			}else{
				$response['error'] = true; 
				$response['message'] = "Invalid username or password";			
			}

		}else{
			$response['error'] = true; 
			$response['message'] = "Required fields are missing";
		}
	}

	echo json_encode($response);
?>