<?php include('./partials/menu.php') ?>
    <!--- This is the back button--->
    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<!--BEGINNING OF MAIN CONTENT-->
<div class="main-content p-5">
    <div class="container my-auto">
        <h1>Gerer les Categories</h1>
        <br>
        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        } 
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        } 
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        } 
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        } 
        ?>

        <br>
        <br>
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn btn-success">Ajouter des catégories</a>
        <br>
        <br>
         
        <div class="table-responsive">
        <table class="table table-bordered border-dark table-hover text-center">
            <thead class="table-dark table-active text-uppercase">
                <tr>
                    <th>S.N.</th>
                    <th>Titre</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php

                //Query to Get all CAtegories from Database
                $sql = "SELECT * FROM categories_de_produits";

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
                        $image_name = $row['nom_de_image'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                ?>

                        <tr>
                            <td><?php echo $sn++; ?>. </td>
                            <td><?php echo $titre; ?></td>

                            <td>

                                <?php
                                //Chcek whether image name is available or not
                                if ($image_name != "") {
                                    //Display the Image
                                ?>

                                    <img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" width="100px">


                                <?php
                                } else {
                                    //DIsplay the MEssage
                                    echo "<div class='error'>Image not Added.</div>";
                                }
                                ?>

                            </td>

                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn btn-secondary m-1">Update Category</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-danger m-1">Delete Category</a>
                            </td>
                        </tr>

                    <?php

                    }
                } else {
                    //WE do not have data
                    //We'll display the message inside table
                    ?>

                    <tr>
                        <td colspan="6">
                            <div class="error">No Category Added.</div>
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