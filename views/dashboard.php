<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="../node_modules/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="../node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="../scripts/scripts.js"></script>
    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                },

            });

            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD\'') + ' AND ' + picker.endDate.format('\'YYYY-MM-DD'));
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body onload="showRetailHistory(); showWholesaleHistory(); showFairsaleHistory();">
<nav class="navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="dashboard.php">Kuuku ülevaade</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="orders.html">Tellimused</a></li>
            <li><a href="sales.php">Müügid</a></li>
            <li><a href="demos.html">Demod</a></li>
            <!--            <li><a href="cashbox.html">Kassa</a></li>-->
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <table class="table table-sm">
                <tbody>
                <tr>
                    <td>Pakke tehtud kokku:</td>
                    <td id="sumOfProduct"></td>
                </tr>
                <tr>
                    <td>Pakke müüdud kokku:</td>
                    <td id="sumOfSales"></td>
                </tr>
                <tr>
                    <td>Jaemüügid:</td>
                    <td  id="retailSale"></td>
                </tr>
                <tr>
                    <td>Hulgimüügid:</td>
                    <td id="wholeSale"></td>
                </tr>
                <tr>
                    <td>Laadamüügid:</td>
                    <td id="fairSale"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table table-sm">
                <tbody>
                <tr>
                    <td>Ootel tellmusi:</td>
                    <td id="ordersInLine"></td>
                </tr>
                <tr>
                    <td>Jaetellmused:</td>
                    <td id="orderRetail"></td>
                </tr>
                <tr>
                    <td>Hulgitellimused</td>
                    <td id="orderWholesale"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table table-sm">
                <tbody>
                <tr>
                    <td>Demoks pakke:</td>
                    <td id="demoPacks"></td>
                </tr>
                <tr>
                    <td>Pakke laos:</td>
                    <td id="productInStock"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<hr>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form action="" method="post" class="form-inline">
                <div class="form-group">
                    <label for="cn">Kliendi nimi:</label>
                    <input type="text" class="form-control" name="customerName" id="cn">
                </div>
                <div class="form-group has-feedback">
                    <label for="od">Tellimuste kuupäev:</label>
                    <input type="text" class="form-control" id="od" name="daterange" placeholder="kas kuupäev või vahemik">
                    <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                </div>
                <div class="form-group">
                    <label for="wir">Kes tegeles:</label>
                    <select class="form-control" name="whoIsResponsible" id="wir">
                        <option value=""></option>
                        <option value="Kiik">Kiik</option>
                        <option value="Mikk">Mikk</option>
                        <option value="Porman">Porman</option>
                        <option value="Vahur">Vahur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="os">Staatus</label>
                    <select class="form-control" id="os" name="orderStatus">
                        <option value=""></option>
                        <option value="Jaeootel">Jaeootel</option>
                        <option value="Hulgiootel">Hulgiootel</option>
                        <option value="Jaemüük">Jaemüük</option>
                        <option value="Hulgimüük">Hulgimüük</option>
                        <option value="Üritustemüük">Üritustemüük</option>
                        <option value="Demopakk">Demopakk</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-info" value="Saada päring">
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<hr>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-1'></div>
        <div class='col-md-10'>

            <?php
            $host = "localhost";
            $user = "test";
            $pass = "t3st3r123";
            $db = "test";

            $cN = '';
            $aO = '';
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

            $connection = mysqli_connect($host, $user, $pass, $db);

            if (!empty($cN || $dR || $wIR)){
                $query_sum = "SELECT COUNT(customerName) AS KlienteKokku,
                              SUM(orderAmount) AS TellimusiKokku,
                              COUNT(orderStatus) AS OotelTellimusi,
                              SUM(sumOfOrder) AS SummaKokku
                              FROM vanporman_orders
                              WHERE customerName = '$cN'
                              OR $aO orderDate = '$dR'
                              OR $aO whoIsResponsible = '$wIR'";
                $result = mysqli_query($connection, $query_sum) or die("$query_sum - ".mysqli_error($connection));
                echo "<table class='table'>
                        <thead>
                            <tr>
                                <th class='text-center'>SumOfClients</th>
                                <th class='text-center'>AmountOfOrders</th>
                                <th class='text-center'>SumOfOrders</th>
                                <th class='text-center'>SumOfValues</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result -> fetch_assoc()){
                    echo "<tr>
                            <td class='text-center'>". $row['KlienteKokku']."</td>
                            <td class='text-center'>". $row['TellimusiKokku']."</td>
                            <td class='text-center'>". $row['OotelTellimusi']."</td>
                            <td class='text-center'>". $row['SummaKokku']."</td>
                        </tr>";
                }
                echo "</tbody>
                      </table>";

            }

            //yhekaupa
            if (!empty($cN) && empty($dR) && empty($wIR) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'";
            } elseif (!empty($dR) && empty($cN) && empty($wIR) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
                          WHERE orderDate BETWEEN '$dR'";
            } elseif (!empty($wIR) && empty($cN) && empty($dR) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
                          WHERE whoIsResponsible = '$wIR'";
            } elseif (!empty($oS) && empty($cN) && empty($dR) && empty($wIR)){
                $query = "SELECT * FROM vanporman_orders
                          WHERE orderStatus = '$oS'";
            }
            //kahekaupa customerName-iga
            elseif (!empty($cN) && !empty($dR) && empty($wIR) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'
			              AND orderDate BETWEEN '$dR'";
            } elseif (!empty($cN) && !empty($wIR) && empty($dR) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'
			              AND whoIsResponsible = '$wIR'";
            } elseif (!empty($cN) && !empty($oS) && empty($dR) && empty($wIR)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'
			              AND orderStatus = '$oS'";
            }
            //kahekaupa orderDate-iga
            elseif (!empty($dR) && !empty($wIR) && empty($cN) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE orderDate BETWEEN '$dR'
			              AND whoIsResponsible = '$wIR'";
            } elseif (!empty($dR) && !empty($oS) && empty($cN) && empty($wIR)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE orderDate BETWEEN '$dR'
			              AND orderStatus = '$oS'";
            }
            //kahekaupa whoIsResponsible-ga
            elseif (!empty($wIR) && !empty($oS) && empty($cN) && empty($dR)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE whoIsResponsible = '$wIR'
			              AND orderStatus = '$oS'";
            }
            //kolmekaupa customerName-iga
            elseif (!empty($cN) && !empty($dR) && !empty($wIR) && empty($oS)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'
			              AND orderDate BETWEEN '$dR'
			              AND whoIsResponsible = '$wIR'";
            } elseif (!empty($cN) && !empty($dR) && !empty($oS) && empty($wIR)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'
			              AND orderDate BETWEEN '$dR'
			              AND orderStatus = '$oS'";
            } elseif (!empty($cN) && !empty($wIR) && !empty($oS) && empty($dR)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE customerName = '$cN'
			              AND whoIsResponsible '$wIR'
			              AND orderStatus = '$oS'";
            }
            //kolmekaupa orderDate-iga
            elseif (!empty($dR) && !empty($wIR) && !empty($oS) && empty($cN)){
                $query = "SELECT * FROM vanporman_orders
			              WHERE orderDate BETWEEN '$dR'
			              AND whoIsResponsible = '$wIR'
			              AND orderStatus = '$oS'";
            }
            //v6i p2ring
            elseif (!empty($cN || $dR || $wIR || $oS)){
                $query = "SELECT * FROM vanporman_orders 
                          WHERE customerName = '$cN'
                          OR orderDate BETWEEN '$dR'
                          OR whoIsResponsible = '$wIR'
                          OR orderStatus = '$oS'";
            }
            //k6ik
            else {
                $query = "SELECT * FROM vanporman_orders";
            }

            $result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));

            echo $query;

            echo "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Client</th>
                            <th>DateofOrder</th>
                            <th>DateofSale</th>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Sum</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Responsible</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>";
            while ($row = $result -> fetch_assoc()){
                echo "<tr>
                            <td>". $row['orderID']."</td>
                            <td>". $row['customerName']."</td>
                            <td>". $row['orderDate']."</td>
                            <td>". $row['saleDate']."</td>
                            <td>". $row['orderAmount']."</td>
                            <td>". $row['priceOfItem']."</td>
                            <td>". $row['sumOfOrder']."</td>
                            <td>". $row['sizeOfPack']."</td>
                            <td>". $row['orderStatus']."</td>
                            <td>". $row['whoIsResponsible']."</td>
                            <td>". $row['orderComments']."</td>
                        </tr>";
            }
            echo "</tbody>
                      </table>";
            mysqli_close($connection);
            ?>
            <span></span>
        </div>
        <div class='col-md-1'></div>
    </div>
</div>

</body>
</html>