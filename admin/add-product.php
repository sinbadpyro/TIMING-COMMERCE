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
                <textarea cols="30" rows="5" class="form-control" name="description" placeholder="Description du Produits"></textarea>
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

                            <option value="<?php echo $id; ?>"><?php echo $titre; ?></option>

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
            //Add the Product in Database
            //echo "Clicked";

            //1. Get the DAta from Form
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $category = $_POST['categories_de_produits'];

            //Check whether radion button for featured and active are checked or not
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No"; //SEtting the Default Value
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No"; //Setting Default Value
            }

            //2. Upload the Image if selected
            //Check whether the select image is clicked or not and upload the image only if the image is selected
            if (isset($_FILES['image']['name'])) {
                //Get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //Check Whether the Image is Selected or not and upload image only if selected
                if ($image_name != "") {
                    // Image is SElected
                    //A. REnamge the Image
                    //Get the extension of selected image (jpg, png, gif, etc.) "vijay-thapa.jpg" vijay-thapa jpg
                    $image_parts = explode('.', $image_name);
                    $ext = end($image_parts);

                    // Create New Name for Image
                    $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext; //New Image Name May Be "Food-Name-657.jpg"

                    //B. Upload the Image
                    //Get the Src Path and DEstinaton path

                    // Source path is the current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //Destination Path for the image to be uploaded
                    $dst = "../img/food/" . $image_name;

                    //Finally Uppload the food image
                    $upload = move_uploaded_file($src, $dst);

                    //check whether image uploaded of not
                    if ($upload == false) {
                        //Failed to Upload the image
                        //REdirect to Add Food Page with Error Message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/add-product.php');
                        //STop the process
                        die();
                    }
                }
            } else {
                $image_name = ""; //SEtting DEfault Value as blank
            }

            //3. Insert Into Database

            //Create a SQL Query to Save or Add food
            // For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
            $sql2 = "INSERT INTO produits SET 
            titre = '$titre',
            description = '$description',
            prix = $prix,
            id_categorie = $category,  -- Corrected column name here
            nom_de_image = '$image_name',
            featured = '$featured',
            active = '$active'
        ";


            $res2 = mysqli_query($conn, $sql2);

            if ($res2) {
                // Data inserted successfully
                $_SESSION['add'] = "<div class='success'>Product Added Successfully.</div>";
                header('location: ' . SITEURL . 'admin/manage-products.php');
            } else {
                // Failed to insert data, display the MySQL error message
                $_SESSION['add'] = "<div class='error'>Failed to Add Product. Error: " . mysqli_error($conn) . "</div>";
                header('location: ' . SITEURL . 'admin/add-product.php'); // Redirect back to the add-food page to see the error message
                die(); // Stop further processing
            }
        }

        ?>

    </div>
</div>

<?php include('./partials/footer.php'); ?>