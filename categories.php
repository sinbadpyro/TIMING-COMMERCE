<?php include('./partials-front/menu.php'); ?>

<!-- CAtegories Section Starts Here -->
<section>
    <div class="container">
        <h1 class="text-center m-4">Explorer les catégories</h1>

        <?php
        //Display all the categories that are active
        //SQL Query 
        $sql = "SELECT * FROM categories_de_produits WHERE active='Yes'";
        //execute the query
        $res = mysqli_query($conn, $sql);
        //count rows
        $count = mysqli_num_rows($res);
        //check whether categories available or not
        if ($count > 0) {
            //categories available
            while ($row = mysqli_fetch_assoc($res)) {
                //Get the values
                $id = $row['id'];
                $titre = $row['titre'];
                $image_name = $row['nom_de_image'];
        ?>
                <a href="<?php echo SITEURL; ?>category-produits.php?category_id=<?php echo $id; ?>" class="text-decoration-none text-reset">
                    <div class="row justify-content-center text-center m-2">
                        <div class="card m-3 p-0 col-lg-3 col-md-5 col-12">

                            <?php
                            if ($image_name == "") {
                                //image not available
                                echo "<div class='error'>Image not Found</div>";
                            } else {
                                //image available
                            ?>
                                <img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" alt="Ecomateriaux" class="category-image img-fluid">
                            <?php
                            }
                            ?>
                            <div class="card-body p-3">
                                <h5 class="card-title"><?php echo $titre ?></h5>
                                <a href="#" class="btn btn-success">Commander</a>
                            </div>
                        </div>
                    </div>
                </a>
        <?php
            }
        } else {
            //categories not available
            echo "<div class = 'error'>Category not found</div>";
        }
        ?>

    </div>
</section>

<?php include('./partials-front/footer.php'); ?>