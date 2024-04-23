<?php
include("connection.php");
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $customer_id = $_SESSION['customer_id'];
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['role_id'] != 2) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $customer_id = $_SESSION['customer_id'];
    $consumption = $_POST['consumption'];
    $date = $_POST['date'];

    $sqlLastConsumption = "SELECT MAX(date) as last_date
    FROM consumption 
    WHERE customer_id = '$customer_id' AND IsValid = 'Valide'";

    $resultLastConsumption = mysqli_query($conn, $sqlLastConsumption);

    if ($resultLastConsumption && $rowLastConsumption = mysqli_fetch_assoc($resultLastConsumption)) {
        $lastDate = $rowLastConsumption['last_date'];

        if ($lastDate == null) {
            $currentDate = date('Y-m-d');
            if ($date > $currentDate) {
                echo "La date ne peut pas être dans le futur.";
                exit();
            }
        }else {
            $nextMonth = date('Y-m-d', strtotime($lastDate . ' +1 month'));
        if ($date > $nextMonth) {
            echo "La date doit être dans le mois suivant ou égale au mois suivant de la dernière consommation.";
            exit();
        }
        if ($date < $nextMonth) {
            echo "La date doit être supérieure à la dernière consommation.";
            exit();
        }
        $currentDate = date('Y-m-d');
        if ($date > $currentDate) {
            echo "La date ne peut pas être dans le futur.";
            exit();
        }

            
        }
        
    }

    $sqlLastConsumption = "SELECT monthly_consumption, consumption_counter, date 
    FROM consumption 
    WHERE customer_id = '$customer_id' AND IsValid = 'Valide' 
    ORDER BY date DESC LIMIT 1";
    $resultLastConsumption = mysqli_query($conn, $sqlLastConsumption);

    $lastConsumption = 0;
    $lastConsumptionDate = null;

    if ($resultLastConsumption && $rowLastConsumption = mysqli_fetch_assoc($resultLastConsumption)) {
        $lastConsumption = $rowLastConsumption['monthly_consumption'];
        $lastConsumptionCounter = $rowLastConsumption['consumption_counter'];
        $lastConsumptionDate = $rowLastConsumption['date'];
    }

    $consumptionDifference = $consumption - $lastConsumptionCounter;
    $consumptionDifference = ($consumptionDifference < 0) ? 0 : $consumptionDifference;

    $IsValid = 'Valide';
    $consumptionDifferenceCounter = $consumption - $lastConsumptionCounter;

    if ($consumptionDifferenceCounter < 0 || $consumptionDifferenceCounter > 1000) {
        $IsValid = 'Invalid';
    }


    $target_directory = "uploads/";
    $target_file = $target_directory . basename($_FILES["meter_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["meter_photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
    }

   
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        if (move_uploaded_file($_FILES["meter_photo"]["tmp_name"], $target_file)) {
            $image_url =  $target_file; 

            $sqlRate = "SELECT price_per_kwh FROM rates WHERE consumption_from <= $consumptionDifference AND consumption_to >= $consumptionDifference";
            $resultRate = mysqli_query($conn, $sqlRate);

            if ($resultRate && $rowRate = mysqli_fetch_assoc($resultRate)) {
                $price_per_kwh = $rowRate['price_per_kwh'];
                $amount_ht = $consumptionDifference * $price_per_kwh;
                $amount_ttc = $amount_ht * 1.14;
            } else {
                $amount_ht = 0;
                $amount_ttc = 0;
            }

            $sqlConsumption = "INSERT INTO consumption (customer_id, monthly_consumption, photo_url, date, amount_ht, amount_ttc, status,consumption_counter,IsValid) 
                                VALUES ('$customer_id', '$consumptionDifference', '$image_url', '$date', '$amount_ht', '$amount_ttc', 'unpaid','$consumption','$IsValid')";

            if (mysqli_query($conn, $sqlConsumption)) {
                header("Location: dashboard_clients.php");
            } else {
                echo "Erreur d'enregistrement de la consommation : " . mysqli_error($conn);
            }
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
} else {
    header("Location: dashboard_clients.php");
    exit();
}

mysqli_close($conn);
