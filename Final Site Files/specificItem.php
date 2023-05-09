<html>
<?php
// check if cooke is still valid
if(!isset($_COOKIE['user']) || !isset($_COOKIE['pass'])){
        header("Location: init.php?error=InvalidCookies");
	exit();
}
$id = $_GET["itemID"];
?>
<form action="process.php" method="post">
        <h2>Bid</h2>
            Bid Amount:
	    <input type="number" step="0.01" name="Amount"><br>
	    <input type="hidden" name="id" value="<?php echo $id;?>">
</form>
</html>
