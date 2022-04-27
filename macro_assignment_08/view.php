<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Discussion</title>
	<style type="text/css">
		body{
			font-family: Helvetica, sans-serif;
		}
		.hidden {
				display: none;
		}
		textarea {
				resize: none;
				width: 300px;
				height: 100px;
		}
		.correct{
				background-color: green;
				color: white;
				width: 100%;
				height: 15px;
		}

		.incorrect{
				background-color: red;
				color: white;
				width: 100%;
				height: 15px;
		}
	</style>
</head>
<body>
	<form method="post" action="search.php" id="search" style="text-align:right;">
		<input type="text" name="usersearch">

		<input type="submit" value="Search">
	</form>

<a href="index.php"><h1>Discussion Forum:</h1></a>


<?php

	//connect to database
	include('config.php');

	date_default_timezone_set('America/New_York');

	//grab ID of the question
	$id = $_GET['id'];
	//$pretty_time = $_GET['timepost'];

	
	//run a query against the database that grabs this post 
	$sql = "SELECT * FROM posts WHERE id = $id";
	$fullpost = $db->query($sql);
	while($row=$fullpost->fetchArray()){
		?>
		<h1><?php print $row['title']; ?></h1>
		<hr>
		<p><?php 
			$pretty_time = date("F j, Y, g:i a", $row['time']);
			print "Posted by " . $row['name'] . " on " . $pretty_time; 
		?></p>
		<?php
			print "&emsp;&emsp;". $row['body'];
		?>
		<br>
		<br>
		<a href="#@" id="addComm">Add Comment</a><br>
		<?php //data validation
			if($_GET['notfilled']){
				print "<strong class = 'incorrect'>Please fill in all fields!</strong><br>";
				print "<br>";
			}

			else if($_GET['filled']){
				print "<strong class='correct'>Comment has been saved!</strong><br>";
				print "<br>";
			}


		?>
	
		<?php print "<form method='post' action='savecomment.php?postid={$id}' class='hidden' id='commentForm'>";?>
			Username: 
			<br>
			<input type="text" name="username">
			<br>
			Comment:
			<br>
			<textarea name="question"></textarea>
			<br>
			<input type ="submit">
		</form>

		<hr>
	
		<?php
			print "<a href='view.php?id={$id}&sorted=old'>Sort by Oldest</a> - <a href='view.php?id={$id}&sorted=new'>Sort by Newest</a>"; 
		?>
		<?php
	}		
			//connect to databases
			include('config.php');

			date_default_timezone_set('America/New_York');

			//grab all posts
			$sql = "SELECT * FROM comments WHERE post_id = $id";
			$result = $db->query($sql);

			//iterate over posts and display
			if($_GET['sorted']==false){
				while($row = $result->fetchArray()) {
					?>
					<div>
						<p>Commented by <?php   
							$pretty_time = date("F j, Y, g:i a", $row['time']);
							print $row['name'] . " on " . $pretty_time;
						?></p>
						<p><?php print $row['body']; //displays comment?></p> 
						
					</div>
					<hr>

					<?php
				}
			}
			$sqlOldest = "SELECT * FROM comments WHERE post_id = $id ORDER BY time ASC"; //
			$sortedOld = $db->query($sqlOldest);
			$sqlNewest = "SELECT * FROM comments WHERE post_id = $id ORDER BY time DESC"; //
			$sortedNew = $db->query($sqlNewest);

			if($_GET['sorted'] == 'old'){
				while($row = $sortedOld->fetchArray()) {
					?>
					<div>
						<p>Commented by <?php   
							$pretty_time = date("F j, Y, g:i a", $row['time']);
							print $row['name'] . " on " . $pretty_time;
						?></p>
						<p><?php print $row['body']; //displays comment?></p> 
						
					</div>
					<hr>

					<?php
				}
			}

			

			else if($_GET['sorted'] =='new'){
				while($row = $sortedNew->fetchArray()) {
					?>
					<div>
						<p>Commented by <?php   
							$pretty_time = date("F j, Y, g:i a", $row['time']);
							print $row['name'] . " on " . $pretty_time;
						?></p>
						<p><?php print $row['body']; //displays comment?></p> 
						
					</div>
					<hr>

					<?php
				}
			}		
	
?>
<script type="text/javascript">
	let addComm = document.getElementById('addComm')
	let commentForm = document.getElementById('commentForm')
	addComm.onclick = function(){
		if(commentForm.classList.contains('hidden')){
			commentForm.classList.remove('hidden')
		}
		else{
			commentForm.classList.add('hidden')
		}
	}
</script>
</body>
</html>