<?php
ob_start();
include('../admin/partials/menu.php');
?>

<?php
// Check whether ID is set or not
if (isset($_GET['id'])) {
    // Get all the details
    $id = $_GET['id'];

    // SQL query to get selected product
    $sql2 = "SELECT * FROM produits WHERE id=$id";

    // Execute the query
    $res2 = mysqli_query($conn, $sql2);

    // Get the value based on the executed query
    $row2 = mysqli_fetch_assoc($res2);

    // Get the individual values of the selected product
    $titre = $row2['titre'];
    $description = $row2['description'];
    $prix = $row2['prix'];
    $current_image = $row2['nom_de_image'];
    $current_category = $row2['id_categorie'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    // Redirect to manage product
    header('location: ' . SITEURL . 'admin/manage-products.php');
}
?>

<div class="content">
    <div class="wrapper">
        <br>
        <h1 class="text-center">Modifier des Produits</h1>
        <!-- Product Form starts -->
        <form class="form-container mb-3" action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="titre" value="<?php echo $titre; ?>">
                <div class="form-text">Veuillez entrer le nom du Produit</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea cols="30" rows="5" class="form-control" name="description" placeholder="Description du Produit">
                    <?php echo $description; ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix du Produit</label>
                <input type="number" class="form-control" name="prix" value="<?php echo $prix; ?>">
                <div class="form-text">Entrer un Prix</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <?php
                if ($current_image != "") {
                    // Display the Image
                ?>
                    <img src="<?php echo SITEURL; ?>img/food/<?php echo $current_image; ?>" width="150px">
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
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-select">
                    <?php
                    // Create PHP Code to display categories from Database
                    // 1. Create SQL to get all active categories from the database
                    $sql = "SELECT * FROM categories_de_produits WHERE active='Yes'";

                    // Execute query
                    $res = mysqli_query($conn, $sql);

                    // Count rows to check whether we have categories or not
                    $count = mysqli_num_rows($res);

                    // If count is greater than zero, we have categories; otherwise, we don't have categories
                    if ($count > 0) {
                        // We have categories
                        while ($row = mysqli_fetch_assoc($res)) {
                            // Get the details of categories
                            $category_id = $row['id'];
                            $category_title = $row['titre'];

                            // Check if the current category is selected
                            $selected = ($category_id == $current_category) ? "selected" : "";

                            echo "<option value='$category_id' $selected>$category_title</option>";
                        }
                    } else {
                        // We do not have categories
                        echo "<option value='0'>No Category Found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">En vedette</label>
                <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>>Oui
                <input type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>>Non
            </div>
            <div class="mb-3">
                <label class="form-label">Actif</label>
                <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>>Oui
                <input type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>>Non
            </div>

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input class="btn btn-success" type="submit" value="Modifier" name="submit">
        </form>
        <!-- End of Product Form -->

        <?php
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $id = $_POST['id'];
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category_id'];
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            // Upload the image if selected
            if (isset($_FILES['image']['name'])) {
                // Image upload button clicked
                $image_name = $_FILES['image']['name']; // New image name
                // Check whether the file is available
                if ($image_name != "") {
                    // Image is available
                    // Rename the image
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    // Gets the extension of the file

                    $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext; // This will be the renamed image

                    // Get the source path and destination path
                    $src_path = $_FILES['image']['tmp_name']; // Source path
                    $dest_path = "../img/food/" . $image_name; // Destination path

                    // Upload the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    // Check whether the image is uploaded or not
                    if (!$upload) {
                        // Failed to upload the image
                        $_SESSION['upload'] = "<div class='error'>Failed to upload the new Image.</div>";
                        // Redirect to manage Products
                        header('location:' . SITEURL . 'admin/manage-products.php');
                        // Stop the process
                        die();
                    }

                    // Remove the current image if it exists
                    if ($current_image !== "") {
                        // Current image is available
                        $remove_path = "../img/food/" . $current_image;

                        // Check if the file exists before attempting to delete it
                        if (file_exists($remove_path)) {
                            $remove = unlink($remove_path);
                            // Check whether the image is removed or not
                            if ($remove == false) {
                                // Failed to remove the current image
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove the current Image.</div>";
                                // Redirect to manage Products
                                header('location:' . SITEURL . 'admin/manage-products.php');
                                // Stop the process
                                die();
                            }
                        } else {
                            // The image file doesn't exist, so there's no need to delete it.
                        }
                    }
                } else {
                    // No new image was uploaded, so keep the current image name
                    $image_name = $current_image;
                }
            }

            // Update the product in the database
            $sql3 = "UPDATE produits SET
            titre = '$titre',
            description = '$description',
            prix = $prix,
            nom_de_image = '$image_name',
            id_categorie = $category,
            featured = '$featured',
            active = '$active'
            WHERE id=$id";

            // Execute the SQL Query
            $res3 = mysqli_query($conn, $sql3);

            // Check whether the query is executed or not
            if ($res3 == true) {
                // Query executed and Product updated successfully
                $_SESSION['update'] = "<div class='success'>Product Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-products.php');
            } else {
                // Failed to update Product
                $_SESSION['update'] = "<div class='error'>Failed to update Product.</div>";
                header('location:' . SITEURL . 'admin/manage-products.php');
            }
        }
        ?>

    </div>
</div>

<?php include('./partials/footer.php'); ?>