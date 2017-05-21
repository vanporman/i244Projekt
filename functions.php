<?php

function connect_db(){
    global $connection;
    $host="localhost";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
//    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
    global $connection;
    $errors = array();
    $usr = '';
    //kasutaja on 'kuuku' või 'i244Test'
    $psw = '';
    //parool on 'Nufbiq19' või 'i244Projekt'
    $rol = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['username']) && $_POST['username'] != ''){
            $usr = mysqli_real_escape_string($connection, $_POST['username']);
        } else {
            $errors[] = "Kasutajanimi on puudu!";
        }
        if (isset($_POST['password']) && $_POST['password'] != ''){
            $psw = mysqli_real_escape_string($connection, $_POST['password']);
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

    if ($count == 1){
        $_SESSION['user'] = $usr;
        $_SESSION['role'] = $rol;
        header("Location: ?page=dashboard");
        //kui kasutaja on puudu, siis annab mõlemat veateadet(kasutaja puudu ja vale kasutaja või parool)
    }
    elseif ($count == 1 && $row['usr'] != $usr || $row['psw'] != $psw) {
        $errors[] = "Vale kasutaja või parool!";
    }

    include_once('views/login.html');
}

function logout(){
    $_SESSION=array();
    session_destroy();
    header("Location: ?");
}

function showOrders(){

    global $connection;

    $ourOrders = array();
    $cN = '';
    $dR = '';
    $wIR = '';
    $oS = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST['customerName']) && $_POST['customerName'] != ""){
            $cN = htmlspecialchars($_POST['customerName']);
        }
        if (isset($_POST['daterange']) && $_POST['daterange'] != ""){
            $dR = htmlspecialchars($_POST['daterange']);
        }
        if (isset($_POST['whoIsResponsible']) && $_POST['whoIsResponsible'] != ""){
            $wIR = htmlspecialchars($_POST['whoIsResponsible']);
        }
        if (isset($_POST['orderStatus']) && $_POST['orderStatus'] != ""){
            $oS = htmlspecialchars($_POST['orderStatus']);
        }
    }

    //yhekaupa
    if (!empty($cN) && empty($dR) && empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN'";
    } elseif (!empty($dR) && empty($cN) && empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR'";
    } elseif (!empty($wIR) && empty($cN) && empty($dR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE whoIsResponsible = '$wIR'";
    } elseif (!empty($oS) && empty($cN) && empty($dR) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE orderStatus = '$oS'";
    }
    //kahekaupa customerName-iga
    elseif (!empty($cN) && !empty($dR) && empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR'";
    } elseif (!empty($cN) && !empty($wIR) && empty($dR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND whoIsResponsible = '$wIR'";
    } elseif (!empty($cN) && !empty($oS) && empty($dR) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderStatus = '$oS'";
    }
    //kahekaupa orderDate-iga
    elseif (!empty($dR) && !empty($wIR) && empty($cN) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR'";
    } elseif (!empty($dR) && !empty($oS) && empty($cN) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND orderStatus = '$oS'";
    }
    //kahekaupa whoIsResponsible-ga
    elseif (!empty($wIR) && !empty($oS) && empty($cN) && empty($dR)){
        $query = "SELECT * FROM vanporman_orders WHERE whoIsResponsible = '$wIR' AND orderStatus = '$oS'";
    }
    //kolmekaupa customerName-iga
    elseif (!empty($cN) && !empty($dR) && !empty($wIR) && empty($oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR'";
    } elseif (!empty($cN) && !empty($dR) && !empty($oS) && empty($wIR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND orderStatus = '$oS'";
    } elseif (!empty($cN) && !empty($wIR) && !empty($oS) && empty($dR)){
        $query = "SELECT * FROM vanporman_orders  WHERE customerName = '$cN' AND whoIsResponsible '$wIR' AND orderStatus = '$oS'";
    }
    //kolmekaupa orderDate-iga
    elseif (!empty($dR) && !empty($wIR) && !empty($oS) && empty($cN)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND whoIsResponsible = '$wIR' AND orderStatus = '$oS'";
    }
    //v6i p2ring
    elseif (!empty($cN || $dR || $wIR || $oS)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' OR orderDate BETWEEN '$dR' OR whoIsResponsible = '$wIR' OR orderStatus = '$oS'";
    }
    //k6ik
    else {
        $query = "SELECT * FROM vanporman_orders";
    }

    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)){
        $ourOrders[] = $row;
    };

    include_once ('views/dashboard.html');
}

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
            $customerName = htmlspecialchars($_POST['customerName']);
        }
        if (isset($_POST['orderDate']) && $_POST['orderDate'] != ""){
            $orderDate = htmlspecialchars($_POST['orderDate']);
        }
        if (isset($_POST['orderAmount']) && $_POST['orderAmount'] != ""){
            $orderAmount = htmlspecialchars($_POST['orderAmount']);
        }
        if (isset($_POST['priceOfItem']) && $_POST['priceOfItem'] != ""){
            $priceOfItem = htmlspecialchars($_POST['priceOfItem']);
        }
        if (isset($_POST['sumOfOrder']) && $_POST['sumOfOrder'] != ""){
            $sumOfOrder = htmlspecialchars($_POST['sumOfOrder']);
        }
        if (isset($_POST['sizeOfPack']) && $_POST['sizeOfPack'] != ""){
            $sizeOfPack = htmlspecialchars($_POST['sizeOfPack']);
        }
        if (isset($_POST['orderStatus']) && $_POST['orderStatus'] != ""){
            $orderStatus = htmlspecialchars($_POST['orderStatus']);
        }
        if (isset($_POST['whoIsResponsible']) && $_POST['whoIsResponsible'] != ""){
            $whoIsResponsible = htmlspecialchars($_POST['whoIsResponsible']);
        }
        if (isset($_POST['orderComments']) && $_POST['orderComments'] != ""){
            $orderComments = htmlspecialchars($_POST['orderComments']);
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
        mysqli_close($connection);
    }

    include_once ('views/orders.html');
}

function sale(){

    global $connection;

    $changeOrders = array();
    $cN = '';
    $dR = '';
    $query = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['customerName']) && $_POST['customerName'] != "") {
            $cN = htmlspecialchars($_POST['customerName']);
        }
        if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
            $dR = htmlspecialchars($_POST['daterange']);
        }
    }

    if (!empty($cN) && empty($dR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
    } elseif (!empty($dR) && empty($cN)){
        $query = "SELECT * FROM vanporman_orders WHERE orderDate BETWEEN '$dR' AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
    } elseif (!empty($cN) && !empty($dR)){
        $query = "SELECT * FROM vanporman_orders WHERE customerName = '$cN' AND orderDate BETWEEN '$dR' AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
    }

    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)){
        $changeOrders[] = $row;
    };
    include_once('views/sales.html');
}

function makeSale(){

    include_once ('views/sales.html');
}