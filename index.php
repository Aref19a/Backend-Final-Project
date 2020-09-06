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
		<h1>This is your To Do list</h1>
		<div>
		 <a href="create_list.php"><button>Create New List</button></a>
		</div>

		<section>
			<br>
			<h3>Your list:</h3>
			<?php

				//connects and reads data from alllists
				$query = "select * from alllists";
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
						if ($row['list_done']) {
							echo "<span class='complete' onclick='callThisFunction();'>";
						}

						echo  "<p id='list_name_".$row['list_id']."'>".$row['list_name']."</p>";
						echo "<div class='hidden' id='quick".$row['list_id']."'><input type='text' name='quick_edit_".$row['list_id']."' value='".$row['list_name']."'><input type='button' value='Save' onclick='QuickEditSave(".$row['list_id'].")'>&nbsp;&nbsp;<input type='button' value='Cancel' name='quick_edit_cancel' onclick='QuickEditCancel(".$row['list_id'].")'></div>";
						echo "<a href='update_list.php?list_id={$row['list_id']}' class='edit_list' ref='".$row['list_id']."'>Edit List</a> |";
						if ($row['list_done'] == '1') {
							// echo "</span>";
							echo "<a href='index.php?complete={$row['list_id']}&notdone=1' class='masndone' ref='".$row['list_id']."'> Mark as not done </a>";
						}
						else {
							echo "<a href='index.php?complete={$row['list_id']}' class='masdone' ref='".$row['list_id']."'> Mark as done </a>";
						}

						echo "| <a href='index.php?delete={$row['list_id']}' ref='".$row['list_id']."'>Delete List</a><br>&nbsp;";
						echo "| <button onclick='tryQuickEdit(".$row['list_id'].")'>Quick Edit</button><br>&nbsp;";
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