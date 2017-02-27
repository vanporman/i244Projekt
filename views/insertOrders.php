<?php
    $host = "localhost";
    $user = "test";
    $pass = "t3st3r123";
    $db = "test";

    $connection = mysqli_connect($host, $user, $pass, $db);

    //$orderID = $_POST['orderID'];
    $customerName = $_POST['customerName'];
    $orderDate = $_POST['orderDate'];
    $orderAmount = $_POST['orderAmount'];
    $priceOfItem = $_POST['priceOfItem'];
    $whoIsResponsible = $_POST['whoIsResponsible'];
    $orderStatus = $_POST['orderStatus'];
    $orderComments = $_POST['orderComments'];

    $query = "INSERT INTO vanporman_orders "."(customerName, orderDate, orderAmount, priceOfItem, whoIsResponsible, orderStatus, 
    orderComments) "."VALUES('$customerName', '$orderDate', '$orderAmount', '$priceOfItem', '$whoIsResponsible', '$orderStatus', '$orderComments')";

    //mysqli_select_db('test');
    $result = mysqli_query($connection, $query) or die("$query - " . mysqli_error($connection));
    mysqli_close($connection);

    header('Location: orders.html');
    exit;
?>