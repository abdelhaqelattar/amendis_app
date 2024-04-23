<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../public/css/all.min.css" />
    <link rel="stylesheet" href="../public/css/framework.css" />
    <link rel="stylesheet" href="../public/css/master.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
  </head>
  <body>
    <div class="page d-flex">
      <div class=" sidebar bg-white p-20 p-relative">
        <!--je veux faire un logo ici-->  
        <div class="welcome mb-0 mt-10 ">
        <img class="logo mb-0 " src="../public/imgs/logo2.jpeg" alt="" />
      </div>

        
        
        <ul>
          <li>
            <a class="d-flex align-center fs-14 c-black rad-6 p-10" href="dashboard_admin.php">
              <i class="fa-regular fa-chart-bar fa-fw"></i>
              <span>Dashboard</span>
            </a>
          </li>
          
          <li>
            <a class="d-flex align-center fs-14 c-black rad-6 p-10" href="clients.php">
              <i class="fa-regular fa-user fa-fw"></i>
              <span>Clients</span>
            </a>
          </li>
          <li>
            <a class="d-flex align-center fs-14 c-black rad-6 p-10" href="traitClaims.php">
              <i class="fa-solid fa-diagram-project fa-fw"></i>
              <span>claims</span>
            </a>
          </li>
          <li>
            <a class="d-flex align-center fs-14 c-black rad-6 p-10" href="bills.php">
              <i class="fa-regular fa-credit-card fa-fw"></i>
              <span>Bills</span>
            </a>
          </li>
          
          <li>
            <a class="d-flex align-center fs-14 c-black rad-6 p-10" href="files.php">
              <i class="fa-regular fa-file fa-fw"></i>
              <span>Files</span>
            </a>
          </li>
          <li>
            <a class="d-flex align-center fs-14 c-black rad-6 p-10" href="annual_report.php">
              <i class="fa-regular fa-file fa-fw"></i>
              <span>Annual report</span>
            </a>
          </li>
        </ul>
      </div>
      <script>
        window.onload = function() {
      var currentUrl = window.location.href;
      var links = document.querySelectorAll('.sidebar a');
      links.forEach(function(link) {
        if (link.href === currentUrl) {
          link.classList.add('active');
        }
      });
    };

      </script>