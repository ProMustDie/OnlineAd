<?php

// Set up database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesun";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize and validate form data
$name = empty($_POST['title']) ? false : $_POST['title'];
$description = empty($_POST['description']) ? false : $_POST['description'];
$id = empty($_POST['UserID']) ? false : $_POST['UserID'];
$categories = empty($_POST['category']) ? [] : $_POST['category'];

if ($name === false || $description === false || $id === false) {
    // Handle missing form fields
    echo '<script type="text/javascript">';
    echo 'alert("Please fill in all the required fields!");';
    echo 'window.location = "../Request.php";';
    echo '</script>';
} else {
    // Handle file upload
    if ($_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
        // Validate the uploaded file
        $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
        $fileName = $_FILES['fileUpload']['name'];
        $fileSize = $_FILES['fileUpload']['size'];
        $fileType = $_FILES['fileUpload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'png', 'jpeg');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            echo 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            exit;
        }

        // Generate a new unique file name to prevent overwriting
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $uploadFileDir = "../img/classifiedIMG/";
        $actualFileDir = "img/classifiedIMG/";
        $Image = $uploadFileDir . $newFileName;
        $ImageLoc = $actualFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $Image)) {
            // Use prepared statement to insert data
            $sql = "INSERT INTO ads (AdName, AdDescription, price, AdAuthorID, AdStatus, AdPicture, AdCategory, AdPostedDateTime) VALUES (?, ?, NULL, ?, 'Pending Review', ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $name, $description, $id, $ImageLoc, implode(",", $categories));

            if ($stmt->execute()) {
                echo '<script type="text/javascript">';
                echo 'alert("You have requested an Ad");';
                echo 'window.location = "../Request.php";';
                echo '</script>';
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.';
        }
    } else {
        // Handle case where no image is uploaded
        echo '<script type="text/javascript">';
        echo 'alert("No picture uploaded!");';
        echo 'window.location = "../Request.php";';
        echo '</script>';
    }
}

// Close the connection
mysqli_close($conn);
?>
