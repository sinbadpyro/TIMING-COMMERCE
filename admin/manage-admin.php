<?php include('./partials/menu.php') ?>

<!--BEGINNING OF MAIN CONTENT-->
<div class="main-content p-5">
    <div class="container my-auto">
        <h1>Gerer les Admin</h1>
        <br>
        <div class="container">
            <a class="btn btn-success" href="add-admin.php" role="button">Ajouter un Administrateur</a>
        </div>
        <br>

        <?php
        if (isset($_SESSION['add'])) { // checking whether session is set or not 
            echo $_SESSION['add']; //displaying session message
            unset($_SESSION['add']); // removing session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset( $_SESSION['user-not-found'])) {
            echo  $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if (isset( $_SESSION['pwd-not-match'])) {
            echo  $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if (isset( $_SESSION['change-pwd'])) {
            echo  $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }
        ?>

        <br>
        <br>
        <!--TABLE FOR THE ADMINS-->
        <div class="container">
            <table class="table table-responsive table-bordered border-dark table-hover text-center">
                <thead class="table-dark table-active text-uppercase ">
                    <th>SN</th>
                    <th>NOM COMPLETE</th>
                    <th>NOM DE UTILISATEUR</th>
                    <th>ACTION</th>
                </thead>

                <!--BEGINNING OF PHP CODE--->
                <?php
                //Query to get all admin
                $sql = "SELECT * FROM ecomateriaux_admin ";
                //Execute the query
                $res = mysqli_query($conn, $sql);
                //check whether the query is executed or not 
                if ($res == true) {
                    //count rows to check whether we have data in database or not
                    $count = mysqli_num_rows($res); //function to get all the tows in database
                    $sn = 1; //create a variable and assign the value

                    //check the number of rows
                    if ($count > 0) {
                        //we havae data in database
                        while ($rows = mysqli_fetch_assoc($res)) {
                            //while using loop to get all the data from database
                            //and while loop will run as we long as we have data in database

                            //Get individual data
                            $id = $rows['id'];
                            $nom_complet = $rows['nom_complet'];
                            $nom_de_utilisateur = $rows['nom_de_utilisateur'];
                            //display the values in our table
                ?>
                            <tr>
                                <td><?php echo $sn++ ?></td>
                                <td><?php echo $nom_complet ?></td>
                                <td><?php echo $nom_de_utilisateur ?></td>
                                <td>
                                    <a class="btn btn-secondary p-1 m-1 btn-equal" href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" role="button">Changer le mot de passe</a>
                                    <a class="btn btn-primary p-1 m-1 btn-equal-size " href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" role="button">Modifier</a>
                                    <a class="btn btn-danger p-1 m-1 btn-equal-size" href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" role="button">Supprimer</a>

                                </td>
                            </tr>
                <?php
                        }
                    } else {
                        //we do not have data in database
                    }
                }
                ?>
                <!--END OF PHP CODE-->


            </table>
        </div>
    </div>
</div>
<!--END OF MAIN CONTENT-->

<?php include('./partials/footer.php') ?>