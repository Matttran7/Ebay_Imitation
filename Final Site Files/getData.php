
<?php
	// Below comment checks for syntax errors
	//echo "no error";
   session_start();
   include 'conn_db.php';
	  
   $text = $_POST['Text'];
   $tbl = 0;
   $sql = 'Select * from tblUsers LIMIT 1';
   $theType = $_POST["type"];   
   if($theType == "description"){
   	$sql = "SELECT * from tblItems where description LIKE '%".$text."%' ORDER BY Ends DESC, Currently ASC";
   	$tbl = 1;
   }
   else if($theType == 'seller'){
   	$sql = "SELECT * from tblUsers inner join tblItems ON tblUsers.ItemID = tblItems.ItemID where tblUsers.Seller LIKE '%".$text."%' ORDER BY Ends DESC, Currently ASC";
   	$tbl = 2;
   }
   else if($theType == 'category'){
	   $sql = "SELECT * from tblCategory inner join tblItems ON tblCategory.ItemID = tblItems.ItemID where Category LIKE '%".$text."%' ORDER BY Ends DESC, Currently ASC";
   	$tbl = 3;
   }
   else{
	   header("Location: homepage.php?error=RadioButtionError");
	   exit();
   }

  $result = mysqli_query($conn,$sql);
	echo '<table cellpadding="10">';
   // tblItems
   $allData = mysqli_fetch_all($result,MYSQLI_ASSOC);

   $howMany = count($allData);
   for($i = 0; $i<$howMany; $i++){
	if($i >= 100){break;}
	$each = $allData[$i];
	$itID = (int)$each['ItemID'];
	echo '<tr><td> Name: '.$each["Name"].'</td>
		<td> Seller: '.$each["Seller"].'</td>
		<td> Current Bid: '.$each["Currently"].'</td>
		    <td>Close: '.$each["Ends"].'</td>
			<td># of Bids: '.$each["Number_of_Bids"].'</td>';

	$bidID = "NA";
	$findhighestbidder = "SELECT BidderID, MAX(BidAmount) from tblBids where ItemID='$itID' GROUP BY BidderID LIMIT 1";
	$findbidRes = mysqli_query($conn,$findhighestbidder);
	if(mysqli_num_rows($findbidRes) == 1){
		$rowBid = mysqli_fetch_assoc($findbidRes);
		$bidID = $rowBid["BidderID"];
	}

	$currDate = date("Y-m-d");
	$theirDate = strtotime($each["Ends"]);
	$theirDate = date("Y-m-d",$theirDate);
	if($currDate < $theirDate){
		echo '<td><a href="specificItem.php?itemID='.$each['ItemID'].'">Bid</a></td>';
	}
	else{
		echo '<td>Not biddable</td>';
	}
	echo '<td> Current Day:'.$currDate.'</td>';
	echo '<td> Top Bidder: '.$bidID.'</td>';
	echo '</tr>';
   }
	echo '</table>';
?>
