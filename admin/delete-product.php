<?php
// Include Constants Page
include('../config/constants.php');

// Check if 'id' and 'image_name' are set in the URL
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Get ID and Image Name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the Image File if it exists
    $path = "../img/product/" . $image_name;
    unlink($path);

    // Delete Product from Database
    $sql = "DELETE FROM produits WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($res == true) {
        // Product Deleted
        $_SESSION['delete'] = "<div class='success'>Produit supprimé avec succès.</div>";
    } else {
        // Failed to Delete Product
        $_SESSION['delete'] = "<div class='error'>Échec de la suppression du produit.</div>";
    }
} else {
    // Redirect to ManageProduct Page if 'id' or 'image_name' is not set
    $_SESSION['unauthorize'] = "<div class='error'>Accès non autorisé.</div>";
}

// Redirect to ManageProduct with Session Message
header('location:' . SITEURL . 'admin/manage-products.php');
?>
