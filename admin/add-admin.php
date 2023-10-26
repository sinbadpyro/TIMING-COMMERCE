<?php include('./partials/menu.php') ?>
         <!--- This is the back button--->
         <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<div class="main-content">
    <div class="container text-center my-5">
        <h1>Ajouter un Administrateur</h1>
        <br>
        <?php
        if (isset($_SESSION['add'])) { // checking whether session is set or not 
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); // removing session message
        }
        ?>
        <!-- FORM -->

        <form class="form-container" action="" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nom et prénom</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="nom_complet">
                <div id="emailHelp" class="form-text">Veuillez écrire votre nom complet</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="nom_de_utilisateur">
                <div id="emailHelp" class="form-text">Merci d'entrer un nom d'utilisateur</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="mot_de_passe">
                <div id="emailHelp" class="form-text">Veuillez entrer un mot de passe</div>
            </div>

           
            <input class="btn btn-success" type="submit" value="Ajout Admin" name="submit">
        </form>

        <!-- End OF FORM-->
    </div>
</div>


<?php include('./partials/footer.php') ?>

<?php
//Process the value from the form and save it in database
//check whether the submit button is clicked or not

if (isset($_POST['submit'])) {
    //1. Get the data from form
    $full_name = $_POST['nom_complet'];
    $username = $_POST['nom_de_utilisateur'];
    $password = md5($_POST['mot_de_passe']); //Password encryption

    //2. SQL Query to save the database
    $sql = "INSERT INTO ecomateriaux_admin SET
         nom_complet  = '$full_name',
         nom_de_utilisateur = '$username',
         mot_de_passe = '$password'
       ";
    if ($conn->query($sql) === TRUE) {
        // echo "New record created successfully";
        //create a session variable to display message
        $_SESSION['add'] = "Admin added sucessfully";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        // echo "Error: " . $sql . "<br>" . $conn->error;
        //create a session variable to display message
        $_SESSION['add'] = "Failed to add Admin ";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
    mysqli_close($conn);
}
?>