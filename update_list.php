<?php 
include "includes/header.php"; 
// include "includes/processform.php"; 

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

			if(isset($_GET['list_id'])){
				$list_id = $_GET['list_id'];
			}else{
 				header('Location:index.php');

			}
			$query = "select list_name,mylist.* from alllists left join mylist ON alllists.list_id = mylist.l_list_id where list_id ='".$list_id."' ";
				$result = $conn->query($query);
				$list_name = "";
				$list_items = array();//gather here the list of items for use later 
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$list_name = $row['list_name']; // get the list_name
						$list_items[] = $row;
					}
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
		<h1>Update List</h1>
		<form action="index.php" method="post">
			<input type="text" placeholder="New List Name" value="<?php echo $list_name ?>" name="listName">
			<h5>Add Item:</h5>
			<div class="list_item" >
				<?php 	
				echo "<ul>";
				foreach($list_items as $row) {
				// print_r($row); 
					if(empty($row['l_id'])){
						continue;
					}
					echo "<li  ref = '".$row['l_id']."'>";
						echo 	"<input type='text' placeholder='New List Item' class='list_item_part' value='".$row['l_item']."' name='listItem_".$row['l_id']."'>";
						echo "<br>";
					
						if ($row['l_done'] == '1') {
							// echo "</span>";
							echo "<a href='includes/processform.php?complete_details={$row['l_id']}&notdone=1' class='masndone' > Mark as not done </a>";
							echo "<a href='includes/processform.php?complete_details={$row['l_id']}' class='masdone'  style='display:none;'> Mark as done </a>";
						}
						else {
							echo "<a href='includes/processform.php?complete_details={$row['l_id']}' class='masdone' > Mark as done </a>";
							echo "<a href='includes/processform.php?complete_details={$row['l_id']}&notdone=1' class='masndone' style='display:none;'> Mark as not done </a>";
						}

						echo "| <a href='includes/processform.php?delete_details={$row['l_id']}'>Delete List</a><br>&nbsp;";
						echo "</li>";

					?>

			<!-- 	<input type="text" placeholder="New List Item" class="list_item_part"  name="listItem[]" value="<?php echo $row['l_item'] ?>">
 -->
				<?php } 

				echo "</ul>";?>
			</div>
			<br>
			<button type="button" name="add_more_item" onclick="AddMoreItem()">Add More Item</button>

			<div class="marginized">
				<button type="button" class="save_list" onclick="UpdateItemList(<?php echo $list_id?>)">Save the List</button>&nbsp;&nbsp;
				<a href="index.php"><button type="button" class="discard_list">Discard the List</button></a>
			</div>
			<!-- <input type="submit" name="submitListItem"> -->
		</form>

	</main>

<?php include "includes/footer.php"; ?>