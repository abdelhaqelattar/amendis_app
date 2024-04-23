<?php
require 'connection.php';
require 'session.php';
require 'controller.php';
include '../templet/sidebar_admin.php';
include '../templet/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['uploadSubmit'])) {
    $targetDir = "uploads/"; 
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($imageFileType != "txt") {
        $_SESSION['upload_message'] = "Sorry, only TXT files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {

            $lines = file($targetFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                $data = explode(',', $line);

                $customerId = $data[0];
                $year = $data[1];
                $totalConsumptionFromFile = $data[2];
                $entryDate = $data[3];

                $sqlFetchConsumption = "SELECT SUM(monthly_consumption) AS total_consumption_mounthly FROM consumption WHERE customer_id = '$customerId' AND YEAR(date) = '$year'";
                $resultFetchConsumption = mysqli_query($conn, $sqlFetchConsumption);

                if ($resultFetchConsumption) {
                    $row = mysqli_fetch_assoc($resultFetchConsumption);
                    $totalConsumptionFromDB = $row['total_consumption_mounthly'];

                    $difference = abs($totalConsumptionFromDB - $totalConsumptionFromFile);

                    $sqlInsert = "INSERT INTO annual_consumption (customer_id, year, total_consumption, Entry_Date) 
                                  VALUES ('$customerId', '$year', '$totalConsumptionFromFile', '$entryDate')";
                    $resultInsert = mysqli_query($conn, $sqlInsert);

                    if (!$resultInsert) {
                        $_SESSION['upload_message'] = "Error inserting data: " . mysqli_error($conn);
                    }
                } else {
                    $_SESSION['upload_message'] = "Error fetching customer consumption: " . mysqli_error($conn);
                }
            }

            header("Location: annual_report.php");
            exit();
        } else {
            $_SESSION['upload_message'] = "Sorry, there was an error uploading your file.";
        }
    }
}
?>



<h1 class="p-relative">anuell consumption</h1>
<div class="tickets p-20 bg-white rad-10">
 
    <form class="" action="" method="post" enctype="multipart/form-data">
        <div class="p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">Upload File</h2>
            <div class="mb-15">
                <label class="fs-14 c-grey d-block mb-10" for="fileToUpload">Upload File:</label>
                <input class="b-none border-ccc p-10 rad-6 d-block w-full" type="file" name="fileToUpload" accept=".txt" />
            </div>
            <div class="d-flex">
                <button style='cursor: pointer;' class=" p-10 button b-none bg-blue " type="submit" name="uploadSubmit">
                    Upload File
                </button>
            </div>
    </form>

    <?php
    if (isset($_SESSION['upload_message'])) {
        echo "<p>{$_SESSION['upload_message']}</p>";
        unset($_SESSION['upload_message']); 
    }
    ?>
</div>
</div>