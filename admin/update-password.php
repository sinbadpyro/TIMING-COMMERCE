<?php include('./partials/menu.php') ?>
    <!--- This is the back button--->
    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<div class="main-content p-5">
    <div class="container my-auto">
        <h1 class="text-center">Changer mot de passe</h1>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>
        <br>
        <br>


        <form class="form-container" action="" method="POST">

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mot de passe actuel</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="mot_de_passe_actuel" placeholder="Mot de passe actuel">
                <div id="emailHelp" class="form-text">entrez le mot de passe actuel</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="nouveau_mot_de_passe" placeholder="Nouveau Mot de passe">
                <div id="emailHelp" class="form-text">entrez le nouveau mot de passe</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="confirmer_nouveau_mot_de_passe" placeholder="Confirmer nouveau Mot de passe">
                <div id="emailHelp" class="form-text">Confirmez le nouveau mot de passe</div>
            </div>

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input class="btn btn-success" type="submit" value="changer mot de passe" name="submit" placeholder="changer mot de passe">
        </form>
    </div>

</div>

<?php
//check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    // echo "clicked";
    //1. Get the data from form
    $id = $_POST['id'];
    $mot_de_passe_actuel = md5($_POST['mot_de_passe_actuel']);
    $nouveau_mot_de_passe = md5($_POST['nouveau_mot_de_passe']);
    $confirmer_nouveau_mot_de_passe = md5($_POST['confirmer_nouveau_mot_de_passe']);
    //2. check whether the user with current ID and current Password exists or not
   
    $sql = "SELECT * FROM ecomateriaux_admin WHERE id = $id AND mot_de_passe = '$mot_de_passe_actuel'

    ";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        //check whether data is available or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //user exists and password can be changed
            //echo "User Found";
              // check whether the new password and confirm password match or not
              if($nouveau_mot_de_passe == $confirmer_nouveau_mot_de_passe){
                //update the password
                $sql2= "UPDATE ecomateriaux_admin SET 
                mot_de_passe='$nouveau_mot_de_passe'
                WHERE id=$id

                ";

                //execute the query
                $res2 = mysqli_query($conn, $sql2);
                //check whether the query executed or not
                if($res2==true){
                    //Display success message
                    $_SESSION['change-pwd'] = "<div class='success'>Password changed succesfully.</div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
                else{
                    //display error message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to change Password.</div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
              }else{
                //redirect to manage admin page with error message
                $_SESSION['pwd-not-match'] = "<div class='error'>Password did not match.</div>";
                //redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
              }

        } else {
            //user does not exist set message and redirect
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
            //redirect the user
            header('location:'.SITEURL.'admin/manage-admin.php');

        }
    }
    //3. check whether the new password and confirm password match or not


    //4. change password if all above is true 
}


?>

<?php include('./partials/footer.php') ?>