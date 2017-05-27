<?php
$host = "localhost";
$user = "test";
$pass = "t3st3r123";
$db = "test";

$connection = mysqli_connect($host, $user, $pass, $db);
$query_demos = "SELECT 
                    SUM(demoAmount) AS DemosiKokku
                    FROM vanporman_demopacks";
$result = mysqli_query($connection, $query_demos) or die("$query_demos - ".mysqli_error($connection));
while ($row = $result -> fetch_assoc()){
    if (empty($row['DemosiKokku'])){
        echo "<tr>0</tr>";
    } else {
        echo "<tr><b>".$row['DemosiKokku']."</b> pakki</tr>";
    }
};
mysqli_close($connection);
?>