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
    <form method="POST" enctype="multipart/form-data">
      <label for="pName">Product Name:</label>
      <input type="text" name="pName" value="<?php echo $pName; ?>">

      <label for="pDesc">Product Description:</label>
      <textarea name="pDesc" value="<?php echo $pDesc; ?>"><?php echo $pDesc; ?></textarea>

      <label for="pPrice">Product Price:</label>
      <input type="number" name="pPrice" step="0.01" value="<?php echo $pPrice; ?>">

      <label for="pPhoto">Product Photo:</label>
      <input type="file" name="pPhoto" value="<?php echo $pPhoto;?>">


      <input type="submit" value="Update Product">
      <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
    </form>
    <div class="center">
    <a class="back-button" href="admin.php">Back</a>
	</div>
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
