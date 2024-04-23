<?php
require 'connection.php';
require 'session.php';
include '../templet/sidebar_admin.php';
include '../templet/header.php';
require 'controller.php';

?>


    <h1 class="p-relative">Claims</h1>

    <div class="projects p-20 bg-white rad-10 m-20 w-full">
        <?php

        if (isset($_GET['update_status'])) {
            $reclamationId = $_GET['update_status'];

            $sqlUpdateStatus = "UPDATE reclamations SET status = 'traiter' WHERE reclamation_id = $reclamationId";
            mysqli_query($conn, $sqlUpdateStatus);

            if (mysqli_affected_rows($conn) > 0) {
                echo "<div class='alert success'>Status updated successfully.</div>";
            } else {
                echo "<div class='alert error'>Error updating status.</div>";
            }
        }

        traitReclamationsofClientsTable($conn);
        ?>
    </div>
</div>

<script>
   function updateStatus(reclamationId) {
    if (confirm('Are you sure you want to update the status of this reclamation?')) {
        // Using a simple XMLHttpRequest for updating status
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Reload the page after successful status update
                    location.reload();
                } else {
                    alert('Error updating status. Please try again.');
                }
            }
        };

        // Open a GET request to your PHP script for updating status
        xhr.open('GET', 'traitClaims.php?update_status=' + reclamationId, true);
        xhr.send();
    }
}

</script>

</body>
</html>
