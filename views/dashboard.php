<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="../node_modules/bootstrap-daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="../node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <meta charset="UTF-8">
    <title>Dashboard</title>
  </head>
  <body>
      <nav class="navbar-default">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a class="navbar-brand" href="dashboard.php">Kuuku ülevaade</a>
              </div>
              <ul class="nav navbar-nav">
                  <li><a href="orders.html">Tellimused</a></li>
                  <li><a href="sales.html">Müügid</a></li>
                  <li><a href="demos.html">Demod</a></li>
                  <li><a href="cashbox.html">Kassa</a></li>
              </ul>
          </div>
      </nav>
      
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <td>Pakke kokku</td>
                            <td>234</td>
                        </tr>
                        <tr>
                            <td>Müüdud kokku</td>
                            <td>160</td>
                        </tr>
                        <tr>
                            <td>Ootel tellimusi</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>Demoks pakke</td>
                            <td>25</td>
                        </tr>
                      </tbody>
                  </table>
              </div>
              <div class="col-md-6">
                  <table class="table">
                      <tbody>
                        <tr>
                            <td>Tulud</td>
                            <td>234</td>
                        </tr>
                        <tr>
                            <td>Kulud</td>
                            <td>160</td>
                        </tr>
                        <tr>
                            <td>Kassa</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>&nbsp</td>
                            <td>&nbsp</td>
                        </tr>
                      </tbody>
                  </table>
              </div>      
          </div>
      </div>
      
      <hr>
      
     <div id="query-forms" class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div id="query-container" class="container">
                    <h4>Tellimused</h4>
                    <form action="../php_scripts/showPendingOrders.php" method="post" name="pendingOrders">
                        <div class="form-group">
                            <label for="customer">Klient:</label>
                            <input type="text" class="form-control" id="customer">
                        </div>
                        <p>OR</p>
                        <div class="form-group has-feedback">
                            <label for="customer">Kuupäeva vahemik:</label>
                            <input type="text" class="form-control" id="customer" name="daterange">
                            <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="customer" value="Ootel">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Saada päring</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div id="query-container" class="container">

                    <h4>Müügid</h4>
                    <form>
                        <div class="form-group">
                            <label for="customer">Klient:</label>
                            <input type="text" class="form-control" id="customer">
                        </div>
                        <p>OR</p>
                        <div class="form-group">
                            <label for="customer">Kuupäeva vahemik:</label>
                            <input type="text" class="form-control" id="customer" name="daterange">
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="customer"  value="Müüdud">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Saada päring</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div id="query-container" class="container">
                    <h4>Demod</h4>
                    <form>
                        <div class="form-group">
                            <label for="customer">Klient:</label>
                            <input type="text" class="form-control" id="customer">
                        </div>
                        <p>OR</p>
                        <div class="form-group">
                            <label for="customer">Kuupäeva vahemik:</label>
                            <input type="text" class="form-control" id="customer" name="daterange">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn">Saada päring</button>
                        </div>
                    </form>
                </div>
            </div>
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

                $connection = mysqli_connect($host, $user, $pass, $db);
                $query_sum = "SELECT COUNT(customerName) AS KlienteKokku,
                              SUM(orderAmount) AS TellimusiKokku,
                              COUNT(orderStatus) AS OotelTellimusi,
                              SUM(sumOfOrder) AS SummaKokku
                              FROM vanporman_orders";
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

                $query = "SELECT * FROM vanporman_orders";
                $result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
                //$row = mysqli_fetch_assoc($result);
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