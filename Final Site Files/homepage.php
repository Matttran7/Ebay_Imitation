<?php
session_start();

if(isset($_SESSION['username'])){
	?>
	<html>
	<head>
		<title>Home page</title>
	</head>
	<body>
		<h1> Hello <?php echo $_SESSION['username']; ?></h1>
		<a href="logout.php">Logout</a><br>
		<a href="add.php">Add a listing</a><br><br>
		<form method="post" action="getData.php">
		Search:<br>
		<input type="text" name="Text"><br>
		Type:
		<input type="radio" name="type" value="description" checked="checked"/>In Description
		<input type="radio" name="type" value="seller"/>In Seller
		<input type="radio" name="type" value="category"/>In category
		</form><br>
		
	</body>
	</html>
	<?php
}
else{
	header("Location: init.php");
	exit();
}
?>
