<?php
ob_start();
include('partials/menu.php'); ?>
    <!--- This is the back button--->
    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<div class="main-content p-3 row">
    <div class="container  Products rounded justify-content-center col-md-7 col-sm-9 ">

        <h1>Modifer La commande</h1>
        <br><br>

        <?php

        //CHeck whether id is set or not
        if (isset($_GET['id'])) {
            //GEt the Order Details
            $id = $_GET['id'];

            //Get all other details based on this id
            //SQL Query to get the order details
            $sql = "SELECT * FROM commandes WHERE id=$id";
            //Execute Query

            $res = mysqli_query($conn, $sql);
            //Count Rows

            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //Detail Availble
                $row = mysqli_fetch_assoc($res);

                $produit = $row['produit'];
                $prix = $row['prix'];
                $qty = $row['quantite'];
                $status = $row['status'];
                $customer_name = $row['prenom_client'];
                $customer_contact = $row['numero_client'];
                $customer_email = $row['email_client'];
                $customer_address = $row['address_client'];
            } else {
                //DEtail not Available/
                //Redirect to Manage Order
                header('location:' . SITEURL . 'admin/manage-orders.php');
            }
        } else {
            //REdirect to Manage ORder PAge
            header('location:' . SITEURL . 'admin/manage-orders.php');
        }

        ?>

        <form action="" method="POST" class="order">
            <fieldset class="border border-light rounded mb-3">
                <div class="row justify-content-center p-2 ">
                    <legend>Produit sélectionné</legend>
                    <div class="food-menu-desc col text-lg text-sm">
                        <h3><?php echo $produit; ?></h3>
                        <strong><?php echo $produit; ?></strong>
                        <p class="fw-bold">$<?php echo $prix; ?></p>
                        <div class="order-label">Quantité</div>
                        <input type="number" name="qty" class="input-responsive" value="<?php echo $qty; ?>" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="border border-light rounded p-3">
                <legend>Détails de la livraison</legend>

                <div class="form-group">
                    <label for="full-name" class="order-label">Status</label>
                    <select name="status">
                        <option <?php if ($status == "Ordered") {
                                    echo "selected";
                                } ?> value="Ordered">Ordered</option>
                        <option <?php if ($status == "On Delivery") {
                                    echo "selected";
                                } ?> value="On Delivery">On Delivery</option>
                        <option <?php if ($status == "Delivered") {
                                    echo "selected";
                                } ?> value="Delivered">Delivered</option>
                        <option <?php if ($status == "Cancelled") {
                                    echo "selected";
                                } ?> value="Cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="full-name" class="order-label">Nom du client</label>
                    <input type="text" id="full-name" name="customer_name" placeholder="E.g. Vijay Thapa" class="form-control input-responsive" value="<?php echo $customer_name; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact" class="order-label">Numéro de téléphone du client</label>
                    <input type="tel" id="contact" name="customer_contact" value="<?php echo $customer_contact; ?>" placeholder="E.g. 0748xxxxxx" class="form-control input-responsive" required>
                </div>
                <div class="form-group">
                    <label for="email" class="order-label">Adresse e-mail</label>
                    <input type="email" id="email" name="customer_email" value="<?php echo $customer_email; ?>" placeholder="E.g. hi@vijaythapa.com" class="form-control input-responsive" required>
                </div>
                <div class="form-group">
                    <label for="address" class="order-label">Adresse</label>
                    <textarea id="address" name="customer_address" rows="10" class="form-control input-responsive" required>
                          <?php echo $customer_address; ?>
                    </textarea>
                </div>
                <br>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="prix" value="<?php echo $prix; ?>">
                <input type="submit" name="submit" value="Confirmer la commande" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
        //CHeck whether Update Button is Clicked or Not
        if (isset($_POST['submit'])) {
            //echo "Clicked";
            //Get All the Values from Form
            $id = $_POST['id'];
            $prix = $_POST['prix'];
            $qty = $_POST['qty'];

            $total = $prix * $qty;

            $status = $_POST['status'];

            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            //Update the Values
            $sql2 = "UPDATE commandes SET 
                produit = '$produit',
                prix = $prix,
                quantite = $qty,
                totale = $total,
                status = '$status',
                prenom_client = '$customer_name',
                numero_client = '$customer_contact',
                email_client = '$customer_email',
                address_client = '$customer_address'
                WHERE id=$id
                ";



            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //CHeck whether update or not
            //And REdirect to Manage Order with Message
            if ($res2 == true) {
                //Updated
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage-orders.php');
            } else {
                //Failed to Update
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location:' . SITEURL . 'admin/manage-orders.php');
            }
        }
        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>