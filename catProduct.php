<?php 
// Detect the current session
session_start();

// Check if user logged in 
if (! isset($_SESSION["ShopperName"])) {
	// redirect to login page if the session variable shopperid is not set
	header ("Location: login.php");
	exit;
}

// Create a container, 60% width of viewport
$MainContent = "<div style='width:60%; margin:auto;'>";
// Display Page Header - 
// Category's name is read from query string passed from previous page.
$MainContent .= "<div class='row' style='padding:5px'>";
$MainContent .= "<div class='col-12'>";
$MainContent .= "<span class='page-title'>$_GET[catName]</span>";
$MainContent .= "</div>";
$MainContent .= "</div>";

include("mysql.php");  // Include the class file for database access
$conn = new Mysql_Driver();  // Create an object for database access
$conn->connect(); // Open database connnection

// To Do:  Starting ..../
$cid=$_GET["cid"]; // Read Category ID from query string
// SQL to retireve list of products associated to the category ID
$qry = "SELECT p.ProductID, p.ProductTitle, p.ProductImage, p.Price, p.Quantity
		FROM CatProduct cp INNER JOIN product p ON cp.ProductID = p.ProductID
		WHERE cp.CategoryID=$cid";
//Display each product in a row
$result = $conn->query($qry);//execute the sql statement

while ($row = $conn->fetch_array($result))
{
	//start a new row
	$MainContent .= "<div class='row' style='padding:5px'>";
	//left column - display a text link showing the product's name
	//Display that selling price in red in a new paragraph
	$product = "productDetails.php?pid=$row[ProductID]";
	$formattedPrice = number_format($row["Price"], 2);
	$MainContent .= "<div class='col-8'>"; // 67% of row width
	$MainContent .= "<p><a href=$product>$row[ProductTitle]</a></p>";
	$MainContent .= "Price:<span style='font-weight:bold; color:red;'>
					S$ $formattedPrice</span>";
	$MainContent .= "</div>";
	
	//Right column
	$img = "./Images/products/$row[ProductImage]";
	$MainContent .= "<div class='col-4'>";//33% of row width
	$MainContent .= "<img src='$img '/>";
	$MainContent .= "</div>";
	$MainContent .= "</div>"; //End of row
}

// To Do:  Ending ....

$conn->close(); // Close database connnection
$MainContent .= "</div>"; // End of container
include("MasterTemplate.php");  
?>
