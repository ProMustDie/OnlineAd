<?php

//set-up
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

$name = empty($_POST['title']) ? false :  $_POST['title'];
$description = empty($_POST['description']) ? false :  $_POST['description'];
$id = empty($_POST['UserID']) ? false : $_POST['UserID'];
$category = empty($_POST['category']) ? false : implode(",",$_POST['category']);


if (!($name == false || $description == false || $category == false)) {
    //means no image uploaded
    if (!($_FILES['fileUpload']['error'] == 4)) {
        if ($_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
            // get details of the uploaded file
            $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
            $fileName = $_FILES['fileUpload']['name'];
            $fileSize = $_FILES['fileUpload']['size'];
            $fileType = $_FILES['fileUpload']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // sanitize file-name and getting form value
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // check if file has one of the following extensions
            $allowedfileExtensions = array('jpg', 'png', 'jpeg');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // directory in which the uploaded file will be moved

                $uploadFileDir = "../img/classifiedIMG/";
                $actualFileDir = "img/classifiedIMG/";
                //$dest_path = $uploadFileDir . $fileName;
                $Image = $uploadFileDir . $newFileName;
                $ImageLoc = $actualFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $Image)) {
                    $message = 'File is successfully uploaded.';

                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "INSERT INTO ads (AdName, AdDescription, price, AdAuthorID, AdStatus, AdPicture, AdCategory, AdPostedDateTime) VALUES 
                    ('$name', '$description', 0, '$id', 'Pending Review','$ImageLoc', '$category', 0)";



                    if (mysqli_query($conn, $sql)) {
                        echo '<script type="text/javascript">';
                        echo 'alert("You have requested an Ad");';
                        echo 'window.location = "../Request.php";';
                        echo '</script>';
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }


                    mysqli_close($conn);
                } else {
                    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                }
            } else {
                $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
            }
        } else {
            $message = 'There is some error in the file upload. Please check the following error.<br>';
            $message .= 'Error:' . $_FILES['fileUpload']['error'];

            echo $message;
            echo '<br><a href="../home.php">Try Again</a>';
        }
    } else {

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        echo '<script type="text/javascript">
                alert("No picture uploaded!';
        if ($redirect != "") {
            echo ' ");
                   window.location ="../' . $redirect;
        } else {
            echo ' ");
                   window.location ="../home.php';
        }

        echo '";
                   </script>';


        mysqli_close($conn);
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Please fill in all the required fields!");';
    echo 'window.location = "../Request.php";';
    echo '</script>';
}
