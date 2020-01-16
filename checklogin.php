<?php
// Detect the current session
include("mysql.php");

session_start();

$myemail = $_POST['email'];
$mypassword = $_POST['password']; 

//create an object for mysql database access
$conn = new Mysql_Driver();
$conn->connect();


//include the utility class file for MySQL database access

$qry = "SELECT ShopperID,Name from Shopper WHERE Email = '$myemail' and Password = '$mypassword'";
$result = $conn->query($qry);
$count = mysqli_num_rows($result);


if ($count == 1){
	$row = $conn->fetch_array($result);
	$_SESSION["ShopperName"] = $row["Name"];
	$_SESSION["ShopperID"] = $row["ShopperID"];
	header("location: index.php");
}	

else{
	header("location: login.php");
	return false;
}

include("MasterTemplate.php");


?>

