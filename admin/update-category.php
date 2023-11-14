<?php
ob_start();
include('partials/menu.php'); ?>

<!--- This is the back button--->
<a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
    <span class="glyphicon glyphicon-arrow-left"></span> Retour
</a>
<!--- End of the back button--->
<div class="main-content p-5">
    <div class="container my-auto">

        <br>
        <br>

        <?php
        // Check whether the id is set or not
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM categories_de_produits WHERE id=$id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                // Get all the data
                $row = mysqli_fetch_assoc($res);
                $titre = $row['titre'];
                $current_image = $row['nom_de_image'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                // Redirect to manage category with session message
                $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            // Redirect to Manage Category
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        ?>
        <form class="form-container mb-3" action="" method="POST" enctype="multipart/form-data">
            <h1>Modifier Category</h1>
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="titre" value="<?php echo $titre; ?>">
                <div class="form-text">Veuillez saisir le nouveau nom de la catégorie</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <?php
                if ($current_image != "") {
                    // Display the Image
                ?>
                    <img src="<?php echo SITEURL; ?>img/category/<?php echo $current_image; ?>" width="150px">
                <?php
                } else {
                    // Display Message
                    echo "<div class='error'>Image Not Added.</div>";
                }
                ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Nouvelle image</label>
                <input type="file" class="form-control" name="image">
                <div class="form-text">Veuillez sélectionner une image</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Featured</label>
                <input <?php if ($featured == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="featured" value="Yes">Yes
                <input <?php if ($featured == "No") {
                            echo "checked";
                        } ?> type="radio" name="featured" value="No">No
            </div>

            <div class="mb-3">
                <label class="form-label">Active</label>
                <input <?php if ($active == "Yes") {
                            echo "checked";
                        } ?> type="radio" name="active" value="Yes">Yes
                <input <?php if ($active == "No") {
                            echo "checked";
                        } ?> type="radio" name="active" value="No">No
            </div>

            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input class="btn btn-success" type="submit" value="Modifier la catégorie" name="submit">
        </form>

        <!---PHP CODE TO UPDATE --->
        <?php

        if (isset($_POST['submit'])) {
            // 1. Get all the values from our form
            $id = $_POST['id'];
            $titre = $_POST['titre'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // 2. Updating New Image if selected
            // Check whether the image is selected or not
            if (isset($_FILES['image']['name'])) {
                // Get the Image Details
                $image_name = $_FILES['image']['name'];

                // Check whether the image is available or not
                if ($image_name != "") {
                    // Image Available

                    // A. Upload the New Image
                    // Auto Rename our Image
                    // Get the Extension of our image (jpg, png, gif, etc) e.g. "specialfood1.jpg"
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);

                    // Rename the Image
                    $image_name = "Product_Category_" . rand(000, 999) . '.' . $ext; // e.g. Food_Category_834.jpg
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../img/category/" . $image_name;

                    // Finally Upload the Image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploaded or not
                    // If the image is not uploaded, continue with the existing image
                    if (!$upload) {
                        // Set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                    }
                }
            }
            // 3. Update the Database
            $sql2 = "UPDATE categories_de_produits SET 
                        titre = '$titre',
                        nom_de_image = '$image_name',
                        featured = '$featured',
                        active = '$active' 
                        WHERE id=$id";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // 4. Redirect to Manage Category with Message
            if ($res2) {
                // Category Updated
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
            } else {
                // Failed to update category
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
            }
            header('location:' . SITEURL . 'admin/manage-category.php');
            die(); // Stop the Process
        }

        ?>
        <!--END OF PHP CODE-->
    </div>
</div>

<?php include('partials/footer.php'); ?>
