<?php
 	if(file_exists('../db/db.php')){ // this is for the ajax post direct call to processform.php in case it was called via ajax

	include('../db/db.php');
 	}
	/*
	 * @file: 	processform.php
	 * 
	 * @author: Raghav V. Sampangi (raghav@cs.dal.ca)
	 * 
	 * @desc:	This file processes data submitted to add/edit/delete items to the list.
	 * 
	 * @notes:	As a student working on A4 and A5 in CSCI 2170, you are allowed to edit this file. 
	 * 			When you edit/modify, include block comments to summarize changes. 
	 * 			Clearly highlight what changed and why, and state assumptions if you make any.
	 */


	/*
	 * Processing submitted list item
	 */

	if(!isset($_SESSION)){
		session_start(); // so we can get users info
	}
	if (isset($_POST['submitListItem'])) {

		$list_items = $_POST['list_items']; // ADDED as this will contain the data of the form via array since we can add multiple list at once
		// $listItem = htmlspecialchars(stripslashes(trim($_POST['listItem']))); // was replaced 
		$list_name = $conn->real_escape_string( preg_replace("/[^A-Za-z0-9 ]/", '',trim($_POST['list_name']))); 
		$user_id = $conn->real_escape_string($_SESSION['login_user_id']);
		if(empty($list_name)){
			$list_name = get_new_list_name($conn);
		}

		// echo "<pre>",print_r($listItem),"</pre>";die();



		$insertDataQuery = "INSERT into alllists (`list_name`,`list_archived`, `list_done`,`list_user_id`) values('{$list_name}', '0','0','{$user_id}')";
// echo $insertDataQuery;die();	
		if (!$conn->query($insertDataQuery)) {
			die ("Nooooooooo!" . $conn->error);
		}else{ // insert new data entry
			$list_id = $conn->insert_id;
			if(!empty($list_items)){ // let us check first if user puts items

				foreach($list_items as $item){
					if(!empty($item['value'])){ // let us check first if has value
						$santized_item =  preg_replace("/[^A-Za-z0-9 ]/", '', htmlspecialchars(stripslashes(trim($item['value']))));  // sanitized and remove specia; characters
						$list_item = $conn->real_escape_string($santized_item);
						$insertDataQuery_item = "INSERT into mylist (`l_item`,`l_done`,`l_list_id`) values('{$list_item}', '0','{$list_id}')";
						$conn->query($insertDataQuery_item);

					}
				}
			}
		}
		echo "Success!";
	}

	if (isset($_POST['updateListItem'])) {

		if(isset($_POST['list_items'])){
			$list_items = $_POST['list_items']; // ADDED as this will contain the data of the form via array since we can add multiple list at once
		}else{ // if existed
			$list_items = array();
		}

		if(isset($_POST['list_item_existed'])){
			$list_items_existed = $_POST['list_item_existed']; // This are existing data in the database via array , we need to check one by one and update the fields incase there is an update amade
		}else{ // if no item existed
			$list_items_existed = array();
		}

		// $listItem = htmlspecialchars(stripslashes(trim($_POST['listItem']))); // was replaced 
		$list_name = $conn->real_escape_string( preg_replace("/[^A-Za-z0-9 ]/", '',trim($_POST['list_name']))); 
		$list_id = $conn->real_escape_string(trim($_POST['list_id'])); 
		$user_id = $conn->real_escape_string($_SESSION['login_user_id']);
		if(empty($list_name)){
			$list_name = get_new_list_name($conn);
		}

		 // echo "<pre>",print_r($_POST),"</pre>";die();

		// echo "<pre>",print_r($listItem),"</pre>";die();



		$updateDataQuery = "UPDATE alllists set `list_name` = '{$list_name}' WHERE `list_id` = '{$list_id}'";
// echo $insertDataQuery;die();	
		if (!$conn->query($updateDataQuery)) {
			die ("Nooooooooo!" . $conn->error);
		}else{ // insert new data entry
			if(!empty($list_items)){ // let us insert new items
				foreach($list_items as $item){
					if(!empty($item['value'])){ // let us check first if has value
						$santized_item =  preg_replace("/[^A-Za-z0-9 ]/", '',htmlspecialchars(stripslashes(trim($item['value'])))); // sanitize and remove special charactes
						$list_item = $conn->real_escape_string($santized_item);
						$insertDataQuery_item = "INSERT into mylist (`l_item`,`l_done`,`l_list_id`) values('{$list_item}', '0','{$list_id}')";
						$conn->query($insertDataQuery_item);

					}
				}
			}

			if(!empty($list_items_existed)){ // let us process the existing items
				foreach($list_items_existed as $detail){
					$get_list_detail_id = explode("_", $detail['name']);
					$detail_id = $get_list_detail_id[1];
					$santized_item =  preg_replace("/[^A-Za-z0-9 ]/", '',htmlspecialchars(stripslashes(trim($detail['value']))));// sanitized and remove special characters 
					$list_item_name = $conn->real_escape_string($santized_item);
					$updateDataQuery = "UPDATE mylist set `l_item` = '{$list_item_name}' WHERE `l_id` = '{$detail_id}'";
					$conn->query($updateDataQuery);
				}

			}
		}
		echo "Success!";
	}



	/*
	 *	Processes delete item requests
	 */

	if (isset($_GET['delete'])) {

		$deleteThisItem = $_GET['delete'];
		$deleteQuery = "DELETE from mylist where `l_list_id` = '{$deleteThisItem}'"; // delete first the subtable

		if (!$conn->query($deleteQuery)) {
			die ("Nooooooooo!" . $conn->error);
		}else{
			$deleteQuery = "DELETE from alllists where `list_id` = '{$deleteThisItem}'"; // after complete delete of sub table , delete the main table
			$conn->query($deleteQuery);
			header('Location: '. $_SERVER['HTTP_REFERER']); // go back to previous page

		}
	}

	/*
	 *	Processes completed item requests
	 *  "Mark as done"
	 */

	if (isset($_GET['complete'])) {

		$completeThisItem = $_GET['complete'];

		if (isset($_GET['notdone'])) {

			$notDoneQuery = "UPDATE alllists set `list_done`='0' where list_id = {$completeThisItem}";

			if (!$conn->query($notDoneQuery)) {
				die ("Nooooooooo!" . $conn->error);
			}else{
				header('Location: '. $_SERVER['HTTP_REFERER']);// go back to previous page
			}

		}
		else {

			$completeQuery = "UPDATE alllists set `list_done`='1' where list_id = {$completeThisItem}";

			if (!$conn->query($completeQuery)) {
				die ("Nooooooooo!" . $conn->error);
			}else{
				header('Location: '. $_SERVER['HTTP_REFERER']); // go back to previous page

			}

		}
	}


	/*
	 *	Processes delete item detail requests
	 */

	if (isset($_GET['delete_details'])) {

		$deleteThisItem = $_GET['delete_details'];

		$deleteQuery = "DELETE from mylist where `l_id` = '{$deleteThisItem}'";

		if (!$conn->query($deleteQuery)) {
			die ("Nooooooooo!" . $conn->error);
		}else{
			header('Location: '. $_SERVER['HTTP_REFERER']); // go back to previous page

		}
	}

	/*
	 *	Processes completed item detail requests
	 *  "Mark as done"
	 */

	if (isset($_GET['complete_details'])) {

		$completeThisItem = $_GET['complete_details'];

		if (isset($_GET['notdone'])) {

			$notDoneQuery = "UPDATE mylist set `l_done`='0' where l_id = {$completeThisItem}";

			if (!$conn->query($notDoneQuery)) {
				die ("Nooooooooo!" . $conn->error);
			}else{
				header('Location: '. $_SERVER['HTTP_REFERER']);// go back to previous page
			}

		}
		else {

			$completeQuery = "UPDATE mylist set `l_done`='1' where l_id = {$completeThisItem}";

			if (!$conn->query($completeQuery)) {
				die ("Nooooooooo!" . $conn->error);
			}else{
				header('Location: '. $_SERVER['HTTP_REFERER']); // go back to previous page

			}

		}
	}

	/**get_new_list_name: New function to get new list name since no list name is provided by user**/
	function get_new_list_name($conn){
			$completeQuery = "SELECT max(list_id)+1 as new_id from alllists";

			$result = $conn->query($completeQuery);
			$row = $result->fetch_assoc();
			if(!isset($row['new_id'])){
				$list_name = "My List 1";
			}else{
				$list_name = "My List ".$row['new_id'];
			}
			return $list_name;
	}


?>