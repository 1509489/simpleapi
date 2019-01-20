<?php 

	class DbOperations{

		private $con; 

		function __construct(){

			require_once dirname(__FILE__).'/DbConnect.php';
			$db = new DbConnect();
			$this->con = $db->connect();

		}

		//Registration Operation
		public function createUser( $firstname, $lastname, $phonenumber, $username, $email, $pass ){
			if($this->isUserExist($username,$email)){
				return 0; 
			}else{
				$password = md5($pass);
				$stmt = $this->con->prepare("INSERT INTO `customer` (`customerid`, `firstname`, `lastname`, `phonenumber`, `username`, `email`, `password`) 
				VALUES (NULL, ?, ?, ?, ?, ?, ?);");
				$stmt->bind_param( "ssssss", $firstname, $lastname, $phonenumber, $username, $email, $password );

				if($stmt->execute()){
					return 1; 
				}else{
					return 2; 
				}
			}
		}

		//Login Operation
		public function userLogin($username, $pass){
			$password = md5($pass);
			$stmt = $this->con->prepare("SELECT customerid FROM customer WHERE username = ? AND password = ?");
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		//Get user
		public function getUserByUsername($username){
			$stmt = $this->con->prepare("SELECT * FROM customer WHERE username = ?");
			$stmt->bind_param("s",$username);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
		
		//Check for existing user
		private function isUserExist($username, $email){
			$stmt = $this->con->prepare("SELECT customerid FROM customer WHERE username = ? OR email = ?");
			$stmt->bind_param("ss", $username, $email);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		//Get all products
		public function getProductsFoodMain(){
			$products = array();
			$query = "SELECT * FROM products WHERE product_id BETWEEN 1 AND 23 ORDER BY product_id ASC";
			$products = $this->getProducts($query);
			return $products;
		}

		public function getProductsfeatured(){
			$products = array();
			$query = "SELECT * FROM products ORDER BY RAND() LIMIT 20";
			$products = $this->getProducts($query);
			return $products;
		}

		private function getProducts($query){
			$result = mysqli_query($this->con, $query);
			while($row = mysqli_fetch_assoc($result)){
				$data[] = $row;
			}
			if(!empty($data))
				return $data;
			
			return $data;
		}

		//Add product to cart
		public function addToCart( $name, $description, $quantity, $price, $img_url, $customer, $product_id ){
			//If item already exist in cart then update the quantity
			if($this->cartItemExists($customer, $product_id)){
				$stmt = $this->con->prepare("UPDATE `cart` SET `quantity` = (quantity + $quantity) WHERE `cart`.`customer` = $customer AND `cart`.`product_id` = $product_id");
				if($stmt->execute()){
					return 1; 
				}else{
					return 0; 
				}
			}else{//If item not already in cart then add it to the cart
				$stmt = $this->con->prepare("INSERT INTO `cart` (`id`, `name`, `description`, `quantity`, `price`, `img_url`, `customer`, `product_id`)
				VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);");
				$stmt->bind_param( "sssssss", $name, $description, $quantity, $price, $img_url, $customer, $product_id);

				if($stmt->execute()){
					return 1; 
				}else{
					return 0; 
				}
			}
		}

		//Function to check if item is already in the cart
		private function cartItemExists($customer, $product_id){
			$stmt = $this->con->prepare("SELECT id FROM cart WHERE customer = ? AND product_id = ?");
			$stmt->bind_param("ss", $customer, $product_id);
			$stmt->execute(); 
			$stmt->store_result(); 
			return $stmt->num_rows > 0; 
		}

		//Get the products in cart for specific customer
		public function getCartItems($customer){
			$query = "SELECT * FROM cart WHERE customer = '$customer' ORDER BY name ASC"; 
			$result = mysqli_query($this->con, $query);
			while($row = mysqli_fetch_assoc($result)){
				$data[] = $row;
			}
			if(!empty($data))
				return $data;
			
			return $data;
		}

	}
?>