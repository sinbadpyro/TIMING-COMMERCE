<?php include('./partials/menu.php'); ?>
           <!--- This is the back button--->
           <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<div class="content">
    <div class="wrapper">

        <br>
        <h1 class="text-center">Ajouter des catégories</h1>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        } // add this code to manage-category.php as well

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        } // add this code to manage-category.php as well
        ?>
        <br>

        <!--Add Category Form starts-->
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
        <!--Add Category Form starts-->

        <?php
        //check if the submit button is clicked or not
        if (isset($_POST['submit'])) {
            //echo "Clicked";

            //1. Get the Value from CAtegory Form
            $titre = $_POST['titre'];

            //For Radio input, we need to check whether the button is selected or not
            if (isset($_POST['featured'])) {
                //Get the VAlue from form
                $featured = $_POST['featured'];
            } else {
                //SEt the Default VAlue
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }
            //check whether the image is selected or not and set the value for image name accordingly
            /*print_r($_FILES['image']);
            die(); //break the code here */

            if (isset($_FILES['image']['name'])) {
                //upload the image
                //to upload we need image name, source path and destination path
                $image_name = $_FILES['image']['name'];

                //auto rename our image
                //get the extension of our image (jpg, png, gif, etc) e.g "special.foods.jpg"
                $file_info = pathinfo($image_name);
                $ext = $file_info['extension'];


                //rename the image
                $image_name = "Product_Category_" . rand(000, 999) . '.' . $ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../img/category/" . $image_name;

                //finally upload the imagei
                $upload = move_uploaded_file($source_path, $destination_path);

                //check whether the image is uploaded or not
                //and if the image is not uploaded then we will stop the process and redirect with an error message
                if ($upload == false) {
                    //set message 
                    $_SESSION['upload'] = "<div class='error'>Échec du téléchargement de l'image .</div>";
                    //redirect to add category page
                    header('location:' . SITEURL . 'admin/add-category.php');
                    //STop the Process
                    die();
                }
            } else {
                //Don't upload the image and set the image value as blank
                $image_name = "";
            }
            //2. Create SQL Query to insert category into database

            $sql = "INSERT INTO categories_de_produits SET titre = '$titre', featured = '$featured', nom_de_image = '$image_name', active = '$active'";

            //3. Execute the query and save in database
            $res = mysqli_query($conn, $sql);
            //4. Check whether the query executed or not and data added or not
            if ($res == true) {
                //Query Executed and Category Added
                $_SESSION['add'] = "<div class='success'>Category Catégorie ajoutée avec succès.</div>";
                //Redirect to Manage Category Page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //Failed to Add CAtegory
                $_SESSION['add'] = "<div class='error'>Échec de l'ajout d'une catégorie.</div>";

                //Redirect to Manage Category Page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>

    </div>
</div>

<?php include('./partials/footer.php'); ?>