<?php 
include "includes/header.php"; 

?>

<body>
		<?php 

			if(!isset($_SESSION['auth'])){
				include('login.php');
				exit;
			}else{
				$user = $_SESSION['login_user'];
				$logged_in =true;
			}	
		?>

	<header>
		<div class="container">
			<nav class="navbar navbar-dark bg-dark">
				
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="index.php">Dashboard</span></a>
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
		<h1>This is your To Do list</h1>
		<form action="index.php" method="post">
			<input type="text" placeholder="Enter list item" name="listItem">
			<input type="submit" name="submitListItem">
		</form>

		<section>
			<br>
			<h3>Your list:</h3>
			<?php

				$query = "select * from mylist";
				$result = $conn->query($query);

				if($result->num_rows > 0) {
					
					echo "<ul>";

					$jsonarray = array();

					while($row = $result->fetch_assoc()) {

						/* 
							assembling the data into a JSON array */
						array_push($jsonarray, $row);

						/* send list item and options to the client */

						echo "<li>";
						if ($row['l_done']) {
							echo "<span class='complete' onclick='callThisFunction();'>";
						}

						echo $row['l_item'];
						echo "<br>";

						if ($row['l_done']) {
							echo "</span>";
							echo "<a href='index.php?complete={$row['l_id']}&notdone=1'>Mark as not done</a>";
						}
						else {
							echo "<a href='index.php?complete={$row['l_id']}'>Mark as done</a>";
						}

						echo "| <a href='index.php?delete={$row['l_id']}'>Delete item</a><br>&nbsp;";
						echo "</li>";
					} // while loop ends

					echo "<div id='jsondiv' onclick='processJsonData();'>";
					print_r(json_encode($jsonarray));
					echo "</div>";

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