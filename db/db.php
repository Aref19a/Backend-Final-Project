<?php
	/*
	 * @file: 	db.php
	 * 
	 * @author: Raghav V. Sampangi (raghav@cs.dal.ca)
	 * 
	 * @desc:	This file connects to the database and creates the connection object.
	 * 
	 * @notes:	DO NOT MODIFY THIS FILE.
	 * 			Create a database named 2170 and work using that database for A4 and A5.
	 */
	
	/*
	 *	db.php
	 *	Connects to the Database on localhost.
	 */

	$host = "localhost";
	$un = "root";
	$pw = "root";
	$db = "2170";

	$conn = new mysqli($host, $un, $pw, $db);

	if ($conn->connect_error) {
		die("Nooooooooo!" . $conn->connect_error);
	}

?>