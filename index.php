<?php include('./partials-front/menu.php'); ?>


<section class="container my-5">
    <!-- Product search bar -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="<?php echo SITEURL; ?>produits-search.php" method="POST" class="form-inline">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Recherche de produits...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>
    <!-- Categories des produits -->
    <div class="container">
        <h1 class="text-center m-4">Explorer les catégories</h1>
        <div class="row justify-content-center text-center m-2">

            <?php
            // Display featured categories (limited to 3) that are active
            // SQL Query 
            $sql = "SELECT * FROM categories_de_produits WHERE active='Yes' AND featured='Yes' LIMIT 3";
            // Execute the query
            $res = mysqli_query($conn, $sql);
            // Check whether featured categories are available or not
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    // Get the values
                    $id = $row['id'];
                    $titre = $row['titre'];
                    $image_name = $row['nom_de_image'];
            ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 text-center">
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
                                    <h5 class="card-title text-center"><?php echo $titre ?></h5>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            } else {
                // No featured categories available
                echo "<div class='error text-center'>No featured categories found</div>";
            }
            ?>
       <a href="<?php echo SITEURL; ?>categories.php" class="btn btn-primary d-block mx-auto mb-2" style="width: 200px;">Voir tous les Categories</a>

        </div>
    </div>

    <!--PARTNERS-->
         <?php
              include('./partials-front/carousel.php')
         ?>   
    <!--END OF PARTNERS-->

</section>

<!-- PRODUCT MENU-->

<div class="Products p-3 text-bg-secondary">
    <h2 class="text-center m-4">Menu des produits</h2>
    <div class="row justify-content-center m-2">

        <?php
        // Display featured food products (limited to 6) that are active
        $sql = "SELECT * FROM produits WHERE active='Yes' AND featured='Yes' LIMIT 6";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the food products are available or not
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                // Get the Values
                $id = $row['id'];
                $titre = $row['titre'];
                $description = $row['description'];
                $prix = $row['prix'];
                $image_name = $row['nom_de_image'];
        ?>
                <div class="col-lg-3 col-md-6 col-sm-12" style="width:25em;" >
                    <div class="card m-3 p-0"  >
                    
                        <?php
                        // Check whether the image is available or not
                        if ($image_name == "") {
                            // Image not Available
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            // Image Available
                        ?>
                            <img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" alt="Produit" class="img-responsive">
                        <?php
                        }
                        ?>
                           
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $titre; ?></h5>
                            <div style="height: 100px; overflow:auto;">
                            <p class="card-text">
                              
                                <?php echo $description; ?>
                            </p>
                            </div>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-success">Commander</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            // Food not Available
            echo "<div class='error text-center'>Pas de Produits.</div>";
        }
        ?>

    </div>
    <a href="<?php echo SITEURL; ?>produits.php" class="btn btn-primary d-block mx-auto" style="width: 200px;">Voir tous les produits</a>
</div>



<?php include('./partials-front/footer.php'); ?>