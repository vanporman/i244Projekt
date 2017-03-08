<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 07/03/2017
 * Time: 23:13
 */
//echo 'hello world!';
    $host = "localhost";
    $user = "test";
    $pass = "t3st3r123";
    $db = "test";

    $connection = mysqli_connect($host, $user, $pass, $db);
    $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders";
    $result = mysqli_query($connection, $query_sum) or die("$query_sum - ".mysqli_error($connection));
    echo "<table class='table'>
            <thead>
                <tr>
                    <th class='text-center'>SumOfClients</th>
                    <th class='text-center'>AmountOfOrders</th>
                    <th class='text-center'>SumOfOrders</th>
                    <th class='text-center'>SumOfValues</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result -> fetch_assoc()){
        echo "<tr>
                <td class='text-center'>". $row['KlienteKokku']."</td>
                <td class='text-center'>". $row['TellimusiKokku']."</td>
                <td class='text-center'>". $row['OotelTellimusi']."</td>
                <td class='text-center'>". $row['SummaKokku']."</td>
            </tr>";
    }
    echo "</tbody>
            </table>";

    $query = "SELECT * FROM vanporman_orders";
    $result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
    //$row = mysqli_fetch_assoc($result);
    echo "<table class='table table-striped'>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Client</th>
                    <th>DateofOrder</th>
                    <th>DateofSale</th>
                    <th>Amount</th>
                    <th>Price</th>
                    <th>Sum</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Responsible</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $result -> fetch_assoc()){
        echo "<tr>
                <td>". $row['orderID']."</td>
                <td>". $row['customerName']."</td>
                <td>". $row['orderDate']."</td>
                <td>". $row['saleDate']."</td>
                <td>". $row['orderAmount']."</td>
                <td>". $row['priceOfItem']."</td>
                <td>". $row['sumOfOrder']."</td>
                <td>". $row['sizeOfPack']."</td>
                <td>". $row['orderStatus']."</td>
                <td>". $row['whoIsResponsible']."</td>
                <td>". $row['orderComments']."</td>
            </tr>";
    }
    echo "</tbody>
            </table>";
    mysqli_close($connection);
?>