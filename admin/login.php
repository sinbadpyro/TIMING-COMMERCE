<?php include('../config/constants.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>ECOMATERIAUX</title>
    <link rel="stylesheet" href="../css/admin.css" type="text/css">
</head>

<body>
    <h1 class="text-center mt-2">Se connecter</h1>
    <?php
               if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
               if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
    <form class="form-container bg-success p-5 mt-5 text-white" action="" method="POST">

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


        <input class="btn btn-secondary" type="submit" value="se connecter" name="submit">
    </form>
</body>

</html>

<?php
  //check whether the submit button is clicked or not
  if(isset($_POST['submit'])){
      //process for login
      //1. Get the data from login form

      /*This commented code below was the previous code used to sign in
      echo $nom_de_utilisateur = $_POST['nom_de_utilisateur'];
      echo $mot_de_passe = md5($_POST['mot_de_passe']);
     */
 

      //The code below is makes the login and password more secure
      $nom_de_utilisateur = mysqli_real_escape_string($conn, $_POST['nom_de_utilisateur']); 
      $raw_password = md5($_POST['mot_de_passe']);
      $mot_de_passe = mysqli_real_escape_string($conn, $raw_password);

      //2. Sql to check if the username and password exist or not 
      $sql = "SELECT * FROM ecomateriaux_admin WHERE nom_de_utilisateur='$nom_de_utilisateur' AND mot_de_passe='$mot_de_passe'";

      //3. Execute the query
      $res = mysqli_query($conn, $sql);

      //4. count rows to check whether user exists or not
      $count = mysqli_num_rows($res);

      if($count == 1){
        //user available and login success
        $_SESSION['login'] = "<div class='success text-center'>Login Sucsessful.</div>";
        $_SESSION['user'] = $nom_de_utilisateur;

        //redirect to Homepage/Dashboard
        header('location:'.SITEURL.'admin/');
      }
      else{
        //user not available and login fail
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        //redirect to Homepage/Dashboard
        header('location:'.SITEURL.'admin/login.php');
      }



  }
?>