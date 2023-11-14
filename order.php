<?php
ob_start();
include('./partials-front/menu.php'); ?>

<!--- This is the back button--->
<a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour  
            </a>
             <!--- End of the back button--->
<?php
//CHeck whether product id is set or not
if (isset($_GET['product_id'])) {
    //Get the Food id and details of the selected food
    $product_id = $_GET['product_id'];

    //Get the DEtails of the SElected Food
    $sql = "SELECT * FROM produits WHERE id=$product_id";
    //Execute the Query
    $res = mysqli_query($conn, $sql);
    //Count the rows
    $count = mysqli_num_rows($res);
    //CHeck whether the data is available or not
    if ($count == 1) {
        //WE Have DAta
        //GEt the Data from Database
        $row = mysqli_fetch_assoc($res);

        $titre = $row['titre'];
        $prix = $row['prix'];
        $image_name = $row['nom_de_image'];
    } else {
        //Food not Availabe
        //REdirect to Home Page
        header('location:' . SITEURL);
    }
} else {
    //Redirect to homepage
    header('location:' . SITEURL);
}
?>

<section class=" m-4 justify-content-center row">
    <div class="text-center Products rounded  col-md-7 col-sm-10 p-4">
        <h2 class="text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset class="border border-light rounded mb-3">
                <legend>Produit sélectionné</legend>
                <div class="row   justify-content-center p-2 ">
                    <div class="food-menu-img  col">

                        <?php
                        //check whether the image is available or not
                        if ($image_name == "") {
                            //image not available
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                            //image is available
                        ?>
                            <img src="<?php echo SITEURL; ?>/img/product/<?php echo $image_name; ?>" alt="Ecomateriaux" class="img-fluid rounded">
                        <?php
                        }
                        ?>

                    </div>

                    <div class="food-menu-desc col text-lg text-sm">
                        <h3><?php echo $titre; ?></h3>
                        <input type="hidden" name="produit" value="<?php echo $titre; ?>">

                        <p class="food-price fw-bold">$<?php echo $prix; ?></p>
                        <input type="hidden" name="prix" value="<?php echo $prix; ?>">

                        <div class="order-label">Quantité</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>

                    </div>
                </div>

            </fieldset>

            <fieldset class="border border-light rounded p-3">
                <legend>Détails de la livraison</legend>
                <div class="form-group">
                    <label for="full-name" class="order-label">Nom complet</label>
                    <input type="text" id="full-name" name="full-name" placeholder="E.g. Vijay Thapa" class="form-control input-responsive" required>
                </div>
                <div class="form-group">
                    <label for="contact" class="order-label">Numéro de téléphone</label>
                    <input type="tel" id="contact" name="contact" placeholder="E.g. 0748xxxxxx" class="form-control input-responsive" required>
                </div>
                <div class="form-group">
                    <label for="email" class="order-label">Adresse e-mail</label>
                    <input type="email" id="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="form-control input-responsive" required>
                </div>
                <div class="form-group">
                    <label for="address" class="order-label">Adresse</label>
                    <textarea id="address" name="address" rows="10" placeholder="Par exemple, rue, ville, pays" class="form-control input-responsive" required></textarea>
                </div>
                <br>
                <input type="submit" name="submit" value="Confirmer la commande" class="btn btn-primary">
            </fieldset>

        </form>

        <?php

        //CHeck whether submit button is clicked or not
        if (isset($_POST['submit'])) {
            // Get all the details from the form

            $produit = $_POST['produit'];
            $prix = $_POST['prix'];
            $qty = $_POST['qty'];

            $total = $prix * $qty; // total = price x qty 

            $order_date = date("Y-m-d h:i:sa"); //Order DAte

            $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled

            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];


            //Save the Order in Databaase
            //Create SQL to save the data
            $sql2 = "INSERT INTO commandes SET 
                produit = '$produit',
                prix = $prix,
                quantite = $qty,
                totale = $total,
                date_de_commande = '$order_date',
                status = '$status',
                prenom_client = '$customer_name',
                numero_client = '$customer_contact',
                email_client = '$customer_email',
                address_client = '$customer_address'
            ";

            //echo $sql2; die();

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Check whether query executed successfully or not
            if ($res2 == true) {
                //Query Executed and Order Saved
                $_SESSION['order'] = "<div class='success text-center'>Product Ordered Successfully.</div>";
                header('location:' . SITEURL);
            } else {
                //Failed to Save Order
                $_SESSION['order'] = "<div class='error text-center'>Failed to Order product.</div>";
                header('location:' . SITEURL);
            }
        }

        ?>
    </div>
</section>

<?php include('./partials-front/footer.php'); ?>