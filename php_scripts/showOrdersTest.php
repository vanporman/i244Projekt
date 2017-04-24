<?php
$host = "localhost";
$user = "test";
$pass = "t3st3r123";
$db = "test";

$connection = mysqli_connect($host, $user, $pass, $db);

$textChanger = '';
//$backgroundColor = '';
//$textColor = '';
//$borderThick = '';
$borderType = '';
//$borderColor = '';
//$borderRadius = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['customerName']) && $_POST['customerName'] != ""){
        $textChanger = htmlspecialchars($_POST['customerName']);
    }
//    if (isset($_POST['backgroundColor']) && $_POST['backgroundColor'] != ""){
//        $backgroundColor = htmlspecialchars($_POST['backgroundColor']);
//    }
//    if (isset($_POST['textColor']) && $_POST['textColor'] != ""){
//        $textColor = htmlspecialchars($_POST['textColor']);
//    }
//    if (isset($_POST['borderThickness']) && $_POST['borderThickness'] != ""){
//        $borderThick = htmlspecialchars($_POST['borderThickness']);
//    }
    if (isset($_POST['whoIsResponsible']) && $_POST['whoIsResponsible'] != ""){
        $borderType = htmlspecialchars($_POST['whoIsResponsible']);
    }
//    if (isset($_POST['borderColor']) && $_POST['borderColor'] != ""){
//        $borderColor = htmlspecialchars($_POST['borderColor']);
//    }
//    if (isset($_POST['borderRadius']) && $_POST['borderRadius'] != ""){
//        $borderRadius = htmlspecialchars($_POST['borderRadius']);
//    }
}

$query = "SELECT * FROM vanporman_orders WHERE customerName = '$textChanger'";
//$query = "SELECT * FROM vanporman_orders";
$result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));

echo $query;

echo "<table class='table table-striped'>
            <thead>
                <tr>

                    <th>Client</th>
                    
                    <th>Status</th>
                    <th>Responsible</th>
                    
                </tr>
            </thead>
            <tbody>";
while ($row = $result -> fetch_assoc()){
    echo "<tr>
                <td>". $row['customerName']."</td>
                
                <td>". $row['orderStatus']."</td>
                <td>". $row['whoIsResponsible']."</td>
                
            </tr>";
}
echo "</tbody>
            </table>";

?>