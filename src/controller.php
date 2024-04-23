<?php
require 'connection.php';

function displayCustomerInvoices($conn, $customer_id)
{
    $sql = "SELECT c.*, cu.first_name, cu.last_name
            FROM consumption c
            JOIN customers cu ON c.customer_id = cu.customer_id
            WHERE c.customer_id = $customer_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='responsive-table'>";
        echo "<table class='fs-15 w-full'>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>id</td>";
        echo "<td>name</td>";
        echo "<td>monthly_consumption</td>";
        echo "<td>date</td>";
        echo "<td>amount_ht</td>";
        echo "<td>amount_ttc</td>";
        echo "<td>photo</td>";
        echo "<td>payment</td>";
        echo "<td>consumption_counter</td>";
        echo "<td>status</td>";
        echo "<td>Actions</td>"; // Ajout de la colonne pour les actions
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['consumption_id'] . "</td>";
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
            echo "<td>" . $row['monthly_consumption'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['amount_ht'] . "</td>";
            echo "<td>" . $row['amount_ttc'] . "</td>";
            echo "<td><a href='" . $row['photo_url'] . "' target='_blank'><img src='" . $row['photo_url'] . "' alt='Image' style='width: 50px; height: 50px'></a></td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['consumption_counter'] . "</td>";
            echo "<td>" . $row['IsValid'] . "</td>";

            // Formulaire pour gérer les actions (payer ou télécharger)
            echo "<td>";
            if ($row['IsValid'] == 'Valide') {
                echo "<form action='router.php' method='post'>";
                echo "<input type='hidden' name='consumption_id' value='" . $row['consumption_id'] . "'>";

                // Bouton Payer si le statut est unpaid
                if ($row['status'] == 'unpaid') {
                    echo "<button type='submit' class='b-none bg-red c-white btn-shape' style='width: 70px;' name='action' value='pay'>Payer</button>";
                } elseif ($row['status'] == 'paid') {
                    // Bouton Télécharger si le statut est paid
                    echo "<button type='submit' class='b-none bg-blue c-white btn-shape' style='width: 70px;' name='action' value='download'>download</button>";
                }

                echo "</form>";
            }
            else {
                echo "Cannot Pay or Download";
            }

            echo "</td>";

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "No invoices for this customer.";
    }
}


function displayReclamations($user_id, $conn)
{
  $sql = "SELECT reclamations.*, customers.*
          FROM reclamations
          INNER JOIN customers ON reclamations.customer_id = customers.customer_id
          WHERE customers.user_id = '$user_id'";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Affichez les réclamations dans un tableau, par exemple
    echo "<table class='fs-15 w-full'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>ID Réclamation</td>";
    echo "<td>Type</td>";
    echo "<td>Description</td>";
    echo "<td>Date</td>";
    echo "<td>status</td>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['reclamation_id'] . "</td>";
      echo "<td>" . $row['type'] . "</td>";
      echo "<td>" . $row['description'] . "</td>";
      echo "<td>" . $row['date'] . "</td>";
      echo "<td>" . $row['status'] . "</td>";
      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
  } else {
    echo "Aucune réclamation disponible.";
  }
}


function displayClientsTable($conn)
{
  $sql = "SELECT customers.customer_id, customers.first_name, customers.last_name, customers.address, customers.phone, users.email, users.password
                FROM customers
                INNER JOIN users ON customers.user_id = users.user_id";
  // je veux faire search
  if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR address LIKE '%$search%' OR phone LIKE '%$search%'";
  }
    
 

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    echo "<div class='responsive-table'>";
    echo "<table class='fs-15 w-full'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>customer_id</td>";
    echo "<td>first_name</td>";
    echo "<td>last_name</td>";
    echo "<td>email</td>"; 
    echo "<td>address</td>";
    echo "<td>phone</td>";
    echo "<td>Action</td>"; 
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $row['customer_id'] . "</td>";
      echo "<td>" . $row['first_name'] . "</td>";
      echo "<td>" . $row['last_name'] . "</td>";
      echo "<td>" . $row['email'] . "</td>";
      echo "<td>" . $row['address'] . "</td>";
      echo "<td>" . $row['phone'] . "</td>";
      echo "<td class='d-flex align-center'>
      <a class=' mr-2 bg-blue c-white btn-shape' href='update_client.php?id=" . $row['customer_id'] . "' style='width: 70px;'>Edit</a>
      <form class='ml-5' method='post' action='router.php' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer ce client?\");'>
          <input type='hidden' name='id' value='" . $row['customer_id'] . "'>
          <input type='hidden' name='action' value='delete'>
          <button type='submit' class='b-none bg-red c-white btn-shape' style='width: 70px; cursor:pointer'>Delete</button>
      </form>
  </td>";



      echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
  } else {
    echo "0 results";
  }
}
function deteteClient($conn, $customer_id)
{
  // Perform deletion logic here
  $sqlUsers = "DELETE FROM users WHERE user_id = (SELECT user_id FROM customers WHERE customer_id = $customer_id)";

  if (mysqli_query($conn, $sqlUsers) && mysqli_query($conn, $sqlUsers)) {
    echo "Client deleted successfully";
  } else {
    echo "Error deleting client: " . mysqli_error($conn);
  }
  
}


