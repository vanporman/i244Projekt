<?php

function connect_db(){
    global $connection;
    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
}

function login(){
    global $connection;
    $errors = array();
    $usr = '';
    //kasutaja 'i244Test'
    $psw = '';
    //parool on 'i244Projekt'
    $rol = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['username']) && $_POST['username'] != ''){
            $usr = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['username']));
        } else {
            $errors[] = "Kasutajanimi on puudu!";
        }
        if (isset($_POST['password']) && $_POST['password'] != ''){
            $psw = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['password']));
        } else {
            $errors[] = "Parool on puudu!";
        }
    }
    $query = "SELECT usr, psw, role FROM vanporman_users WHERE usr = '$usr' AND psw = SHA1('$psw')";
    $result = mysqli_query($connection, $query);
    //võtab mysql tabelist ühe rea ja selle väärtuse tulbast role
    $row = mysqli_fetch_assoc($result);
    $rol = $row['role'];

    $count = mysqli_num_rows($result);

    //$usr[0] == 'i' on ainult niikauaks, kuni retsenseerija saab oma töö tehtud.
//    if (ctype_upper($usr[0]) == true || $usr[0] == 'i' && $count == 1){
//        $_SESSION['user'] = $usr;
//        $_SESSION['role'] = $rol;
//        header("Location: ?page=dashboard");
//    } elseif ($count == 1 && $row['usr'] != $usr || $row['psw'] != $psw) {
//        $errors[] = "Vale kasutaja või parool!";
//    } else {
//        $errors[] = "Vale parolks";
//    }

    if ($count == 1 && $row['usr'] == $usr || $row['psw'] == SHA1('$psw')){
        $_SESSION['user'] = $usr;
        $_SESSION['role'] = $rol;
        header("Location: ?page=dashboard");
    } elseif ($count == 1 && $row['usr'] != $usr || $row['psw'] != SHA1('$psw')) {
        $errors[] = "Vale kasutaja või parool!";
    } else {
        $errors[] = "Vale parolks";
    }

    include_once('views/login.html');
}

function logout(){
    $_SESSION=array();
    session_destroy();
    header("Location: ?");
}

