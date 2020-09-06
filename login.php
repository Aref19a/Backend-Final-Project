<?php 
include "includes/header.php"; 
$logged_in = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 
   $username = $_POST['username'];
   $password = $_POST['password'];



   // function password_verify($username="", $password=""){
	   $myusername = mysqli_real_escape_string($conn,$username);
	   $mypassword = mysqli_real_escape_string($conn,$password); 
	   // echo $mypassword;die();
	   $encrypted_password = password_hash($mypassword, PASSWORD_DEFAULT);
	   $sql = "SELECT users.* , `login`.login_pswd FROM users LEFT JOIN login ON `users`.users_id = `login`.login_user_id  WHERE `login`.login_uname = '$myusername'";
	   // echo $sql;die();
	   $result = mysqli_query($conn,$sql);
	   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	   // $active = $row['active'];
	   $fullname = $row['users_fname']. " ".$row['users_lname'];
	   $user_type = $row['users_type'];
	   $user_id = $row['users_id'];

	   $count = mysqli_num_rows($result);
	   
	   // If result matched $myusername and $mypassword, table row must be 1 row
	     // echo $encrypted_password." :: ".$row['login_pswd'];die();
	   if($count == 1 && password_verify($mypassword,$row['login_pswd'])) {
	      $_SESSION['login_username'] = $username;
	      $_SESSION['login_user'] = $fullname;
	      $_SESSION['login_user_type'] = $user_type;
	      $_SESSION['login_user_id'] = $user_id;

	      $_SESSION['auth'] = true;
	      header("Location: index.php");
	   }else {
	      $error = "Your Login Name or Password is invalid";
	      header("Location: index.php?e=1");
	   }
   // }
}

?>

<body>
	<header>
		<div class="container">
			<nav class="navbar navbar-dark bg-dark">
				
				<!-- <ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="dashboard.php">Dashboard</span></a>
					</li>
					<?php if($logged_in) { ?>
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				          <?php echo ucwords($user);?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
				          <a class="dropdown-item" href="./includes/logout.php">Logout</a>
				        </div>
				      </li>
				      <?php }?>
				</ul> -->
			</nav>
		</div>
		</header>
		<main class="container">
			<div>
				<?php
				if(!$logged_in && isset($_GET['e']) && $_GET['e'] == '1'){
					echo "<h5 class='error'>Login is invalid!</h5>";
				}
				?>

				<div>
					<h4>Please login to proceed:</h4>
					<?php if(!$logged_in) { ?>
					<form action="login.php" method="POST">
						<label>UserName :</label><input type="text" name="username" class="login" required><br />
						<label>Password :</label><input type="password" name="password" class="login" required><br /><br />
						<input type="submit" value=" Submit " class="login"><br /> <br />
					</form>
					<?php }else{ ?>
						<h5>Welcome <?php echo ucwords($user);?>!</h5>
					<?php }?>
				</div>
		</main>

<?php include "includes/footer.php"; ?>