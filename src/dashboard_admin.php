<?php
require 'connection.php';
require 'session.php';
require 'controller.php';
include '../templet/sidebar_admin.php';
include '../templet/header.php';


$sql = "SELECT count(*) as total_client FROM users WHERE role_id = 2";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_client = $row['total_client'];

$sql = "SELECT SUM(monthly_consumption) as total_monthly_consumption FROM consumption";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_monthly_consumption = $row['total_monthly_consumption'];

$sql = "SELECT SUM(amount_ttc) as total_amount_ttc_paid FROM consumption WHERE status = 'paid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_amount_ttc_paid = $row['total_amount_ttc_paid'];

$sql = "SELECT SUM(amount_ttc) as total_amount_ttc_unpaid FROM consumption WHERE status = 'unpaid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_amount_ttc_unpaid = $row['total_amount_ttc_unpaid'];

?>


    <h1 class="p-relative"></h1>
    <div class="wrapper d-grid gap-20">
        <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
            <div class="intro p-20 d-flex space-between bg-eee">
                <div>
                    <h2 class="m-0">Welcome</h2>
                    <p class="c-grey mt-5">Admin</p>
                </div>
                <img class="hide-mobile" src="imgs/welcome.png" alt="" />
            </div>
            <img src="../public/imgs/logo2.jpeg" alt="" class="avatar" />
            <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                <div>Company Name : <span class="d-block c-grey fs-14 mt-10">amendis</span></div>
                <div>services :<span class="d-block c-grey fs-14 mt-10">Electricity distribution</span></div>
                <div>Revenue :<span class="d-block c-grey fs-14 mt-10"><?php echo $total_amount_ttc_paid + $total_amount_ttc_unpaid . ' DH' ?></span></div>
            </div>
            <a href="Clients.php" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">Clients</a>
        </div>
       
        <div class="tickets p-20 bg-white rad-10">
            <h2 class="mt-0 mb-10">customers Statistics</h2>
            <div class="d-flex txt-c gap-20 f-wrap">
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-solid fa-user fa-2x mb-10"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5">
                        <?php
                        echo $total_client;
                        ?>
                    </span>
                    number of Clients
                </div>

                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5">
                        <?php
                        echo $total_monthly_consumption . ' KWH';
                        ?>
                    </span>
                    Total of monthly_consumption
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-circle-check fa-2x mb-10 c-green"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5">
                        <?php
                        echo $total_amount_ttc_paid . ' DH';
                        ?>
                    </span>
                    amount of paid invoices
                </div>
                <div class="box p-20 rad-10 fs-13 c-grey">
                    <i class="fa-regular fa-rectangle-xmark fa-2x mb-10 c-red"></i>
                    <span class="d-block c-black fw-bold fs-25 mb-5">
                        <?php
                        echo $total_amount_ttc_unpaid . ' DH';
                        ?>

                    </span>
                    amount of unpaid invoices
                </div>
            </div>
        </div>
    </div>
</div>