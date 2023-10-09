<?php
  require_once "../config/constants.php";
  include('login-check.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>ECOMATERIAUX</title>
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
</head>

<body>

    <!--Menu section starts-->
    <div class="menu">

        <nav class="navbar navbar-expand-md bg-success navbar-dark p-0">
            <div class="container ">
                <a href="#" class=""><img src="../img/logo-vector.jpg" class="img-fluid" alt="" style="height: 100px; width:250px;"></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span class="navbar-toggler-icon">

                    </span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navmenu">

                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item"><a href="index.php" class="nav-link text-light">ACCEUIL</a></li>
                        <li class="nav-item"><a href="manage-admin.php" class="nav-link text-light">ADMIN</a></li>
                        <li class="nav-item"><a href="manage-category.php" class="nav-link text-light">CATEGORIES</a></li>
                        <li class="nav-item"><a href="manage-products.php" class="nav-link text-light">PRODUITS</a></li>
                        <li class="nav-item"><a href="manage-orders.php" class="nav-link text-light">COMMANDES</a></li>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-light">SE DÉCONNECTER</a></li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!--Menu section ends-->