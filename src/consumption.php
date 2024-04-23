<?php
include("connection.php");
include("../templet/sidebar_client.php");
include("../templet/header.php");
include("controller.php");
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $customer_id = $_SESSION['customer_id'];
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['role_id'] != 2) {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

?>


    <div class="d-flex  between-flex">
        <div>
            <h1 class="p-relative">Consumption</h1>

        </div>
        <div class="btnn">
            <button id="showConsumptionForm" class="button">Add New consommation</button>
        </div>
    </div>
    <div class="tickets p-20 bg-white rad-10">

        <!-- Form for entering electricity consumption (initially hidden) -->
        <!-- Form for entering electricity consumption (initially hidden) -->
        <form id="consumptionForm" class="consumption-form" action="add_consumption.php" method="post" enctype="multipart/form-data">
            <label for="consumption">Consommation (kWh):</label>
            <input type="text" id="consumption" name="consumption" required>

            <label for="meter_photo">Élèverser une photo du compteur :</label>
            <input type="file" id="meter_photo" name="meter_photo" accept="image/*" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <!-- Ajoutez le bouton "Cancel" à côté du bouton "Envoyer" -->
            <div class="buttons">
                <input type="submit" value="Envoyer">
                <button type="button" id="cancelConsumptionForm" class="cancel-button">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var showConsumptionFormButton = document.getElementById('showConsumptionForm');
        var cancelConsumptionFormButton = document.getElementById('cancelConsumptionForm');
        var consumptionForm = document.getElementById('consumptionForm');

        showConsumptionFormButton.addEventListener('click', function() {
            consumptionForm.style.display = 'block';
        });

        cancelConsumptionFormButton.addEventListener('click', function() {
            consumptionForm.style.display = 'none';
        });
    });
</script>


</body>

</html>