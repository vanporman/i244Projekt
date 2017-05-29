<?php
$host = "localhost";
$user = "test";
$pass = "t3st3r123";
$db = "test";

$connection = mysqli_connect($host, $user, $pass, $db);
$query_all_sales = $query = "SELECT SUM(orderAmount) AS MyykeKokku 
                              FROM vanporman_orders 
                              WHERE orderStatus IN ('Jaemüük', 'Hulgimüük', 'Laadamüük')";
$result = mysqli_query($connection, $query_all_sales) or die("$query_all_sales - ".mysqli_error($connection));
while ($row = $result -> fetch_assoc()){
    if (empty($row['MyykeKokku'])){
        echo "0";
    } else {
        echo "<b>".$row['MyykeKokku']."</b> pakki";
    }
};
mysqli_close($connection);
?>