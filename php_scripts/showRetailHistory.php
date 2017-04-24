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
        echo "<tr>".$row['TellimusiKokku']."</tr>";
    };

//    $query_wholesale = "SELECT
//                        SUM(orderAmount) AS TellimusiKokku
//                        FROM vanporman_orders
//                        WHERE orderStatus = 'Hulgimüük'";
//    $result = mysqli_query($connection, $query_wholesale) or die("$query_wholesale - ".mysqli_error($connection));
//    while ($row = $result -> fetch_assoc()){
//        echo "<tr>".$row['TellimusiKokku']."</tr>";
//    };
//
//    $query_fairsale = "SELECT
//                            SUM(orderAmount) AS TellimusiKokku
//                            FROM vanporman_orders
//                            WHERE orderStatus = 'Laadamüük'";
//    $result = mysqli_query($connection, $query_fairsale) or die("$query_fairsale - ".mysqli_error($connection));
//    while ($row = $result -> fetch_assoc()){
//        echo "<tr>".$row['TellimusiKokku']."</tr>";
//    };
    mysqli_close($connection);
?>