<?php
/**
 * Created by PhpStorm.
 * User: andreas
 * Date: 24.04.2017
 * Time: 13:05
 */
    $host = "localhost";
    $user = "test";
    $pass = "t3st3r123";
    $db = "test";

    $connection = mysqli_connect($host, $user, $pass, $db);
    $query_retail = "SELECT 
                    SUM(orderAmount) AS TellimusiKokku
                    FROM vanporman_orders
                    WHERE orderStatus = 'Jaemüük'";
    $result = mysqli_query($connection, $query_retail) or die("$query_retail - ".mysqli_error($connection));
    while ($row = $result -> fetch_assoc()){
        if (empty($row['TellimusiKokku'])){
            echo "0";
        } else {
            echo "<b>".$row['TellimusiKokku']."</b> pakki";
        }
    };
    mysqli_close($connection);
?>