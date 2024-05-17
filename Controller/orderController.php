<?php include('Gestion/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br /><br /><br />

        <?php 
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        <br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Restaurant</th>
                <th>User</th>
                <th>Food</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>

            <?php 
            require_once "Data/database.php";
            $sql = "SELECT * FROM order ORDER BY id DESC"; 

            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            $sn = 1; 
            if($count > 0)
            {
                while($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $id_restaurant = $row ['id_restaurant'];
                    $id_user = $row ['id_user'];
                    $food_name = $row['food'];
                    $price_of_order = $row['price'];
                    $quantity = $row['quantity'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];

                    echo "<tr>";
                    echo "<td>{$sn}. </td>";
                    echo "<td>{$id_restaurant}</td>";
                    echo "<td>{$id_user}</td>";
                    echo "<td>{$food_name}</td>";
                    echo "<td>{$price_of_order}</td>";
                    echo "<td>{$quantity}</td>";
                    echo "<td>{$total}</td>";
                    echo "<td>{$order_date}</td>";
                    echo "<td>";
                    if($status == "Ordered")
                    {
                        echo "<label>{$status}</label>";
                    }
                    elseif($status == "On Delivery")
                    {
                        echo "<label style='color: orange;'>{$status}</label>";
                    }
                    elseif($status == "Delivered")
                    {
                        echo "<label style='color: green;'>{$status}</label>";
                    }
                    elseif($status == "Cancelled")
                    {
                        echo "<label style='color: red;'>{$status}</label>";
                    }
                    echo "</td>";
                    echo "</tr>";
                    $sn++;
                }
            } 
            else
            {
                echo "<tr><td colspan='9'>No orders found.</td></tr>";
            }
            ?>
        </table>

        <h2 class="text-center">Passer une commande</h2>
        <form action="process-order.php" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Nom du plat:</td>
                    <td><input type="text" name="food_name" placeholder="Nom du plat"></td>
                </tr>
                <tr>
                    <td>Prix:</td>
                    <td><input type="number" name="food_price"></td>
                </tr>
                <tr>
                    <td>Quantité:</td>
                    <td><input type="number" name="quantity"></td>
                </tr>
                <tr>
    <td>Utilisateur:</td>
    <td><input type="text" name="user" placeholder="Nom de l'utilisateur"></td>
</tr>
<tr>
    <td>Restaurant:</td>
    <td>
        <select name="restaurant">
            <option value="1">Restaurant 1</option>
            <option value="2">Restaurant 2</option>
        </select>
    </td>
</tr>                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="Passer la commande" class="btn-secondary"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
