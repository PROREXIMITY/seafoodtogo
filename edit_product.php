<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['uType']) || $_SESSION['uType'] !== 'Admin') {
	// User is not authenticated or is not a passenger user, redirect to login page
	header('Location: login.php');
	exit();
}
// Check if the product ID is provided in the URL
if (isset($_GET['pID'])) {
  $pID = $_GET['pID'];

  // Check if the form is submitted for updating the product
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the product details from the form
    if (isset($_POST['delete'])) {
        // Delete the product from the database
        $sql = "DELETE FROM `product` WHERE `pID` = $pID";
        $result = mysqli_query($conn, $sql);
  
        // Check if the deletion was successful
        if ($result) {
          echo "Product deleted successfully.";
          header('Location: admin.php');
          exit; // Stop further execution
        
        } else {
          echo "Error deleting product: " . mysqli_error($conn);
        }
      }
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
        $sql = "UPDATE `product` SET `pName` = '$pName', `pDesc` = '$pDesc', `pPrice` = '$pPrice' , pPhoto =  '$photo' WHERE `pID` = $pID";
  
        // Execute the SQL statement
        if (mysqli_query($conn, $sql)) {
          echo "Product added successfully.";
        } else {
          echo "Error: " . mysqli_error($conn);
        }
      } else {
        echo "Error: Failed to upload the file.";
      }
    }
  }

  // Fetch the product data from the database
  $sql = "SELECT `pID`, `pName`, `pDesc`, `pPrice`, `pPhoto` FROM `product` WHERE `pID` = $pID";
  $result = mysqli_query($conn, $sql);

  // Check if the query was successful
  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $pName = $row['pName'];
    $pDesc = $row['pDesc'];
    $pPrice = $row['pPrice'];
    $pPhoto = $row['pPhoto'];
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
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      
		}

		h2 {
			font-family: "Roboto", sans-serif;
			text-align: center;
			margin-bottom: 20px;
		}

		form {
			text-align: center;
		}

		label {
			display: block;
			margin-bottom: 5px;
			text-align: left;
		}

		input[type="text"],
		input[type="number"],
		textarea {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

		input[type="file"] {
			margin-top: 5px;
		}

		input[type="submit"],
		button {
			background-color: #f56e00;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type="submit"]:hover,
		button:hover {
			background-color: #ff7f00;
		}

		.back-button {
			display: inline-block;
			margin-top: 20px;
			background-color: #f56e00;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 4px;
			cursor: pointer;
		}

		.back-button:hover {
			background-color: #ff7f00;
		}

		.center {
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>Update Product</h2>
		<form method="POST" enctype="multipart/form-data">
			<label for="pName">Product Name:</label>
			<input type="text" name="pName" value="<?php echo $pName; ?>">

			<label for="pDesc">Product Description:</label>
			<textarea name="pDesc"><?php echo $pDesc; ?></textarea>

			<label for="pPrice">Product Price:</label>
			<input type="number" name="pPrice" step="0.01" value="<?php echo $pPrice; ?>">

			<label for="pPhoto">Product Photo:</label>
			<input type="file" name="pPhoto">

			<input type="submit" value="Update Product">
			<button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
		</form>
		<div class="center">
			<a class="back-button" href="admin.php">Back</a>
		</div>
	</div>
</body>
</html>
<?php
    // Free the result set
    mysqli_free_result($result);
  } else {
    // Handle the error if the query fails
    echo "Error: " . mysqli_error($conn);
  }

  // Close the database connection
  mysqli_close($conn);
} else {
  echo "Product ID not provided.";
}
?>
