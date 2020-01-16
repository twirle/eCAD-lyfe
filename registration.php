<?php
// Detect the current session
session_start();
$MainContent = "";

//read the data input from previous page
$name = $_POST["name"];
$address = $_POST["address"];
$country = $_POST["country"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];

//include the utility class file for MySQL database access
include("mysql.php");
//create an object for mysql database access
$conn = new Mysql_Driver();
$conn->connect();
//define the INSERT SQL Statement
$qry = "INSERT INTO Shopper (name, address, country, phone, email, password)
		VALUES ('$name', '$address', '$country', '$phone', '$email', '$password')";
//execute the sql statement

$result = $conn->query($qry);

if($result == true){ //SQL statement executed successfully	
	//Retrieve the shopper ID assigned to the new shooper
	$qry = "SELECT LAST_INSERT_ID() AS ShopperID";
	$result = $conn->query($qry);
	//save the shopper ID in a session variable
	while($row = $conn->fetch_array($result)){
		$_SESSION["ShopperID"] = $row["ShopperID"];
	}
	//Display successful message and shopper ID
	$MainContent .= "Registration successful!<br/>";
	$MainContent .= "Your ShopperID is $_SESSION[ShopperID]<br/>";
	//Save the shopper name in a session variable
	$_SESSION["ShopperName"] = $name;
}
else { //display error message
	$MainContent .= "<h3 style='color:red'>Error in inserting record</h3>";
}

//Close Database connection
$conn->close();

include("MasterTEmplate.php");

?>