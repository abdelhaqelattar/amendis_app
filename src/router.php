<?php

require("connection.php");
require('controller.php');


if (isset($_POST['id']) && is_numeric($_POST['id']) && $_POST['action'] == 'delete') {
    $customer_id = $_POST['id'];
  
    deteteClient($conn, $customer_id);
    header("Location: clients.php");
  }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consumption_id = $_POST['consumption_id'];
    $action = $_POST['action'];

    if ($action == 'pay') {
        $sqlUpdateStatus = "UPDATE consumption SET status = 'paid' WHERE consumption_id = $consumption_id";
    } elseif ($action == 'download') {
        header("Location: download_invoice.php?consumption_id=$consumption_id");
        exit();
    }

    if (mysqli_query($conn, $sqlUpdateStatus)) {
        header("Location: dashboard_clients.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du statut : " . mysqli_error($conn);
    }
} else {
    header("Location: dashboard_clients.php");
    exit();
}





?>
