<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Discussion Forum</title>
	<style type="text/css">
		p{
		  font-family: Helvetica, sans-serif;	
		}

		div{
		  font-family: Helvetica, sans-serif;	
		}
	</style>
</head>
<body>

</body>
</html>

<?php
print "<a href='index.php'><h1 style = 'font-family: Helvetica, sans-serif;'>Discussion Forum:</h1></a>";
print "<hr>";

	$usersearch = $_POST['usersearch']; //grab from index.php search form 
	include('config.php');//connect to db
	date_default_timezone_set('America/New_York');

	//search through posts 
	$sqlPosts = "SELECT * FROM posts WHERE body LIKE '%{$usersearch}%' OR title LIKE '%{$usersearch}%' OR name LIKE '%{$usersearch}%'"; 
	$searchPost = $db->query($sqlPosts);
	//display posts

	print "<h3 style='font-family: Helvetica, sans-serif;text-align:center;'>Posts containing '{$usersearch}'</h3>";
	
	print"<hr>";
	if(empty($usersearch)){
		print "<p style='text-align:center;'>No posts found</p>";
	}
	else if(empty($usersearch)==false){
		while($row = $searchPost->fetchArray()) {
			?>
			<div>
				<p>Username: <?php print $row['name']; ?></p>
				<p>Title: <?php print $row['title']; ?></p>
				<p>Time: <?php  

					$pretty_time = $today = date("F j, Y, g:i a", $row['time']);
					print $pretty_time;
					//print " - <a href=view.php?id=" . $row['id'] . ">expand</a>";
					print " - <a href=view.php?id=" . $row['id'] . ">view full post</a>";
				?></p>
			</div>
			<hr>

			<?php
		}
	}
	
	//if(empty($searchPost->fetchArray())){
	if(!($searchPost->fetchArray())){
		print "<p style='text-align:center;'>No posts found</p>";
	}
	//search through comments
	$sqlComments = "SELECT * FROM comments WHERE body LIKE '%{$usersearch}%' OR name LIKE '%{$usersearch}%'";
	$searchComment = $db->query($sqlComments); 

	//display comments
	print "<h3 style='font-family: Helvetica, sans-serif;text-align:center;'>Comments containing '{$usersearch}'</h3>";
	
	print"<hr>";
	if(empty($usersearch)){
		print "<p style='text-align:center;'>No comments found</p>";
	}
	else if(empty($usersearch)==false){

		while($row = $searchComment->fetchArray()) {
			?>
			<div>
				<p>Commented by <?php   
					$pretty_time = date("F j, Y, g:i a", $row['time']);
					print $row['name'] . " on " . $pretty_time;
				?></p>
				<p><?php print $row['body']; //displays comment?></p> 
				<?php print "  <a href=view.php?id=" . $row['post_id'] . ">view full post</a>";?>
				
			</div>
			<hr>

			<?php
		}
	}
	//if(empty($searchComment->fetchArray())){
	if(!($searchComment->fetchArray())){
		print "<p style='text-align:center;'>No comments found</p>";
	} 

?>