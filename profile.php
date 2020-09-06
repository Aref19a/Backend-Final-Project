<?php 
include "includes/header.php"; 
$errors= false;
$success = false;
if(isset($_POST) && !empty($_POST)){
	$post = $_POST;
	$error_message = "";
	// echo "<pre>",print_r($post),"</pre>";die();
	//validate first email
	if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $post['email'])) {
		$errors = true;
		$error_message .= "<li>Not a valid email address</li>";
     //Valid email!
	}

	// validate phone format

	if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $post['phone_number'])) {
		$errors = true;
		$error_message .= "<li>Not a valid phone number</li>";
 	}

 	if(!$errors){
 		$phone_number = $conn->real_escape_string($post['phone_number']);
 		$fname = $conn->real_escape_string($post['fname']);
 		$lname = $conn->real_escape_string($post['lname']);
 		$email = $conn->real_escape_string($post['email']);
 		$username = $conn->real_escape_string($post['username']);
 		$password = password_hash($conn->real_escape_string($post['password']),PASSWORD_DEFAULT);
 		$user_id = $_SESSION['login_user_id'];

 		$updateDataQuery = "UPDATE users set `users_fname` = '{$fname}',`users_lname` = '{$lname}', `users_phone` = '{$phone_number}', `users_email` = '{$email}' WHERE `users_id` = '{$user_id}'";
// echo $insertDataQuery;die();	
		if (!$conn->query($updateDataQuery)) {
			die ("Nooooooooo!" . $conn->error);

		}else{
			if($post['password'] =='samepassword' ){// if password is same as before udate username only
						$updateDataQuery = "UPDATE login set `login_uname` = '{$username}' WHERE `login_user_id` = '{$user_id}'";
			}else{
						$updateDataQuery = "UPDATE login set `login_uname` = '{$username}',`login_pswd` = '{$password}' WHERE `login_user_id` = '{$user_id}'";
			}
	
			$conn->query($updateDataQuery);
		}

		$success = true;
 	}
}
 


?>

<body>
		<?php 

			if(!isset($_SESSION['auth'])){
				include('login.php');
				exit;
			}else{
				$user = $_SESSION['login_user'];
				$role = $_SESSION['login_user_type'];
				$user_id = $_SESSION['login_user_id'];
				$logged_in =true;
			}	
		?>

	<header>
		<div class="container">
			<nav class="navbar navbar-dark bg-dark">
				
				<ul class="navbar-nav mr-auto">
					

					<?php if($logged_in) { ?>
					<li class="nav-item">
						<a class="nav-link" href="index.php">Dashboard</span></a>
					</li>
					<?php if($role == '0'){ ?>
					<li class="nav-item">
						<a class="nav-link" href="view_users.php">View All Users</span></a>
					</li>
					<?php } ?>
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          <?php echo ucwords($user);?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a class="dropdown-item" href="profile.php">User Profile</a>

				          <a class="dropdown-item" href="./includes/logout.php">Logout</a>
				        </div>
				      </li>
				      <?php }?>
				</ul>
			</nav>


			<!-- jQuery and Bootstrap JavaScript links
			Used from https://www.getbootstrap.com, 29 January 2019 -->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
				integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
				crossorigin="anonymous"></script>
			<script src="js/bootstrap.bundle.min.js"
				integrity="sha384-zDnhMsjVZfS3hiP7oCBRmfjkQC4fzxVxFhBx8Hkz2aZX8gEvA/jsP3eXRCvzTofP"
				crossorigin="anonymous"></script> -->
		</div>

		
	</header>

	<main class="container">

		<section>
			<br>
			<?php if($errors){ ?>
			<div class="error"><ul><?php echo $error_message?> </ul></div>
			<?php }?>
			<?php if($success){ ?>
			<div class="success">Update Succesful!</div>
			<?php }?>
			<h3>User Profile:</h3>
			<?php
			$query = "select users.*,login.login_uname from users LEFT JOIN login ON users.users_id=login.login_user_id where users.users_id ='".$user_id."'";
				$result = $conn->query($query);

				if($result->num_rows > 0) {
					

					$jsonarray = array();

					while($row = $result->fetch_assoc()) {
		?>
			<form name="profile" method="post" action="profile.php">
				<div><button type='button' onclick="enableProfileEdit()">Edit Profile</button></div><br>
				<div><img src ='img/defaultprofile.png' class="img responsive"></div>
				<br>
				<div>Full Name : <input type="text" name="fname" value="<?php echo $row['users_fname']?>"  disabled>&nbsp;  <input type="text" name="lname" value="<?php echo $row['users_lname']?>" disabled></div>
				<div>Email Address : <input type="text" name="email" value="<?php echo $row['users_email']?>" disabled></div>
				<div>Phone : <input type="text" name="phone_number" value="<?php echo $row['users_phone']?>" disabled>&nbsp; </div>
				<div>Username : <input type="text" name="username" value="<?php echo $row['login_uname']?>" disabled>&nbsp; </div>
				<div>Password : <input type="password" name="password" value="samepassword" disabled>&nbsp;</div>

				<div><input type='submit' value="Save" disabled> &nbsp;&nbsp;<button type='button' onclick="CancelUserProfile()">Cancel Changes</button></div><br>
			</form>
			</form>


		<?php			
				 	}
				}
		?>


		</section>
	</main>

<?php include "includes/footer.php"; ?>