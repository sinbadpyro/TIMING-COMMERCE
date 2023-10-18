<?php include('./partials-front/menu.php'); ?>

<?php
// Check whether id is passed or not
if (isset($_GET['category_id'])) {
    // Category id is set, get the id
    $category_id = $_GET['category_id'];
    // Get the Category Title Based on Category ID
    $sql = "SELECT titre FROM categories_de_produits WHERE id=$category_id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Get the value from the Database
    $row = mysqli_fetch_assoc($res);
    // Get the Title
    $category_title = $row['titre'];
} else {
    // Category not passed
    // Redirect to Home page
    header('location:' . SITEURL);
}

?>

<section class="container my-5">
    <!-- Product search bar -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Produits de <a href="#" class="text-decoration-none text-reset">"<?php echo $category_title; ?>"</a></h2>
        </div>
    </div>

    <!-- Liste des produits -->
    <h1 class="text-center m-4">Menu des produits</h1>
    <div class="row justify-content-center text-center m-3">
        <?php
        // Display Foods that are Active
        $sql2 = "SELECT * FROM produits WHERE id_categorie=$category_id";

        // Execute the Query
        $res = mysqli_query($conn, $sql2);

        // Check whether the foods are available or not
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $titre = $row['titre'];
                $description = $row['description'];
                $prix = $row['prix'];
                $image_name = $row['nom_de_image'];
        ?>
                <div class="col-lg-3 col-md-5 col-12">
                    <div class="card m-3 p-0">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" alt="Produit" class="img-responsive">
                        <?php
                        }
                        ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $titre; ?></h5>
                            <p class="">€<?php echo $prix; ?></p>
                            <p class="card-text" style="height: 100px; overflow:auto;">
                                <?php echo $description; ?>
                            </p>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-success">Commander</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            // No products available
            echo "<div class='error text-center'>Pas de Produits.</div>";
        }
        ?>
    </div>
</section>

<?php include('./partials-front/footer.php'); ?>