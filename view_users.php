<?php 
include "includes/header.php"; 
include "includes/processform.php"; 

?>

<body>
		<?php 

			if(!isset($_SESSION['auth'])){
				include('login.php');
				exit;
			}else{
				$user = $_SESSION['login_user'];
				$role = $_SESSION['login_user_type'];
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


			<!-- jQuery and Bootstrap JavaScript links -->
			<!-- Used from https://www.getbootstrap.com, 29 January 2019 -->
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
				integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
				crossorigin="anonymous"></script>
			<script src="js/bootstrap.bundle.min.js"
				integrity="sha384-zDnhMsjVZfS3hiP7oCBRmfjkQC4fzxVxFhBx8Hkz2aZX8gEvA/jsP3eXRCvzTofP"
				crossorigin="anonymous"></script>
		</div>

		
	</header>

	<main class="container">
		<h1>User List</h1>
		
	<section>
			<br>
			<?php

				$query = "select * from users where users_type !='0'";
				$result = $conn->query($query);

				if($result->num_rows > 0) {
					
					echo "<ul>";

					$jsonarray = array();

					while($row = $result->fetch_assoc()) {

						/* 
							assembling the data into a JSON array */
						array_push($jsonarray, $row);

						/* show list of users */

						echo "<li>";
							echo ucwords($row['users_fname']." ".$row['users_lname'])." | ".$row['users_email'];
						echo "</li>";
					} // while loop ends

					// echo "<div id='jsondiv' onclick='processJsonData();'>";
					// print_r(json_encode($jsonarray));
					// echo "</div>";

					$conn->close();

					echo "</ul>";

				}
				else {
					echo "<p>is currently empty!</p>";
				}
			?>

		</section>
	</main>

<?php include "includes/footer.php"; ?>