function processReclamation($conn, $user_id)
{
    if (isset($_SESSION['user_id'])) {
        $customer_id = $_SESSION['customer_id'];

        
        $reclamation_type = $_POST['reclamation_type'];
        $reclamation_description = $_POST['reclamation_description'];

        if ($reclamation_type === 'Autre') {
            $reclamation_type = $_POST['other_reclamation_type'];
        }

        $insert_query = "INSERT INTO reclamations (customer_id, type, description, date) VALUES ('$customer_id', '$reclamation_type', '$reclamation_description', NOW())";

        if (mysqli_query($conn, $insert_query)) {
            
            header("Location: claims.php"); 
            exit();
        } else {
            echo "Erreur d'insertion : " . mysqli_error($conn);
        }
    } else {
        echo "Utilisateur non connecté.";
    }
}

function addClient($conn, $postData) {
  $first_name = mysqli_real_escape_string($conn, $postData['first_name']);
  $last_name = mysqli_real_escape_string($conn, $postData['last_name']);
  $email = mysqli_real_escape_string($conn, $postData['email']);
  $password = mysqli_real_escape_string($conn, $postData['password']);
  $address = mysqli_real_escape_string($conn, $postData['address']);
  $phone = mysqli_real_escape_string($conn, $postData['phone']);

  // Insérer les données de l'utilisateur dans la table 'users'
  $sqlUser = "INSERT INTO users (email, password, role_id) VALUES ('$email', '$password', 2)";
  mysqli_query($conn, $sqlUser);

  $user_id = mysqli_insert_id($conn);

  $sqlCustomer = "INSERT INTO customers (user_id, first_name, last_name, address, phone) VALUES ('$user_id', '$first_name', '$last_name', '$address', '$phone')";

  if (mysqli_query($conn, $sqlCustomer)) {
      return true; 
  } else {
      return false; 
  }
}



function traitReclamationsofClientsTable($conn) {
    $sql = "SELECT reclamations.reclamation_id, customers.customer_id, customers.first_name, customers.last_name, reclamations.type, reclamations.description, reclamations.date, reclamations.status
            FROM reclamations
            INNER JOIN customers ON reclamations.customer_id = customers.customer_id";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='responsive-table'>";
        echo "<table class='fs-15 w-full'>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Customer Name</td>";
        echo "<td>Reclamation Type</td>";
        echo "<td>Description</td>";
        echo "<td>Status</td>";
        echo "<td>Action</td>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $row['first_name'] . ' ' . $row['last_name'] . "</td>";
          echo "<td>" . $row['type'] . "</td>";
          echo "<td>" . $row['description'] . "</td>";
          echo "<td id='status_" . $row['reclamation_id'] . "'>" . $row['status'] . "</td>";
          echo "<td><button class='b-none buttons bg-blue c-white btn-shape' onclick='updateStatus(" . $row['reclamation_id'] . ")'>traiter</button></td>";
          echo "</tr>";
      }
      
        echo "</tbody></table>";
        echo "</div>";
    } else {
        echo 'No reclamations found.';
    }
}



function displayAdminInvoices($conn, $searchQuery = null)
{
    $sql = "SELECT c.*, cu.first_name, cu.last_name
            FROM consumption c
            JOIN customers cu ON c.customer_id = cu.customer_id";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='responsive-table'>";
        echo "<table class='fs-15 w-full'>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>id</td>";
        echo "<td>customer name</td>";
        echo "<td>m_consumption</td>";
        echo "<td>date</td>";
        echo "<td>ht</td>";
        echo "<td>ttc</td>";
        echo "<td>photos_counter</td>";
        echo "<td>payment</td>";
        echo "<td>consumption</td>";
        echo "<td>status</td>";
        echo "<td>Action</td>"; // Added column for action buttons
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['consumption_id'] . "</td>";
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
            echo "<td>" . $row['monthly_consumption'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['amount_ht'] . "</td>";
            echo "<td>" . $row['amount_ttc'] . "</td>";
            echo "<td><a href='" . $row['photo_url'] . "' target='_blank'><img src='" . $row['photo_url'] . "' alt='Image' style='width: 50px; height: 50px'></a></td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['consumption_counter'] . "</td>";
            echo "<td>" . $row['IsValid'] . "</td>";
            echo "<td>";
            echo "<form method='post' action='bills.php'>";
            echo "<input type='hidden' name='consumption_id' value='" . $row['consumption_id'] . "'>";
        
            echo "<button type='submit' class='b-none button bg-blue c-white btn-shape' name='action' value='update'>Edit</button>";
        
            if ($row['IsValid'] === 'Invalid') {
                echo "<button type='submit' class='b-none button bg-blue c-white btn-shape' name='action' name='action' value='validate'>Validate</button>";
            }
        
            echo "</form>";
            echo "</td>";

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "No invoices available.";
    }
}


