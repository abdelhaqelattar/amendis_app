<?php
require 'connection.php';
require 'session.php';
require 'controller.php';
include '../templet/sidebar_admin.php';
include '../templet/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_client'])) {
    if (addClient($conn, $_POST)) {
        header("Location: clients.php");
        exit();
    } else {
        echo "<p style='color: red;'>Erreur lors de l'ajout du client.</p>";
    }
}

?>


    <div class="d-flex between-flex ">
        <h1 class="p-relative">Clients</h1>
        <div class=" m-20">
            <a class='bg-orange c-white btn-shape m-20' id="openFormBtn"  >Add Client</a>
        </div>
    </div>
    <div id="overlay" class="overlay"></div>
    <div id="popupForm" class="modal">

            <form action='clients.php' method='post'>
                <label for='first_name'>First Name:</label>
                <input type='text' name='first_name' required>
                <label for='last_name'>Last Name:</label>
                <input type='text' name='last_name' required>
                <label for='email'>Email:</label>
                <input type='text' name='email' required>
                <label for='password'>Password:</label>
                <input type='password' name='password' required>
                <label for='address'>Address:</label>
                <input type='text' name='address' required>
                <label for='phone'>Phone:</label>
                <input type='text' name='phone' required>

                <div class="buttons">
                    <input class="" type='submit' name='add_client' value='Add Client'>
                    <a class='bg-red c-white btn-shape' href='clients.php'>Cancel</a>
                </div>
            </form>
    </div>

    <div class="projects p-20 bg-white rad-10 m-20 w-full">
        <div class="login-table">
            <?php
            displayClientsTable($conn)
            ?>
        </div>
    </div>
</div>

</body>

</html>
<script>
    function deleteClient(customer_id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce client?')) {
            fetch('controller.php?delete=' + customer_id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting client: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>



<script>
    document.getElementById('openFormBtn').addEventListener('click', function() {
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('popupForm').style.display = 'block';
});

document.querySelector('#popupForm .close').addEventListener('click', function() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('popupForm').style.display = 'none';
});

document.getElementById('overlay').addEventListener('click', function() {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('popupForm').style.display = 'none';
});
    
</script>