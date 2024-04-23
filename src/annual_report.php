<?php
require 'connection.php';
require 'session.php';
include '../templet/sidebar_admin.php';
include '../templet/header.php';

$sql = "SELECT 
            ac.customer_id, 
            ac.year, 
            ac.total_consumption , 
            SUM(c.monthly_consumption) AS sum_of_monthly_consumption,
            (ac.total_consumption - SUM(c.monthly_consumption)) AS consumption_difference
        FROM 
            annual_consumption ac
        LEFT JOIN 
            consumption c ON ac.customer_id = c.customer_id AND YEAR(c.date) = ac.year
        WHERE YEAR(c.date) = ac.year
        GROUP BY 
            ac.customer_id, ac.year
        HAVING consumption_difference > 50";

$result = mysqli_query($conn, $sql);
?>

<h1 class="p-relative">Annual Report</h1>
<div class="tickets p-20 bg-white rad-10">
<div class="projects p-20 bg-white rad-10 ">

    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<div class='responsive-table'>";
        echo "<table class='fs-15 w-full'>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>Customer ID</td>";
        echo "<td>Year</td>";
        echo "<td>Total Consumption</td>";
        echo "<td>Sum of Monthly Consumption</td>";
        echo "<td>Consumption Difference</td>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['customer_id'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['total_consumption'] . "</td>";
            echo "<td>" . $row['sum_of_monthly_consumption'] . "</td>";
            echo "<td>" . $row['consumption_difference'] . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "No data available.";
    }
    ?>
</div>
</div>
