<?php
require 'connection.php';
require 'session.php';
require 'controller.php';
include '../templet/sidebar_admin.php';
include '../templet/header.php';



$searchQuery = isset($_POST['search']) ? $_POST['search'] : null;

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if (isset($_POST['consumption_id'])) {
        $consumptionId = $_POST['consumption_id'];

        switch ($action) {
            case 'update':
                updateConsumption($conn, $consumptionId);
                break;
            case 'validate':
                validateConsumption($conn, $consumptionId);
                break;
            default:
                echo "Invalid action.";
        }
    } else {
        echo "Consumption ID not provided.";
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $searchQuery = $_POST['search'];
    }
}

?>
    <h1 class="p-relative">Bills</h1>
    <div class="tickets p-20 bg-white rad-10">
        <div class="projects p-20 bg-white rad-10 ">
            <?php
            displayAdminInvoices($conn, $searchQuery);
            ?>
        </div>
    </div>
</div>
