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
			$query = "SELECT * FROM products ORDER BY RAND() LIMIT 20";//ORDER BY RAND() LIMIT 25 76
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
			
			return 0;
		}

		//Deleting item from cart
		public function deleteFromCart($id, $customer){
			$query = $this->con->prepare("DELETE FROM `cart` WHERE `id` = ?");
			$query->bind_param("s", $id);
			if($query->execute()){
				$products = $this->getCartItems($customer);
				return $products;
			}else{
				return 0;
			}
			//$query->store_result();
			//return $query->num_rows > 0;
		}

		//Change item quantity in cart
		public function setQuantity($quantity, $customer, $product_id){
			$query = $this->con->prepare("UPDATE `cart` SET `quantity` = $quantity WHERE `cart`.`customer` = $customer AND `cart`.`product_id` = $product_id");
			if($query->execute()){
				$products = $this->getCartItems($customer);
				return 1; 
			}else{
				return 0; 
			}
		}

		//Insert into order table
		public function insertOrder($customer_id, $total_price, $total_items){
			$stmt = $this->con->prepare("INSERT INTO `orders` (`order_number`, `customer_id`, `total_price`, `total_items`)
				VALUES (NULL, ?, ?, ?);");
			$stmt->bind_param( "sss", $customer_id, $total_price, $total_items);

			if($stmt->execute()){
				$last_id = "SELECT LAST_INSERT_ID()";
				
				 $result = mysqli_query($this->con, $last_id);

				while($row = mysqli_fetch_assoc($result)){
					$data = $row;
				}
				if(!empty($data))
					return $data;
			}else{
				return 0;
			}
		}

		//Insert into order details table
		public function insertOrderDetails($order_number, $name, $description, $quantity, $total_price, $img_url){
			$stmt = $this->con->prepare("INSERT INTO `order_details` (`id`, `order_number`, `name`, `description`, `quantity`, `total_price`, `img_url`)
			VALUES (NULL, ?, ?, ?, ?, ?, ?);");
			$stmt->bind_param( "ssssss", $order_number, $name, $description, $quantity, $total_price, $img_url);

			if($stmt->execute()){
				return 1;
			}else{
				return 0;
			}
		}
	}
?>