//tellimuste ja myykide tabeli p2ringud
function showOrders(){

    global $connection;

    $ourOrders = array();
    $cN = '';
    $dR = '';
    $wIR = '';
    $oS = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['customerName']) && $_POST['customerName'] != ""){
            $cN = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['customerName']));
        }
        if (isset($_POST['daterange']) && $_POST['daterange'] != ""){
            $dR = htmlspecialchars($_POST['daterange']);
        }
        if (isset($_POST['whoIsResponsible']) && $_POST['whoIsResponsible'] != ""){
            $wIR = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['whoIsResponsible']));
        }
        if (isset($_POST['orderStatus']) && $_POST['orderStatus'] != ""){
            $oS = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['orderStatus']));
        }
    }

    //yhekaupa
    if (!empty($cN) && empty($dR) && empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN'";
    } elseif (!empty($dR) && empty($cN) && empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE orderDate = '$dR'";
    } elseif (!empty($wIR) && empty($cN) && empty($dR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE whoIsResponsible = '$wIR' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE whoIsResponsible = '$wIR'";
    } elseif (!empty($oS) && empty($cN) && empty($dR) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE orderStatus = '$oS'";
    }
    //kahekaupa customerName-iga
    elseif (!empty($cN) && !empty($dR) && empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' AND orderDate = '$dR'";
    } elseif (!empty($cN) && !empty($wIR) && empty($dR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND whoIsResponsible = '$wIR' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' AND whoIsResponsible = '$wIR'";
    } elseif (!empty($cN) && !empty($oS) && empty($dR) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' AND orderStatus = '$oS'";
    }
    //kahekaupa orderDate-iga
    elseif (!empty($dR) && !empty($wIR) && empty($cN) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR'";
    } elseif (!empty($dR) && !empty($oS) && empty($cN) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE orderDate BETWEEN '$dR' AND orderStatus = '$oS'";
    }
    //kahekaupa whoIsResponsible-ga
    elseif (!empty($wIR) && !empty($oS) && empty($cN) && empty($dR)){
        $query = "SELECT * FROM vanporman_orders WHERE whoIsResponsible = '$wIR' AND orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE whoIsResponsible = '$wIR' AND orderStatus = '$oS'";
    }
    //kolmekaupa customerName-iga
    elseif (!empty($cN) && !empty($dR) && !empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR'";
    } elseif (!empty($cN) && !empty($dR) && !empty($oS) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND orderStatus = '$oS'";
    } elseif (!empty($cN) && !empty($wIR) && !empty($oS) && empty($dR)){
        $query = "SELECT * FROM vanporman_orders  WHERE customerName = '$cN' AND whoIsResponsible '$wIR' AND orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' AND whoIsResponsible '$wIR' AND orderStatus = '$oS'";
    }
    //kolmekaupa orderDate-iga
    elseif (!empty($dR) && !empty($wIR) && !empty($oS) && empty($cN)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR' AND orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR' AND orderStatus = '$oS'";
    }
    //v6i p2ring
    elseif (!empty($cN || $dR || $wIR || $oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' OR orderDate BETWEEN '$dR' OR whoIsResponsible = '$wIR' OR orderStatus = '$oS' ORDER BY orderID DESC";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders
                    WHERE customerName = '$cN' OR orderDate BETWEEN '$dR' OR whoIsResponsible = '$wIR' OR orderStatus = '$oS'";
    }
    //k6ik
    else {
        $query = "SELECT * FROM vanporman_orders ORDER BY orderID DESC LIMIT 100";
        $query_sum = "SELECT
                    COUNT(customerName) AS KlienteKokku,
                    SUM(orderAmount) AS TellimusiKokku,
                    COUNT(orderStatus) AS OotelTellimusi,
                    SUM(sumOfOrder) AS SummaKokku
                    FROM vanporman_orders";
    }

    $result = mysqli_query($connection, $query);
    $result_sum = mysqli_query($connection, $query_sum);

    $value_sum = mysqli_fetch_assoc($result_sum);

    while ($row = mysqli_fetch_assoc($result)){
        $ourOrders[] = $row;
    };

    include_once ('views/dashboard.html');
}

//tellimuste sisestamine
function insertOrders(){

    global $connection;

    $customerName = '';
    $orderDate = '';
    $orderAmount = '';
    $priceOfItem = '';
    $sumOfOrder = '';
    $sizeOfPack = '';
    $orderStatus = '';
    $whoIsResponsible = '';
    $orderComments = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['customerName']) && $_POST['customerName'] != ""){
            $customerName = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['customerName']));
        }
        if (isset($_POST['singledate']) && $_POST['singledate'] != ""){
            $orderDate = htmlspecialchars($_POST['singledate']);
        }
        if (isset($_POST['orderAmount']) && $_POST['orderAmount'] != ""){
            $orderAmount = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['orderAmount']));
        }
        if (isset($_POST['priceOfItem']) && $_POST['priceOfItem'] != ""){
            $priceOfItem = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['priceOfItem']));
        }
        if (isset($_POST['sumOfOrder']) && $_POST['sumOfOrder'] != ""){
            $sumOfOrder = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['sumOfOrder']));
        }
        if (isset($_POST['sizeOfPack']) && $_POST['sizeOfPack'] != ""){
            $sizeOfPack = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['sizeOfPack']));
        }
        if (isset($_POST['orderStatus']) && $_POST['orderStatus'] != ""){
            $orderStatus = htmlspecialchars(mysqli_escape_string($connection, $_POST['orderStatus']));
        }
        if (isset($_POST['whoIsResponsible']) && $_POST['whoIsResponsible'] != ""){
            $whoIsResponsible = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['whoIsResponsible']));
        }
        if (isset($_POST['orderComments']) && $_POST['orderComments'] != ""){
            $orderComments = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['orderComments']));
        }
    }

    if(isset($_POST['sent'])) {
        $query = "INSERT INTO vanporman_orders (customerName, 
                                                orderDate, orderAmount, 
                                                priceOfItem, sumOfOrder, 
                                                sizeOfPack, orderStatus, 
                                                whoIsResponsible, orderComments) 
                                                VALUES('$customerName', '$orderDate', 
                                                '$orderAmount', '$priceOfItem', '$sumOfOrder', 
                                                '$sizeOfPack', '$orderStatus', '$whoIsResponsible', 
                                                '$orderComments')";

        $result = mysqli_query($connection, $query) or die("$query - " . mysqli_error($connection));

        $row_id = mysqli_insert_id($connection);

        if (isset($row_id)){
            $confirm = " - tellimus on lisatud!";
        }

        mysqli_close($connection);
    }

    include_once ('views/orders.html');
}

