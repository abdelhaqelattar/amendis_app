<?php
require 'connection.php';
require 'session.php';
require 'controller.php';
include '../templet/sidebar_admin.php';
?>

<div class="content w-full">
    <!-- Start Head -->
    <div class="head bg-white p-10 between-flex">
        <div class="search p-relative">
            <input class="p-10" type="search" placeholder="Type A Keyword" />
        </div>
        <div class="icons d-flex align-center">
            <span class="notification p-relative">
                <i class="fa-regular fa-bell fa-lg"></i>
            </span>
            <img src="../public/imgs/avatar.png" alt="" />
        </div>
    </div>
    <div class="add-client">
        <div class="container">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Traitement de la modification si le formulaire a été soumis

                if (isset($_POST['customer_id']) && is_numeric($_POST['customer_id'])) {
                    $customer_id = $_POST['customer_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $address = $_POST['address'];
                    $phone = $_POST['phone'];

                    // Effectuer la mise à jour dans la base de données
                    $sqlCustomers = "UPDATE customers SET
                    first_name = '$first_name',
                    last_name = '$last_name',
                    address = '$address',
                    phone = '$phone'
                    WHERE customer_id = $customer_id";
                    $sqlUsers = "UPDATE users SET
                    email = '$email',
                    password = '$password'
                    WHERE user_id = (SELECT user_id FROM customers WHERE customer_id = $customer_id)";

                    if (mysqli_query($conn, $sqlCustomers) && mysqli_query($conn, $sqlUsers)) {
                        header("Location: clients.php");
                    } else {
                        echo "<p style='color: red;'>Erreur lors de la modification : " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    echo "<p style='color: red;'>Invalid request</p>";
                }
            } else {
                // Afficher le formulaire de modification si la requête est GET

                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $customer_id = $_GET['id'];

                    // Récupérer les informations du client à modifier
                    $sql = "SELECT customers.customer_id, customers.first_name, customers.last_name, customers.address, customers.phone, users.email, users.password
                    FROM customers
                    INNER JOIN users ON customers.user_id = users.user_id
                    WHERE customer_id = $customer_id";

                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);

                        // Le formulaire pour la modification des informations
            ?>


                        <form action='update_client.php' method='post'>
                            <input type='hidden' name='customer_id' value='<?php echo $row['customer_id']; ?>'>
                            <label for='first_name'>First Name:</label>
                            <input type='text' name='first_name' value='<?php echo $row['first_name']; ?>'>
                            <label for='last_name'>Last Name:</label>
                            <input type='text' name='last_name' value='<?php echo $row['last_name']; ?>'>
                            <label for="email">Email:</label>
                            <input type="text" name="email" value="<?php echo $row['email']; ?>">
                            <label for='address'>Address:</label>
                            <input type='text' name='address' value='<?php echo $row['address']; ?>'>
                            <label for='phone'>Phone:</label>
                            <input type='text' name='phone' value='<?php echo $row['phone']; ?>'>

                            <div class="buttons">
                                <input type='submit' name='update' value='Update'>
                                <button class='bg-red c-white btn-shape' type='button' onclick='closeWindow();'>Close</button>
                            </div>
                        </form>




            <?php
                    } else {
                        echo "<p style='color: red;'>Client not found</p>";
                    }
                } else {
                    echo "<p style='color: red;'>Invalid request</p>";
                }
            }
            ?>
        </div>
    </div>

    </body>
    <script>
        function closeWindow() {
            if (window.opener) {
                window.opener.location.reload(); // Actualise la page parente si nécessaire
                window.close();
            } else {
                window.history.back(); // Revenir en arrière si la fenêtre parente n'est pas trouvée
            }
        }
    </script>

    </html>