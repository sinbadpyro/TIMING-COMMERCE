<?php include('./partials/menu.php') ?>
    <!--- This is the back button--->
    <a href="javascript:history.go(-1)" class="btn btn-primary mt-3 ms-5" id="back-button">
                <span class="glyphicon glyphicon-arrow-left"></span> Retour 
            </a>
             <!--- End of the back button--->
<!-- BEGINNING OF MAIN CONTENT -->
<div class="main-content p-5">
    <div class="container my-auto">
        <h1>Gerer les Commandes</h1>

        <br /><br /><br />

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>

        <!-- Wrap the table in a div with horizontal scrolling -->
        <div class="table-responsive">
            <table class="table table-bordered border-dark table-hover text-center">
                <thead class="table-dark table-active text-uppercase">
                    <tr>
                        <th>S.N.</th>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantite</th>
                        <th>Total</th>
                        <th>Date de la commande</th>
                        <th>Status</th>
                        <th>Nom du client</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Query to Get all Products from Database
                    $sql = "SELECT * FROM commandes ORDER BY id DESC"; // Display the Latest Order at First

                    //Execute Query
                    $res = mysqli_query($conn, $sql);

                    //Count Rows
                    $count = mysqli_num_rows($res);

                    //Create Serial Number Variable and assign value as 1
                    $sn = 1;

                    //Check whether we have data in the database or not
                    if ($count > 0) {
                        //We have data in the database
                        //get the data and display
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $produit = $row['produit'];
                            $prix = $row['prix'];
                            $qty = $row['quantite'];
                            $total = $row['totale'];
                            $order_date = $row['date_de_commande'];
                            $status = $row['status'];
                            $customer_name = $row['prenom_client'];
                            $customer_contact = $row['numero_client'];
                            $customer_email = $row['email_client'];
                            $customer_address = $row['address_client'];
                    ?>
                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $produit; ?></td>
                                <td><?php echo $prix; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $order_date; ?></td>
                                <td>
                                    <?php
                                    // Ordered, On Delivery, Delivered, Cancelled

                                    if ($status == "Ordered") {
                                        echo "<label>$status</label>";
                                    } elseif ($status == "On Delivery") {
                                        echo "<label style='color: orange;'>$status</label>";
                                    } elseif ($status == "Delivered") {
                                        echo "<label style='color: green;'>$status</label>";
                                    } elseif ($status == "Cancelled") {
                                        echo "<label style='color: red;'>$status</label>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $customer_name; ?></td>
                                <td><?php echo $customer_contact; ?></td>
                                <td><?php echo $customer_email; ?></td>
                                <td><?php echo $customer_address; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn btn-primary">Modifer la commande</a>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        // We do not have data
                        // We'll display the message inside the table
                    ?>
                        <tr>
                            <td colspan="12">
                                <div class="error text-center">No Products Added.</div>
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
<!-- END OF MAIN CONTENT -->

<?php include('./partials/footer.php') ?>
