<?php
include("connection.php");
include("../templet/sidebar_client.php");
include("../templet/header.php");
require 'controller.php';

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
?>

  <h1 class="p-relative">Dashboard</h1>
  <div class="tickets p-20 bg-white rad-10">

    <div class="projects p-20 bg-white rad-10 ">

      <?php
      $customer_id = $_SESSION['customer_id'];
      displayCustomerInvoices($conn, $customer_id);
      ?>

    </div>



  </div>