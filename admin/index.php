<?php include('./partials/menu.php') ?>


<!--BEGINNING OF MAIN CONTENT-->
<div class="main-content">
    <?php
    if (isset($_SESSION['login'])) {
        echo $_SESSION['login'];
        unset($_SESSION['login']);
    }
    ?>
    <br>
    <div class="container mt-5">
        <h1>Tableau de bord</h1>
        <div class="row text-center text-light">
            <?php
            //Sql Query 
            $sql = "SELECT * FROM categories_de_produits";
            //Execute Query
            $res = mysqli_query($conn, $sql);
            //Count Rows
            $count = mysqli_num_rows($res);
            ?>
            <div class=" col-sm-3 my-3 mx-auto bg-success p-3" style="width: 17rem">
                <h3><?php echo $count ?> <br> Categories</h3>
            </div>

            <?php
            //Sql Query 
            $sql2 = "SELECT * FROM produits";
            //Execute Query
            $res2 = mysqli_query($conn, $sql2);
            //Count Rows
            $count2 = mysqli_num_rows($res2);
            ?>
            <div class=" col-sm-3 my-3 mx-auto bg-success p-3" style="width: 17rem">
                <h3><?php echo $count2 ?> <br> Produits</h3>
            </div>

            <?php
            //Sql Query 
            $sql3 = "SELECT * FROM commandes";
            //Execute Query
            $res3 = mysqli_query($conn, $sql3);
            //Count Rows
            $count3 = mysqli_num_rows($res3);
            ?>
            <div class=" col-sm-3 my-3 mx-auto bg-success p-3" style="width: 17rem">
                <h3><?php echo $count3 ?> <br> Commandes</h3>
            </div>

            <?php
            //Creat SQL Query to Get Total Revenue Generated
            //Aggregate Function in SQL
            $sql4 = "SELECT SUM(totale) AS Total FROM commandes WHERE status='Delivered'";

            //Execute the Query
            $res4 = mysqli_query($conn, $sql4);

            //Get the VAlue
            $row4 = mysqli_fetch_assoc($res4);

            //GEt the Total REvenue
            $total_revenue = $row4['Total'];

            ?>

            <div class=" col-sm-3 my-3 mx-auto bg-success p-3" style="width: 17rem">
                <h3>€<?php echo $total_revenue; ?><br>Recettes générées</h3>
            </div>


        </div>
    </div>
</div>
<!--END OF MAIN CONTENT-->

<?php include('./partials/footer.php') ?>