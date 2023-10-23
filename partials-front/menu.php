<?php require_once "./config/constants.php"; ?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- The scripts are for the carousel-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/admin.css" type="text/css">
    <link rel="stylesheet" href="../styles.css">
    <title>ECOMATERIAUX</title>

</head>

<body>

    <!--Menu section starts-->
    <div class="menu">

        <nav class="navbar navbar-expand-md bg-success navbar-dark p-0">
            <div class="container ">
                <a href="#" class=""><img src="./img/logo-vector.jpg" class="img-fluid" alt="" style="height: 100px; width:250px;"></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                    <span class="navbar-toggler-icon">

                    </span>
                </button>

                <div class="collapse navbar-collapse text-center" id="navmenu">

                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item"><a a href="<?php echo SITEURL; ?>" class="nav-link link-style text-light">ACCEUIL</a></li>
                        <li class="nav-item"><a href="<?php echo SITEURL; ?>categories.php" class="nav-link link-style  text-light">CATEGORIES</a></li>
                        <li class="nav-item"><a href="<?php echo SITEURL; ?>produits.php" class="nav-link  link-style text-light">PRODUITS</a></li>



                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!--Menu section ends-->