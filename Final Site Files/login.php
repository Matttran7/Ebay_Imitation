<?php
session_start();
include 'conn_db.php';
if(isset($_POST['username']) && isset($_POST['pass'])){
	
	function validate($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	} // validate
  	
   	$uname = validate($_POST['username']);
   	
	$passw = validate($_POST['pass']);

	// if no login
	if(empty($uname)){
		header ("Location: init.php?error=Fill out username");
		exit();
	}
	if(empty($passw)){
		header("Location: init.php?error=Fill out password");
		exit();
	}
	
   	$sql = "SELECT * from credentials WHERE username='$uname' AND password='$passw'";
   	
	$result = mysqli_query($conn,$sql);
	
	if(mysqli_num_rows($result) == 1){
		// just a test
	   //header("Location: login2.php");
	   $row = mysqli_fetch_assoc($result);
	   if($row['username'] == $uname && $row['password'] == $passw){
		   echo "Successfully Logged in.";
		   setcookie("user", $row['username'], time()+600);
		   setcookie("pass", $row['password'], time()+600);
		$_SESSION['username'] = $row['username'];
		$_SESSION['name'] = $row['name'];
		$_SESSION['id'] = $row['id'];
		//hash password
		$passw = hash('ripemd160',$passw);
		header("Location: homepage.php");
		exit();
	   }
	   else{
		   header("Location: init.php?error=Username or password is incorrect");
		   exit();
	   }
	}
	else{
		header("Location: init.php?error=Could Not Find Credentials");
		exit();
	}
}
else{
   header("Location: init.php?error=No valid");
	   exit();
}
?>
