<?php

	//grab data from form
	$username = $_POST['username'];
	$title = $_POST['title'];
	$question = $_POST['question'];
	
	//connect to database!
	//$path = 'C:\Users\ghett\Documents\MAMP\webdev\macro_assignment_08\databases';
	//$db = new SQLite3($path.'\discussion.db');
	include('config.php');

	//validation (DO THIS)
	if(empty($username) || empty($title) || empty($question)){
		header('Location: index.php?notfilled=yes');
		exit();
	}


	//if everything is OK, save the record into database
	$now = time();
	$sql = "INSERT INTO posts (title, body, name, time) VALUES ('$title', '$question', '$username', $now)";
	$db->query($sql);
	// send them back to index.php

	header("Location: index.php?filled=yes");
	exit();

?>