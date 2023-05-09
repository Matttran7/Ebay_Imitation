<?php
session_start();
include 'conn_db.php';
echo "syntax check";
if(!isset($_SESSION['username']) || !isset($_POST['ItemName']) || !isset($_POST['loc']) ||!isset($_POST['Country']) ||!isset($_POST['CloseDate']) ||!isset($_POST['desc'])){
        header("Location: homepage.php?error=InvalidField");
        exit();
}

$username = $_SESSION['username'];
$itemName = $_POST['ItemName'];
$ItemLocation = $_POST['loc'];
$ItemCountry = $_POST['Country'];
$ItemClose = $_POST['CloseDate'];
$ItemDescription = $_POST['desc'];

$id = 0;
$result = NULL;
// for security, generate random ItemID
while($id == 0 || mysqli_num_rows($result) == 1){
	$id = rand(1,10000000000);
	$sql = "SELECT * from tblItems where ItemID='$id' LIMIT 1";
	$result = mysqli_num_rows($conn,$sql);
}
$rating = 0;
// find rating [if they sold before]
$findrating = "SELECT * from tblUsers where Seller='$username' LIMIT 1";
$findResult = mysqli_query($conn,$findrating);
if(mysqli_num_rows($findResult) == 1){
	$findrow = mysqli_fetch_assoc($findResult);
	$rating = (int)$findrow["SellerRating"];
}
$currDate = date("Y-m-d");
$endDate = date("Y-m-d", $ItemClose);

$addsql = "INSERT INTO tblItems (ItemID,Name,Currently,First_Bid,Number_of_Bids,Location,Country,Started,Ends,Seller,Description) VALUES('$id','$itemName',0.0,0.0,0,'$ItemLocation','$ItemCountry','$currDate','$endDate', '$username', '$ItemDescription')";
$addSeller = "INSERT INTO tblUsers (Seller, SellerRating, ItemID) VALUES('$username','$rating','$id')";
mysqli_query($conn,$addsql);
mysqli_query($conn,$addSeller);
header("Location: homepage.php");
?>
