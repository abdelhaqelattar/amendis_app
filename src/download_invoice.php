<?php
require 'connection.php';
require_once 'dompdf/vendor/autoload.php'; 
use Dompdf\Dompdf;
use Dompdf\Options;

$consumption_id = $_GET['consumption_id'];
$sql = "SELECT  consumption.monthly_consumption,consumption.photo_url ,consumption.customer_id,consumption.date,consumption.consumption_counter, consumption.amount_ht, consumption.amount_ttc, customers.first_name, customers.last_name, customers.address, customers.phone, users.email 
        FROM consumption 
        INNER JOIN customers ON consumption.customer_id = customers.customer_id 
        INNER JOIN users ON customers.user_id = users.user_id 
        WHERE consumption_id = $consumption_id";

$result = mysqli_query($conn, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->set_option('isHtml5ParserEnabled', true);

    $html = "
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90vh;
    }

    #invoice-POS {
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding: 10mm;
        margin: 0 auto;
        width: 180mm;
        background: #FFF;
        font-size: 14px;
    }

    #invoice-POS ::selection {
        background: #f31544;
        color: #FFF;
    }

    #invoice-POS ::moz-selection {
        background: #f31544;
        color: #FFF;
    }

    #top {
        text-align: center;
        margin-bottom: 5px;
    }

    .logo img {
        width: 150px;
        height: 100px;
    }

    .info h2 {
        margin: 0;
        color: #333;
    }

    #mid {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    #mid .info {
        width: 40%;
    }

    #mid .invoice-details {
        width: 50%;
    }

    #bot {
        border-top: 1px solid #EEE;
        padding-top: 10px;
    }

    #table table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    #table table td {
        padding: 10px;
        border-bottom: 1px solid #EEE;
    }

    #table .service {
        border-bottom: 2px solid #333;
    }

    

    #mid .invoice-details p {
        margin: 5px 0;
        color: #555;
        font-weight: bold; /* Making variable names bold */
    }

    #mid .invoice-details h2 {
        font-size: 1.5em;
        color: #333;
    }
</style>





    <div id='invoice-POS'>
        <center id='top'>
            <div class='logo'>
                <img src='http://localhost:8082/GFactures/public/imgs/logoam.jpg' alt='Amendis Image' >
            </div>
            <div class='info'> 
            </div><!--End Info-->
        </center><!--End InvoiceTop-->

        <div id='mid'>
            <div class='info'>
                <h2>Facture</h2>
                <p> 
                    Address: " . $row['address'] . "<br>
                    Email: " . $row['email'] . "<br>
                    Phone: " . $row['phone'] . "
                </p>
            </div>
        </div>

        <div id='bot'>
            <div id='table'>
                <table>
                
                    <tr class='service'>
                        <td class='tableitem'><p class='itemtext'> customer number :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['customer_id'] . "</p></td>
                    </tr>
                    <tr class='service'>
                    <td class='tableitem'><p class='itemtext'> invoices N :</p></td>
                    <td class='tableitem'><p> " . $consumption_id . "</p></td>
                </tr>
                    <tr class='service'>
                        <td class='tableitem'><p class='itemtext'> Customer Name :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['first_name'] . " " . $row['last_name'] . "</p></td>
                    </tr>

                    
                <tr class='service'>
                        <td class='tableitem'><p class='itemtext'> Date :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['date'] . "</p></td>
                    </tr>
                    

                    <tr class='service'>
                        <td class='tableitem'><p class='itemtext'> electricity :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['monthly_consumption'] . ' KW' . "</p></td>
                    </tr>

                    <tr class='service'>
                        <td class='tableitem'><p class='itemtext'>Amount HT :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['amount_ht'] . ' DH' . "</p></td>
                    </tr>
                    <tr class='service'>
                        <td class='tableitem'><p class='itemtext'>Amount TTC :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['amount_ttc'] . ' DH' . "</p></td>
                    </tr>
                    <tr class='service'>
                        <td class='tableitem'><p class='itemtext'>Total a paye :</p></td>
                        <td class='tableitem'><p class='itemtext'>" . $row['amount_ttc'] . ' DH' . "</p></td>
                    </tr>
                    
                        <img src='http://localhost:8082/GFactures/src/" . $row['photo_url'] . "' alt='photo' width='100' height='100'>
                    
    
                </table>
            </div>
        </div>
    </div>
    ";

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream('invoice.pdf', array('Attachment' => 0));
} else {
    echo "Error fetching invoice details: " . mysqli_error($conn);
}
