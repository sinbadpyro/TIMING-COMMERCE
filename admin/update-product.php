<?php
ob_start();
include('../admin/partials/menu.php');
?>
    <!--- This is the back button--->
    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<?php
// Check whether ID is set or not
if (isset($_GET['id'])) {
    // Get all the details
    $id = $_GET['id'];

    // SQL query to get selected product
    $sql2 = "SELECT * FROM produits WHERE id = $id";

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
    $link = $row2['links'];
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
                    <img src="<?php echo SITEURL; ?>img/product/<?php echo $current_image; ?>" width="150px">
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

            <div class="mb-3">
                <label class="form-label">Entrer le lien starmat pour ce Produit</label>
                <input type="url" id="website" name="website" value="<?php echo $link; ?>" placeholder="https://www.starmat.com" required>
                <div class="form-text">Veuillez entrer un lien</div>
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
            $description = mysqli_real_escape_string($conn, $_POST['description']); // Sanitize the description
            $prix = $_POST['prix'];
            $link = $_POST['website'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category_id'];
            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                    $image_name = "Product-Name-" . rand(0000, 9999) . '.' . $ext;
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../img/product/" . $image_name;

                    $upload = move_uploaded_file($src_path, $dest_path);

                    if (!$upload) {
                        $_SESSION['upload'] = "<div class='error'>Failed to upload the new Image.</div>";
                        header('location:' . SITEURL . 'admin/manage-products.php');
                        die();
                    }

                    if ($current_image !== "") {
                        $remove_path = "../img/product/" . $current_image;

                        if (file_exists($remove_path)) {
                            $remove = unlink($remove_path);

                            if ($remove == false) {
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove the current Image.</div>";
                                header('location:' . SITEURL . 'admin/manage-products.php');
                                die();
                            }
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            }

            // Use prepared statements to update the product
            $sql3 = "UPDATE produits SET
            titre = ?,
            description = ?,
            prix = ?,
            nom_de_image = ?,
            id_categorie = ?,
            featured = ?,
            active = ?,
            links = ?
            WHERE id = ?";

            $stmt = mysqli_prepare($conn, $sql3);
            mysqli_stmt_bind_param($stmt, "ssdsssssi", $titre, $description, $prix, $image_name, $category, $featured, $active, $link, $id);


            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['update'] = "<div class='success'>Product Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-products.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update Product: " . mysqli_error($conn) . "</div>";
                header('location:' . SITEURL . 'admin/manage-products.php');
            }
        }
        ?>

    </div>
</div>

<?php include('./partials/footer.php'); ?>