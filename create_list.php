<?php 
include "includes/header.php"; 

?>

<body>
		<?php 
			// checks session
			if(!isset($_SESSION['auth'])){
				include('login.php');
				exit;
			}else{
				$user = $_SESSION['login_user'];
				$logged_in =true;
			}	
		?>

	<!-- Navbar -->
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
					<?php } ?>  <!-- Dropdown menue with users name displayed -->

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

	<!-- List creator -->

	<main class="container">
		<h1>Create New List</h1>
		<form action="index.php" method="post">
			<input type="text" placeholder="New List Name" name="listName">
			<h5>Add Item:</h5>
			<div class="list_item" >
			<ul>
				<li><input type="text" placeholder="New List Item" class="list_item_part"  name="listItem[]"></li>

			</ul>
			</div>
			<br>
			<button type="button" name="add_more_item" onclick="AddMoreItem()">Add More Item</button>

			<div class="marginized">
				<button type="button" class="save_list" onclick="AddToDoList()">Save the List</button>&nbsp;&nbsp;
				<a href="index.php"><button type="button" class="discard_list">Discard the List</button></a>
			</div>
			<!-- <input type="submit" name="submitListItem"> -->
		</form>

	</main>

<?php include "includes/footer.php"; ?>