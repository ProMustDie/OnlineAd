<?php

include('app.php');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize and validate form data
$name = empty($_POST['title']) ? false : $_POST['title'];
$description = empty($_POST['description']) ? false : $_POST['description'];
$id = empty($_POST['UserID']) ? false : $_POST['UserID'];
$AdID = empty($_POST['AdID']) ? false : $_POST['AdID'];
$categories = empty($_POST['category']) ? false : $_POST['category'];
$request = isset($_GET['request']) ? $_GET['request'] : false;
$image = isset($_FILES['fileUpload']) ? $_FILES['fileUpload'] : false;
$redirect = empty($_POST['redirect']) ? "Main.php" : $_POST['redirect'];
?>

<script>
    var input = $image;
    var fileSize = input.files[0].size; // Size in bytes
    var maxSize = 1 * 1024 * 1024; // 3MB in bytes

    if (fileSize > maxSize) {
        alert('Image size must be less than 3MB. Please choose a smaller image.');
        header($redirect);
    }
</script>

<?php

if (($name === false || $id === false || $categories == false) && $request != "payment") {
    // Handle missing form fields
    echo '<script type="text/javascript">';
    echo 'alert("Please fill in all the required fields!");';
    echo 'window.location = "../' . $redirect . '";';
    echo '</script>';
} else {

    // Handle file upload
    if (!($_FILES['fileUpload']['error'] == 4)) {
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
            if ($request == "payment") {
                $uploadFileDir = "../img/transactionIMG/";
                $actualFileDir = "img/transactionIMG/";
            } else {
                $uploadFileDir = "../img/classifiedIMG/";
                $actualFileDir = "img/classifiedIMG/";
            }
            $Image = $uploadFileDir . $newFileName;
            $ImageLoc = $actualFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $Image)) {
                // Use prepared statement to insert data
                if ($request != "payment") {
                    $cat = implode(",", $categories);
                    $sql = "INSERT INTO ads (AdName, AdDescription, Price, AdAuthorID, AdStatus, AdPicture, AdCategory, AdPostedDateTime, AdRequestedDate, AdRejectedDate) VALUES (?, ?, NULL, ?, 'Pending Review', ?, ?, NOW(), NOW(), NULL)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $name, $description, $id, $ImageLoc, $cat);
                    if ($stmt->execute()) {
                        echo '<script type="text/javascript">';
                        echo 'alert("You have requested an Ad");';
                        echo 'window.location = "../history.php";';
                        echo '</script>';
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                } else {
                    $sql = "UPDATE ads SET AdPaymentPicture = ?, AdStatus = 'Checking Payment' WHERE AdID = ?;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $ImageLoc, $AdID);
                    if ($stmt->execute()) {
                        echo '<script type="text/javascript">';
                        echo 'alert("Transaction receipt uploaded!");';
                        echo 'window.location = "../history.php";';
                        echo '</script>';
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                }
            } else {
                echo 'There was some error moving the file to the upload directory. Please make sure the upload directory is writable by the web server.';
            }
        } else {
            // Handle case where no image is uploaded
            $message = 'There is some error in the file upload. Please check the following error.<br>';
            $message .= 'Error:' . $_FILES['fileUpload']['error'];

            echo $message;
            echo '<br><a href="../' . $redirect . '">Try Again</a>';
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("No picture uploaded!");';
        echo 'window.location = "../' . $redirect . '";';
        echo '</script>';
    }
}

// Close the connection
mysqli_close($conn);
