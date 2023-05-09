<?php
//echo "error check";
session_start();
include 'conn_db.php';
// first check if date is still valid
// find back item
$ItemID = $_POST["id"];
$Amount = 0;
$username = $_SESSION['username'];
if(isset($_POST["Amount"])){
	$Amount = $_POST["Amount"];
}
else{header("Location: homepage.php?error=No Amount speficied");}
$sql = "SELECT * from tblItems where ItemID = '$ItemID'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 1){
	// check if expired or too low bid
	$row = mysqli_fetch_assoc($result);
	$currDate = date("Y-m-d");
        $theirDate = strtotime($row["Ends"]);
        $theirDate = date("Y-m-d",$theirDate);
	if($currDate > $theirDate){
		header("Location: homepage.php?error=Bid has closed");
		exit();
	}
	$OrigAmount = floatval($row["Currently"]);
	if($OrigAmount > $Amount){
		header("Location: specificItem.php?error=Bid less than current");
                exit();
	}
	// find previous bids to get rating, location, and country
	$findPrev = "SELECT * from tblBids where BidderID = '$username' LIMIT 1";
	$resultFind = mysqli_query($conn,$findPrev);
	if(mysqli_num_rows($resultFind)==1){
		$row2 = mysqli_fetch_assoc($resultFind);
		$BidderRating = (int)$row2['BidderRating'];
		$BidderLocation = $row2['BidderLocation'];
		$BidderCountry = $row2['BidderCountry'];
	}
	else{
		$BidderRating = 0;
		$BidderLocation = "NA";
		$BidderCountry = "NA";
	}
	// [End] of expire and too low check
	// Insert into tblitems and bidder
	$sql = "UPDATE tblItems SET Number_of_Bids = Number_of_bids+1, Currently= '$Amount' WHERE ItemID = '$ItemID'";
	$sql2 = "INSERT tblBids (BidderID,BidderRating,BidderLocation,BidderCountry,BidTime,BidAmount,ItemID) VALUES('$username','$BidderRating','$BidderLocation','$BidderCountry','$currDate','$Amount','$ItemID')";
	mysqli_query($conn,$sql);
	mysqli_query($conn,$sql2);
	header("Location: homepage.php?error=Success");
	exit();
}
else{
	header("Location: homepage.php?error=IDFault");
	exit();
}
?>
