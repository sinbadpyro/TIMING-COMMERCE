<?php include('./partials/menu.php') ?>

<!--BEGINNING OF MAIN CONTENT-->
<div class="main-content p-5">
    <div class="container my-auto">
        <h1>Gerer les Produits</h1>
        <a href="<?php echo SITEURL; ?>admin/add-product.php" class="btn btn-success">Ajouter des Produits</a>
        <br> <br> <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if (isset($_SESSION['unauthorize'])) {
            echo $_SESSION['unauthorize'];
            unset($_SESSION['unauthorize']);
        }

        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        ?>
        <br> <br>
        
        <div class="table-responsive" style="height: 400px;">
            <table class="table table-responsive table-bordered border-dark table-hover text-center">
                <thead class="table-dark table-active text-uppercase sticky-top">
                    <tr>
                        <th>S.N.</th>
                        <th>Titre</th>
                        <th>Prix</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    //Query to Get all Products from Database
                    $sql = "SELECT * FROM produits";

                    //Execute Query
                    $res = mysqli_query($conn, $sql);

                    //Count Rows
                    $count = mysqli_num_rows($res);

                    //Create Serial Number Variable and assign value as 1
                    $sn = 1;

                    //Check whether we have data in database or not
                    if ($count > 0) {
                        //We have data in database
                        //get the data and display
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $titre = $row['titre'];
                            $prix = $row['prix'];
                            $image_name = $row['nom_de_image'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                    ?>

                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $titre; ?></td>
                                <td>€<?php echo $prix; ?></td>

                                <td>
                                    <?php
                                    //CHeck whether we have image or not
                                    if ($image_name == "") {
                                        //WE do not have image, DIslpay Error Message
                                        echo "<div class='error'>Image not Added.</div>";
                                    } else {
                                        //WE Have Image, Display Image
                                    ?>
                                        <img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                    }
                                    ?>
                                </td>

                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-product.php?id=<?php echo $id; ?>" class="btn btn-secondary m-1">Modifier Produit</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-product.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger m-1">Supprimer Produit</a>
                                </td>
                            </tr>

                        <?php

                        }
                    } else {
                        //WE do not have data
                        //We'll display the message inside table
                        ?>

                        <tr>
                            <td colspan="7">
                                <div class="error">No Products Added.</div>
                            </td>
                        </tr>

                    <?php
                    }

                    ?>


                </tbody>

            </table>
        </div>
        
    </div>
</div>
<!--END OF MAIN CONTENT-->

<?php include('./partials/footer.php') ?>