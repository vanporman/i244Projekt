<?php
    $host = "localhost";
    $user = "test";
    $pass = "t3st3r123";
    $db = "test";

    $connection = mysqli_connect($host, $user, $pass, $db);

//    $orderID = $_POST['orderID'];
    $customerName = $_POST['customerName'];
    $orderDate = $_POST['orderDate'];
//    $saleDate = $_POST['saleDate'];
    $orderAmount = $_POST['orderAmount'];
    $priceOfItem = $_POST['priceOfItem'];
    $sumOfOrder = $_POST['sumOfOrder'];
    $sizeOfPack = $_POST['sizeOfPack'];
    $orderStatus = $_POST['orderStatus'];
    $whoIsResponsible = $_POST['whoIsResponsible'];
    $orderComments = $_POST['orderComments'];

    $query = "INSERT INTO vanporman_orders "."(customerName, orderDate, orderAmount, priceOfItem, sumOfOrder, sizeOfPack, orderStatus, whoIsResponsible, 
    orderComments) "."VALUES('$customerName', '$orderDate', '$orderAmount', '$priceOfItem', '$sumOfOrder', '$sizeOfPack', '$orderStatus',
    '$whoIsResponsible', '$orderComments')";

    //mysqli_select_db('test');
    $result = mysqli_query($connection, $query) or die("$query - " . mysqli_error($connection));
    mysqli_close($connection);

    header('Location: ../views/orders.html');
    exit;
?>