//otsitakse tellimusi, mida siis hiljem myykideks muuta
function sale(){

    global $connection;

    $changeOrders = array();
    $cN = '';
    $dR = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['customerName']) && $_POST['customerName'] != "") {
            $cN = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['customerName']));
        }
        if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
            $dR = htmlspecialchars($_POST['daterange']);
        }
    }

    if (!empty($cN) && empty($dR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
    } elseif (!empty($dR) && empty($cN)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
    } else {
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
    }

    $result = mysqli_query($connection, $query);
    //kui on mitu samanimega või samal kuupäeval, siis võetakse viimane
    $value = mysqli_fetch_assoc($result);

    mysqli_close($connection);

    include_once('views/sales.html');
}

//tellimuse staatuse muutmine myygiks
function makeSale(){

    global $connection;

    $id = '';
    $sD = '';
    $sOO = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id']) && $_POST['id'] != ''){
            $id = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['id']));
        }
        if (isset($_POST['singledate']) && $_POST['singledate'] != ""){
            $sD = htmlspecialchars($_POST['singledate']);
        }
        if (isset($_POST['statusOfOrder']) && $_POST['statusOfOrder'] != ""){
            $sOO = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['statusOfOrder']));
        } else {
            $query1 = "SELECT orderStatus FROM vanporman_orders WHERE orderID = '$id'";
            $result1 = mysqli_query($connection, $query1);
            $value1 = mysqli_fetch_assoc($result1);
            $sOO = $value1['orderStatus'];
        }
    }

    $query = "UPDATE vanporman_orders SET saleDate = '$sD', orderStatus = '$sOO' WHERE orderID = '$id'";

    $result = mysqli_query($connection, $query);

    if ($result){
        $ourSales = array();

        $query = "SELECT * FROM vanporman_orders WHERE orderID = '$id'";
        $result = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($result)){
            $ourSales[] = $row;
        };
    }

    mysqli_close($connection);

    include_once ('views/sales.html');
}

//demo pakkide sisestamine ja kuvamine
function demos(){
    global $connection;

    $ourDemos = array();

    $demoClient = '';
    $demoDate = '';
    $demoAmount = '';
    $demoPackSize = '';
    $demoComments = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['demoClient']) && $_POST['demoClient'] != ""){
            $demoClient = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['demoClient']));
        }
        if (isset($_POST['singledate']) && $_POST['singledate'] != ""){
            $demoDate = htmlspecialchars($_POST['singledate']);
        }
        if (isset($_POST['demoAmount']) && $_POST['demoAmount'] != ""){
            $demoAmount = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['demoAmount']));
        }
        if (isset($_POST['demoPackSize']) && $_POST['demoPackSize'] != ""){
            $demoPackSize = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['demoPackSize']));
        }
        if (isset($_POST['demoComments']) && $_POST['demoComments'] != ""){
            $demoComments = htmlspecialchars(mysqli_real_escape_string($connection, $_POST['demoComments']));
        }
    }

    if(isset($_POST['sent'])) {
        $query = "INSERT INTO vanporman_demopacks (demoClient, 
                                                demoDate, demoAmount, 
                                                demoPackSize, demoComments) 
                                                VALUES('$demoClient', '$demoDate', 
                                                '$demoAmount', '$demoPackSize', 
                                                '$demoComments')";

        $result = mysqli_query($connection, $query) or die("$query - " . mysqli_error($connection));

        $row_id = mysqli_insert_id($connection);

        if (isset($row_id)){
            $confirm = " - demo pakid lisatud!";
        }
    }

    $query_demos = "SELECT * FROM vanporman_demopacks ORDER BY demoID DESC LIMIT 100";
    $result_demos = mysqli_query($connection, $query_demos) or die("$query_demos - " . mysqli_error($connection));
    while ($row = mysqli_fetch_assoc($result_demos)){
        $ourDemos[]=$row;
    }

    mysqli_close($connection);

    include_once ('views/demos.html');
}
