<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['uType']) || $_SESSION['uType'] !== 'Admin') {
	// User is not authenticated or is not a passenger user, redirect to login page
	header('Location: login.php');
	exit();
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the product details from the form
  $pName = $_POST['pName'];
  $pDesc = $_POST['pDesc'];
  $pPrice = $_POST['pPrice'];
  
  // Process the uploaded photo
  $targetDirectory = "assets/img/"; // Specify the directory where the uploaded images will be stored
  $targetFile = $targetDirectory . basename($_FILES["pPhoto"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  $photo = basename($_FILES["pPhoto"]["name"]);
  // Check if the file is an actual image
  $check = getimagesize($_FILES["pPhoto"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo "Error: File is not an image.";
    $uploadOk = 0;
  }

//   // Check if the file already exists
//   if (file_exists($targetFile)) {
//     echo "Error: File already exists.";
//     $uploadOk = 0;
//   }

//   // Check the file size (adjust the limit as per your requirements)
//   if ($_FILES["pPhoto"]["size"] > 500000) {
//     echo "Error: File size is too large.";
//     $uploadOk = 0;
//   }

  // Allow only specific image file formats (you can add more if needed)
  if (
    $imageFileType != "jpg" &&
    $imageFileType != "jpeg" &&
    $imageFileType != "png"
  ) {
    echo "Error: Only JPG, JPEG, and PNG files are allowed.";
    $uploadOk = 0;
  }

  // Check if the file was successfully uploaded
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["pPhoto"]["tmp_name"], $targetFile)) {
      // File uploaded successfully, now insert the product details into the database

      // Prepare the SQL statement
      $sql = "INSERT INTO `product` (`pName`, `pDesc`, `pPrice`, `pPhoto`) VALUES ('$pName', '$pDesc', '$pPrice', '$photo')";

      // Execute the SQL statement
      if (mysqli_query($conn, $sql)) {
        
      } else {
        echo "Error: " . mysqli_error($conn);
      }
    } else {
      echo "Error: Failed to upload the file.";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<style>
		body {
			font-family: "Open Sans", sans-serif;
			color: #444444;
			background-color: #f2f2f2;
		}
	a {
		color: #f56e00;
		text-decoration: none;
	}

	a:hover {
		color: #f56e00;
		text-decoration: none;
	}

	.container {
		width: 400px;
		margin: 0 auto;
		margin-top: 100px;
		padding: 20px;
		background-color: #ffffff;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-shadow: 0px 0px 8px #cccccc;
	}

	label {
		display: block;
		margin-bottom: 10px;
		font-weight: bold;
	}

	input[type="text"],
	input[type="number"],
	textarea {
		width: 100%;
		padding: 8px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-bottom: 20px;
	}

	input[type="file"] {
		margin-bottom: 20px;
	}

	input[type="submit"] {
		background-color: #f56e00;
		color: #ffffff;
		border: none;
		border-radius: 4px;
		padding: 10px 20px;
		cursor: pointer;
	}

	.back-button {
		background-color: #f56e00;
		color: #ffffff;
		border: none;
		border-radius: 4px;
		padding: 10px 20px;
		text-align: center;
		display: inline-block;
		margin-top: 20px;
		cursor: pointer;
	}

	.back-button:hover {
		background-color: #d64e00;
	}

	.center {
		text-align: center;
	}
</style>
<div class="container">
<!-- HTML form for adding a new product -->
<form action="add_product.php" method="POST" enctype="multipart/form-data">
  <label for="pName">Product Name:</label>
  <input type="text" name="pName" required><br><br>

  <label for="pDesc">Product Description:</label>
  <textarea name="pDesc" rows="4" required></textarea><br><br>

  <label for="pPrice">Product Price:</label>
  <input type="number" name="pPrice" step="0.01" required><br><br>

  <label for="pPhoto">Product Photo:</label>
  <input type="file" name="pPhoto" required><br><br>

  <input type="submit" value="Add Product">
</form>
<div class="center">
    <a class="back-button" href="admin.php">Back</a>
	</div>
  </div>