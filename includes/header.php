<?php
	/*
	 * @file: 	index.php
	 * 
	 * @author: Raghav V. Sampangi (raghav@cs.dal.ca)
	 * 
	 * @desc:	This file is the homepage of the list interface, as developed during class discussions in CSCI 2170.
	 * 
	 * @notes:	As a student working on A4 and A5 in CSCI 2170, you are allowed to edit this file. 
	 * 			Based on the assignment requirements, you are also allowed to move code out of this file to new ones.
	 * 			When you edit/modify, include block comments to summarize changes. 
	 * 			Clearly highlight what changed and why, and state assumptions if you make any.
	 */

if(!isset($_SESSION)){
	session_start();
}

	require_once "db/db.php";

	// require "includes/processform.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>To Do list</title>
	<meta charset="utf-8">
		<link href="css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>