function updateConsumption($conn, $consumptionId)
{
    if (isset($_POST['updateSubmit'])) {
        $newconsumption_counter = $_POST['consumption_counter'];

        $sqlNewConsumption = "SELECT date FROM consumption WHERE consumption_id = $consumptionId";
        $resultNewConsumption = mysqli_query($conn, $sqlNewConsumption);

        if ($resultNewConsumption && $rowNewConsumption = mysqli_fetch_assoc($resultNewConsumption)) {
            $newConsumptionDate = $rowNewConsumption['date'];

            $sqlLastConsumption = "SELECT consumption_counter, date 
                                   FROM consumption 
                                   WHERE customer_id = (SELECT customer_id FROM consumption WHERE consumption_id = $consumptionId) 
                                   AND date < '$newConsumptionDate' 
                                   ORDER BY date DESC 
                                   LIMIT 1";

            $resultLastConsumption = mysqli_query($conn, $sqlLastConsumption);

            if ($resultLastConsumption && $rowLastConsumption = mysqli_fetch_assoc($resultLastConsumption)) {
                $lastConsumptionCounter = $rowLastConsumption['consumption_counter'];
                $lastConsumptionDate = $rowLastConsumption['date'];

                $consumptionDifference = $newconsumption_counter - $lastConsumptionCounter;
            } else {
                $consumptionDifference = $newconsumption_counter;
            }

            $sqlUpdate = "UPDATE consumption SET 
                          consumption_counter = '$newconsumption_counter',
                          monthly_consumption = '$consumptionDifference'
                          WHERE consumption_id = $consumptionId";

            $result = mysqli_query($conn, $sqlUpdate);

            if ($result) {
                $sqlRate = "SELECT price_per_kwh FROM rates WHERE consumption_from <= $consumptionDifference AND consumption_to >= $consumptionDifference";
                $resultRate = mysqli_query($conn, $sqlRate);

                if ($resultRate && $rowRate = mysqli_fetch_assoc($resultRate)) {
                    $price_per_kwh = $rowRate['price_per_kwh'];
                    $amount_ht = $consumptionDifference * $price_per_kwh;
                    $amount_ttc = $amount_ht * 1.14;

                    $sqlUpdateAmounts = "UPDATE consumption SET 
                                        amount_ht = '$amount_ht',
                                        amount_ttc = '$amount_ttc'
                                        WHERE consumption_id = $consumptionId";

                    $resultUpdateAmounts = mysqli_query($conn, $sqlUpdateAmounts);

                    if (!$resultUpdateAmounts) {
                        echo "Error updating amounts: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error fetching rates: " . mysqli_error($conn);
                }
            } else {
                echo "Error updating consumption: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching new consumption record: " . mysqli_error($conn);
        }
    }

    $sqlFetch = "SELECT * FROM consumption WHERE consumption_id = $consumptionId";
    $resultFetch = mysqli_query($conn, $sqlFetch);

    if ($resultFetch && $row = mysqli_fetch_assoc($resultFetch)) {
        echo "<div class='containers'>";
        echo "<form method='post' action='bills.php'>";
        echo "<input type='hidden' name='consumption_id' value='" . $row['consumption_id'] . "'>";
        echo "<label for='consumption_counter'>Consumption Counter</label><br>";
        echo "<input type='text' name='consumption_counter' value='" . $row['consumption_counter'] . "'><br>";
        echo "<input type='hidden' name='updateSubmit' value='1'>";
        echo "<button style='display: block; cursor: pointer; margin: 0 auto; text-align: center;' type='submit' class='bg-blue c-white btn-shape' name='action' value='update'>Update</button>";
        echo "<a style='display: block; margin: 0 auto; text-align: center;' class='bg-red c-white btn-shape' href='bills.php'>Cancel</a>";

        echo "</form>";
        echo "</div>";
    } else {
        echo "Error fetching consumption details: " . mysqli_error($conn);
    }
}


function validateConsumption($conn, $consumptionId)
{
  
  $sqlValidate = "UPDATE consumption SET IsValid = 'Valide' WHERE consumption_id = $consumptionId";
  $result = mysqli_query($conn, $sqlValidate);

  if ($result) {
  } else {
      echo "Error validating consumption: " . mysqli_error($conn);
  }
}




?>
