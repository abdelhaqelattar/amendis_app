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
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    processReclamation($conn, $user_id);
}

?>



    <div class="d-flex  between-flex">
        <div>
            <h1 class="p-relative">Claims</h1>

        </div>
        <div class="btnn m-20">
            <button id="showReclamationForm" class="button">Add Reclamation</button>
        </div>
    </div>
    <div class="tickets p-20 bg-white rad-10">


        <div id="overlay" class="overlay"></div>

        <div id="reclamationFormContainer" class="reclamation-form-container">
            <form id="reclamationForm" class="consumption-form" action="" method="post">

                <label for="reclamation_type">Type de réclamation:</label>
                <select id="reclamation_type" name="reclamation_type" required onchange="checkOtherOption(this);">
                    <option value="Fuite externe">Fuite externe</option>
                    <option value="Fuite interne">Fuite interne</option>
                    <option value="Facture">Facture</option>
                    <option value="Autre">Autre (à spécifier)</option>
                </select>

                <div id="otherTypeContainer" style="display:none;">
                    <label for="other_reclamation_type">Autre Type de Réclamation:</label>
                    <input type="text" id="other_reclamation_type" name="other_reclamation_type">
                </div>

                <label for="reclamation_description">Description:</label>
                <textarea id="reclamation_description" name="reclamation_description" required></textarea>

                <div class="buttons">
                    <input type="submit" value="Envoyer">
                    <a class='bg-red c-white btn-shape' href="claims.php">close</a>
                </div>
            </form>
        </div>

        <div class="projects p-20 bg-white rad-10">
            <?php
            displayReclamations($user_id, $conn)
            ?>
        </div>

    </div>
</div>
<script>
    document.getElementById('showReclamationForm').addEventListener('click', function() {
        document.getElementById('reclamationForm').style.display = 'block';
    });
    document.getElementById('showReclamationForm').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('reclamationFormContainer').style.display = 'block';
    });

    document.getElementById('overlay').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('reclamationFormContainer').style.display = 'none';
    });


    function checkOtherOption(selectElement) {
        var otherTypeContainer = document.getElementById('otherTypeContainer');
        var otherReclamationTypeInput = document.getElementById('other_reclamation_type');

        if (selectElement.value === 'Autre') {
            otherTypeContainer.style.display = 'block';
            otherReclamationTypeInput.setAttribute('required', 'required');
        } else {
            otherTypeContainer.style.display = 'none';
            otherReclamationTypeInput.removeAttribute('required');
        }
    }
</script>

</body>

</html>