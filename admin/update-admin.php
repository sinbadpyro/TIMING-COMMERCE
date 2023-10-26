<?php include('./partials/menu.php') ?>
    <!--- This is the back button--->
    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->

<div class="main-content p-5">
    <div class="container my-auto">
        <h1>Modifer Administrateur</h1>
        <br>
        <br>
        <?php
        //1.Get ID of selected admin
        $id = $_GET['id'];

        //2. Create SQL Query to get the details
        $sql = "SELECT * FROM  ecomateriaux_admin WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query is executed or not 
        if ($res == true) {
            //check whether the data is available or not
            $count = mysqli_num_rows($res);
            //check whether we have admin data or not
            if ($count == 1) {
                //get the details
                //echo "admin available";
                $row = mysqli_fetch_assoc($res);
                $nom_complet = $row['nom_complet'];
                $nom_de_utilisateur = $row['nom_de_utilisateur'];
            } else {
                //redirect to manage admin page
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        }
        ?>

        <form class="form-container mb-3" action="" method="POST" enctype="multipart/form-data">


            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="titre">
                <div class="form-text">Veuillez entrer le nom de la catégorie</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Sélectionnez une image</label>
                <input type="file" class="form-control" name="image">
                <div class="form-text">Veuillez sélectionner une image</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Featured</label>
                <input type="radio" name="featured" value="yes">yes
                <input type="radio" name="featured" value="no">no
            </div>
            <div class="mb-3">
                <label class="form-label">Active</label>
                <input type="radio" name="active" value="yes">yes
                <input type="radio" name="active" value="no">no
            </div>


            <input class="btn btn-success" type="submit" value="Ajout Categories" name="submit">
        </form>
    </div>

</div>


<?php
//check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //echo "Button clicked";
    //Get all the values from form to update
    $id = $_POST['id'];
    $nom_complet = $_POST['nom_complet'];
    $nom_de_utilisateur = $_POST['nom_de_utilisateur'];

    //Create a SQL Query to update admin
    $sql = "UPDATE ecomateriaux_admin SET
     nom_complet = '$nom_complet',
     nom_de_utilisateur = '$nom_de_utilisateur'
     WHERE id='$id'
     ";

    //execute the query
    $res = mysqli_query($conn, $sql);
    //check whether the query executed sucessfully or not
    if ($res == true) {
        //Query Executed and Admin Updated
        $_SESSION['update'] = "<div class='success'>L'administrateur a été mis à jour avec succès.</div>";
        //Redirect to Manage Admin Page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } else {
        //Failed to Update Admin
        $_SESSION['update'] = "<div class='error'>Échec de la mise à jour de l'administrateur.</div>";
        //Redirect to Manage Admin Page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }
}
?>

<?php include('./partials/footer.php') ?>