<?php include('./partials-front/menu.php'); ?>

<!-- Categories Section Starts Here -->
<section>
    
            <!--- This is the back button--->
            <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
    <div class="container">
       
        <h1 class="text-center m-4">Explorer les catégories</h1>
        <div class="row text-center m-3">

            <?php
            // Display all the categories that are active
            // SQL Query 
            $sql = "SELECT * FROM categories_de_produits WHERE active='Yes'";
            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether categories are available or not
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the values
                    $id = $row['id'];
                    $titre = $row['titre'];
                    $image_name = $row['nom_de_image'];
            ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="<?php echo SITEURL; ?>category-produits.php?category_id=<?php echo $id; ?>" class="text-decoration-none text-reset">
                            <div class="card m-3 p-0">
                                <?php
                                if ($image_name == "") {
                                    // Image not available
                                    echo "<div class='error'>Image not Found</div>";
                                } else {
                                    // Image available
                                ?>
                                    <img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" alt="Ecomateriaux" class="category-image img-fluid">
                                <?php
                                }
                                ?>
                                <div class="card-body p-3">
                                    <h5 class="card-title"><?php echo $titre ?></h5>

                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            } else {
                // Categories not available
                echo "<div class='error'>Catégorie non trouvée</div>";
            }
            ?>

        </div>
    </div>
</section>

<?php include('./partials-front/footer.php'); ?>