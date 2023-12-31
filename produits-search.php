<?php include('./partials-front/menu.php'); ?>

<!--- This is the back button--->
<a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php
            //Get the search Keyword
           
            $search = mysqli_real_escape_string($conn, $_POST['search']);//To secure the code more
            ?>
            <h2>Produits issus de votre recherche de <a href="#" class="text-primary"><?php echo $search; ?></a></h2>
        </div>
    </div>

    <!-- Liste des produits -->
    <h1 class="text-center m-4">Menu des produits</h1>
    <div class="row justify-content-center text-center m-3">
    <?php
    $search = $_POST['search'];
    //Display Products that the user searched for
    $sql = "SELECT * FROM produits  WHERE titre LIKE '%$search%' OR description LIKE '%$search%'";

    //Execute the Query
    $res = mysqli_query($conn, $sql);

    //Count Rows
    $count = mysqli_num_rows($res);
    //CHeck whether the products are availalable or not
    if ($count > 0) {
        //Products Available
        while ($row = mysqli_fetch_assoc($res)) {
            //Get the Values
            $id = $row['id'];
            $titre = $row['titre'];
            $description = $row['description'];
            $prix = $row['prix'];
            $image_name = $row['nom_de_image'];
    ?>   
                <div class="col-lg-4 col-md-5 col-12">
                    <div class="card m-3 p-0 ">
                    <?php
                    //CHeck whether image available or not
                    if ($image_name == "") {
                        //Image not Available
                        echo "<div class='error'>Image non disponible.</div>";
                    } else {
                        //Image Available
                    ?>
                        <img src="<?php echo SITEURL; ?>img/product/<?php echo $image_name; ?>" alt="Produit" class="img-responsive">
                    <?php
                    }
                    ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $titre; ?></h5>
                        <p class="card-text" style="height: 100px; overflow:auto;">
                            <?php echo $description; ?>
                        </p>
                        <a href="#" class="btn btn-success">Commander</a>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        //Product not Available
        echo "<div class='error text-center'>Pas de Produits.</div>";
    }
    ?>
    </div>
</section>

<?php include('./partials-front/footer.php'); ?>