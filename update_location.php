<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['uType']) || $_SESSION['uType'] !== 'Admin') {
	// User is not authenticated or is not a passenger user, redirect to login page
	header('Location: login.php');
	exit();
}
$query = "SELECT * FROM information";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
      
        $row = mysqli_fetch_assoc($result);
        $gps = $row['gps'];
     
        
    } else {
    
        die("Error: Not found.");
    }

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $gpsloc = $_POST['gps'];

    $sql = "SELECT * FROM information";
    $results = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($results) > 0) {
      
        $row = mysqli_fetch_assoc($results);
        $email = $row['email'];
        $contact = $row['contact'];
        $address = $row['address'];
        $gps = $row['gps'];
        $mission = $row['mission'];
        $vision = $row['vision'];
        
    } else {
    
        die("Error: Not found.");
    }
    $sql2 = "UPDATE information SET gps = '$gpsloc'";
  
        // Execute the SQL statement
        if (mysqli_query($conn, $sql2)) {
          echo "Location Changed Succesfully.";

        } else {
          echo "Error: " . mysqli_error($conn);
        }
      header('Location: admin.php');
}
?>
<form enctype="multipart/form-data" method="POST">
    <label for="gps">GPS Location:</label>
    <input type="text" name="gps" value="<?php echo $gps; ?>">
    <input type="submit" value="Save">
  </form>
  <a href="admin.php"><button>Cancel</button></a>