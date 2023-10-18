<?php
ob_start();
include('../admin/partials/menu.php'); ?>

<div class="content">
    <div class="wrapper">

        <br>
        <h1 class="text-center">Ajouter des Produits</h1>
        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br>

        <!--Add Category Form starts-->
        <form class="form-container mb-3" action="" method="POST" enctype="multipart/form-data">


            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="titre">
                <div class="form-text">Veuillez entrer le nom de du Produits</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea cols="30" rows="5" class="form-control" name="description"
                    placeholder="Description du Produits"></textarea>
            </div>


            <div class="mb-3">
                <label class="form-label">Prix du Produits</label>
                <input type="number" class="form-control" name="prix">
                <div class="form-text">Entrer un Prix</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Sélectionnez une image</label>
                <input type="file" class="form-control" name="image">
                <div class="form-text">Veuillez sélectionner une image</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="categories_de_produits">
                    <?php
                    //Create PHP Code to display categories from Database
                    //1. CReate SQL to get all active categories from database
                    $sql = "SELECT * FROM categories_de_produits WHERE active='Yes'";

                    //Executing qUery
                    $res = mysqli_query($conn, $sql);

                    //Count Rows to check whether we have categories or not
                    $count = mysqli_num_rows($res);

                    //IF count is greater than zero, we have categories else we donot have categories
                    if ($count > 0) {
                        //WE have categories
                        while ($row = mysqli_fetch_assoc($res)) {
                            //get the details of categories
                            $id = $row['id'];
                            $titre = $row['titre'];

                            ?>

                            <option value="<?php echo $id; ?>">
                                <?php echo $titre; ?>
                            </option>

                            <?php
                        }
                    } else {
                        //WE do not have category
                        ?>
                        <option value="0">No Category Found</option>
                        <?php
                    }


                    //2. Display on Drpopdown
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Featured</label>
                <input type="radio" name="featured" value="Yes">Yes
                <input type="radio" name="featured" value="No">No
            </div>
            <div class="mb-3">
                <label class="form-label">Active</label>
                <input type="radio" name="active" value="Yes">Yes
                <input type="radio" name="active" value="No">No
            </div>


            <input class="btn btn-success" type="submit" value="Ajout Produits" name="submit">
        </form>
        <!--End of Product Form-->

        <?php

        //CHeck whether the button is clicked or not
        if (isset($_POST['submit'])) {
            // Add the Product in the Database
            // ...
        
            // Get the Data from the Form
            $titre = $_POST['titre'];
            $description = addslashes($_POST['description']); // Handle special characters
            $prix = $_POST['prix'];
            $category = $_POST['categories_de_produits'];
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No"; // Setting the Default Value
            }

            $active = (isset($_POST['active'])) ? $_POST['active'] : "No";

            // Upload the Image if selected
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];
                if ($image_name != "") {
                    // Image is Selected
                    $image_parts = explode('.', $image_name);
                    $ext = end($image_parts);
                    $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;
                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../img/food/" . $image_name;

                    $upload = move_uploaded_file($src, $dst);

                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/add-product.php');
                        die();
                    }
                }
            } else {
                $image_name = ""; // Set Default Value as blank
            }

            // Use prepared statements to insert data into the database
            $sql = "INSERT INTO produits (titre, description, prix, id_categorie, nom_de_image, featured, active)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'ssdisss', $titre, $description, $prix, $category, $image_name, $featured, $active);

            if (mysqli_stmt_execute($stmt)) {
                // Data inserted successfully
                $_SESSION['add'] = "<div class='success'>Product Added Successfully.</div>";
                header('location: ' . SITEURL . 'admin/manage-products.php');
            } else {
                // Failed to insert data
                $_SESSION['add'] = "<div class='error'>Failed to Add Product: " . mysqli_error($conn) . "</div>";
                header('location: ' . SITEURL . 'admin/manage-products.php');
                die(); // Stop further processing
            }
        }

        ?>

    </div>
</div>

<?php include('./partials/footer.php'); ?>