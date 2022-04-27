<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Discussion</title>
		<style type="text/css">
			textarea {
				resize: none;
				width: 300px;
				height: 100px;
			}
			body{
				font-family: Helvetica, sans-serif;
			}

			.hidden {
				display: none;
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

			#search {
				float: right;
			}
		</style>
	</head>
	<body>
		<form method="post" action="search.php" id="search">
			<input type="text" name="usersearch">

			<input type="submit" value="Search">
		</form>
		<h1>Discussion Forum</h1>
		<a href="#!" id = "addPost">Add New Post</a><br><br>
		<?php
			if($_GET['notfilled']){
				print "<strong class = 'incorrect'>Please fill in all fields!</strong><br>";
				print "<br>";
			}

			else if($_GET['filled']){
				print "<strong class='correct'>Question has been saved!</strong><br>";
				print "<br>";
			}


		?>
		
		<form method="post" action="save.php" class="hidden" id ="postForm">
			Username: 
			<br>
			<input type="text" name="username">
			<br>
			Title: 
			<br>
			<input type="text" name="title">
			<br>
			Question:
			<br>
			<textarea name="question"></textarea>
			<br>
			<input type ="submit">
		</form>

		<hr>
		<a href="index.php?sort=old">Sort by Oldest</a> - <a href="index.php?sort=new">Sort by Newest</a> 
		<?php
			
			//connect to databases
			include('config.php');

			date_default_timezone_set('America/New_York');

			//grab all posts
			$sql = "SELECT * FROM posts";
			$result = $db->query($sql);

			//iterate over posts and display
			if($_GET['sort']==false){
				while($row = $result->fetchArray()) {
					?>
					<div>
						<p>Username: <?php print $row['name']; ?></p>
						<p>Title: <?php print $row['title']; ?></p>
						<p>Time: <?php  

							$pretty_time = $today = date("F j, Y, g:i a", $row['time']);
							print $pretty_time;
							//print " - <a href=view.php?id=" . $row['id'] . ">expand</a>";
							print " - <a href=view.php?id=" . $row['id'] . ">expand</a>";
						?></p>
					</div>
					<hr>

					<?php
				}
			}
			$sqlOldest = "SELECT * FROM posts ORDER BY time ASC"; //query for sort by oldest
			$sqlNewest = "SELECT * FROM posts ORDER BY time DESC"; //query for sort by newest
			$sortedOld = $db->query($sqlOldest);
			$sortedNew = $db->query($sqlNewest);
			if($_GET['sort']=='old'){ //sort by oldest
				while($row = $sortedOld->fetchArray()){
					?>
					<div>
					<p>Username: <?php print $row['name']; ?></p>
					<p>Title: <?php print $row['title']; ?></p>
					<p>Time: <?php  

						$pretty_time = $today = date("F j, Y, g:i a", $row['time']);
						print $pretty_time;
						print " - <a href=view.php?id=" . $row['id'] . ">expand</a>";
					?></p>
				</div>
				<hr>
					
				<?php
				}
				
			}

			else if($_GET['sort']=='new'){ //sort by newest
				while($row = $sortedNew->fetchArray()){
					?>
					<div>
					<p>Username: <?php print $row['name']; ?></p>
					<p>Title: <?php print $row['title']; ?></p>
					<p>Time: <?php  

						$pretty_time = $today = date("F j, Y, g:i a", $row['time']);
						print $pretty_time;
						print " - <a href=view.php?id=" . $row['id'] . ">expand</a>";
					?></p>
				</div>
				<hr>
					
				<?php
				}
			}
		?>
		<script type="text/javascript">
			let addPost = document.getElementById('addPost')
			let postForm = document.getElementById('postForm')
			addPost.onclick = function(){
				if(postForm.classList.contains('hidden')){
					postForm.classList.remove('hidden')
				}
				else{
					postForm.classList.add('hidden')
				}
				
			}
		</script>
	</body>
</html>