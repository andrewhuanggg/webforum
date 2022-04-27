<?php


	//grab data from forms
	$username = $_POST['username'];
	$question = $_POST['question'];
	$post_id = $_GET['postid']; //INTEGER
	//print $post_id;
	//connect to database
	include('config.php');

	//data validation
	
	if(empty($username) || empty($question)){
		header('Location: view.php?id='.$post_id.'&notfilled=yes');
		exit();
	}

	$now = time();
	$sql = "INSERT INTO comments (post_id, body, name, time) VALUES ($post_id, '$question', '$username', $now)";
	$db->query($sql);
	//send back to view.php
	header("Location: view.php?id=".$post_id."&filled=yes");
	exit();

?>