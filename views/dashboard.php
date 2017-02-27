<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="../node_modules/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="../node_modules/daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript">
        $(function() {
            $('input[name="daterange"]').daterangepicker();
        });
    </script>
    <meta charset="UTF-8">
    <title>Dashboard</title>
  </head>
  <body>
      <nav class="navbar-default">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a class="navbar-brand" href="#">Kuuku ülevaade</a>
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
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
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
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <h3>Tellimused</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client SUM</th>
                            <th>Amount SUM</th>
                            <th>Order SUM</th>
                            <th>Value SUM</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SUM of Clients</td>
                            <td>SUM of Packs</td>
                            <td>Total of Orders</td>
                            <td>Total Value</td>
                        </tr>
                    </tbody>
                </table>
                <?php
                $host = "localhost";
                $user = "test";
                $pass = "t3st3r123";
                $db = "test";

                $connection = mysqli_connect($host, $user, $pass, $db);
                $query = "SELECT * FROM vanporman_orders WHERE orderStatus = 'Ootel'";
                $result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection));
                //$row = mysqli_fetch_assoc($result);
                echo "<table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Price</th>
                            <th>Responsible</th>
                            <th>Status</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row = $result -> fetch_assoc()){
                    echo "<tr>
                            <td>". $row["orderID"]."</td>
                            <td>". $row["customerName"]."</td>
                            <td>". $row["orderDate"]."</td>
                            <td>". $row["orderAmount"]."</td>
                            <td>". $row["priceOfItem"]."</td>
                            <td>". $row["whoIsResponsible"]."</td>
                            <td>". $row["orderStatus"]."</td>
                            <td>". $row["orderComments"]."</td>
                        </tr>";
                }
                echo "</tbody>
                      </table>";
                mysqli_close($connection);
                ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>  
  
  </body>
</html>