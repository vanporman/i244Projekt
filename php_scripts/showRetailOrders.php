<?php
$host = "localhost";
$user = "test";
$pass = "t3st3r123";
$db = "test";

$connection = mysqli_connect($host, $user, $pass, $db);
$query_fairsale = "SELECT
                            SUM(orderAmount) AS TellimusiKokku
                            FROM vanporman_orders
                            WHERE orderStatus = 'Jaeootel'";
$result = mysqli_query($connection, $query_fairsale) or die("$query_fairsale - ".mysqli_error($connection));
while ($row = $result -> fetch_assoc()){
    if (empty($row['TellimusiKokku'])){
        echo "<tr>0</tr>";
    } else {
        echo "<tr><b>".$row['TellimusiKokku']."</b> pakki</tr>";
    }

};
mysqli_close($connection);
?>