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
    <!-- Liste des produits -->

    <h1 class="text-center m-4">Menu des produits</h1>
    <div class="row justify-content-center text-center m-3">
        <?php
        // Display Foods that are Active
        $sql = "SELECT * FROM produits WHERE active='Yes'";
        
        // Execute the Query
        $res = mysqli_query($conn, $sql);
        
        // Count Rows
        $count = mysqli_num_rows($res);
        
        // Check whether the foods are available or not
        if ($count > 0) {
            // Foods Available
            while ($row = mysqli_fetch_assoc($res)) {
                // Get the Values
                $id = $row['id'];
                $titre = $row['titre'];
                $description = $row['description'];
                $prix = $row['prix'];
                $image_name = $row['nom_de_image'];
        ?>
        <div class="card m-3 p-0 col-lg-3 col-md-4 col-sm-8 col-12">
            <?php
            // Check whether image available or not
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

            <div class="card-body">
                <h5 class="card-title"><?php echo $titre; ?></h5>
                <p class="card-text">
                    <?php echo $description; ?>
                </p>
                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-success">Commander</a>
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
</section>

<?php include('./partials-front/footer.php'); ?>
