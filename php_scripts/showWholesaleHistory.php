<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 24.04.2017
 * Time: 15:22
 */
    $host = "localhost";
    $user = "test";
    $pass = "t3st3r123";
    $db = "test";

$connection = mysqli_connect($host, $user, $pass, $db);
    $query_wholesale = "SELECT
                        SUM(orderAmount) AS TellimusiKokku
                        FROM vanporman_orders
                        WHERE orderStatus = 'Hulgimüük'";
    $result = mysqli_query($connection, $query_wholesale) or die("$query_wholesale - ".mysqli_error($connection));
    while ($row = $result -> fetch_assoc()){
        echo "<tr>".$row['TellimusiKokku']."</tr>";
    };

    mysqli_close($connection);
?>