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

      $(function(){
          $('input[name="saleDate"]').daterangepicker({
              singleDatePicker: true,
              showDropdowns: true,
              locale: {
                  format: 'YYYY-MM-DD'
              }
          });
      });

    </script>
    <meta charset="UTF-8">
    <title>Müügid</title>
  </head>
  <body>
      <nav class="navbar-default">
          <div class="container-fluid">
              <div class="navbar-header">
                  <a class="navbar-brand" href="sales.php">Kuuku müügid</a>
              </div>
              <ul class="nav navbar-nav">
                  <li><a href="orders.html">Tellimused</a></li>
                  <li><a href="dashboard.php">Kuuku ülevaade</a></li>
                  <li><a href="demos.html">Demod</a></li>
                  <!--<li><a href="cashbox.html">Kassa</a></li>-->
              </ul>
          </div>
      </nav>
      
      <div class="container-fluid">
          <h4>Müükide vormistamine</h4>
          <div class="row">
              <div class="col-md-1"></div>
              <div id="sales-query" class="col-md-10" style="background-color:#f2f2f2;">
                  <h3>Müügid</h3>
                  <form action="" method="post" class="form-inline">
                      <div class="form-group">
                          <label for="cN">Kliendi nimi:</label>
                          <input type="text" class="form-control" name="customerName" id="cN">
                      </div>
                      <div class="form-group has-feedback">
                          <label for="oD">Tellimuse kuupäev:</label>
                          <input type="text" class="form-control" id="oD" name="daterange" placeholder="kas kuupäev või vahemik">
                          <i class="glyphicon glyphicon-calendar form-control-feedback"></i>
                      </div>
<!--                      <div class="form-group">-->
<!--                          <input type="hidden" name="orderStatus" value="orderStatus">-->
<!--                      </div>-->
                      <div class="form-group">
                          <button type="submit" class="btn">Otsi</button>
                      </div>
                  </form>
              </div>
              <div class="col-md-1"></div>
          </div>
      </div>
      <hr>
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-1"></div>
              <div id="sales-query-result" class="col-md-10">
                  <?php
                    $host = "localhost";
                    $user = "test";
                    $pass = "t3st3r123";
                    $db = "test";

                    $oID = '';
                    $cN = '';
                    $dR = '';

                    $sD = '';
                    $oS = '';

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['customerName']) && $_POST['customerName'] != "") {
                            $cN = htmlspecialchars($_POST['customerName']);
                        }
                        if (isset($_POST['daterange']) && $_POST['daterange'] != "") {
                            $dR = htmlspecialchars($_POST['daterange']);
                        }
                    }

                    $connection = mysqli_connect($host, $user, $pass, $db);

                    if (!empty($cN) && empty($dR)){
                        $query = "SELECT * FROM vanporman_orders
                                  WHERE customerName = '$cN'
                                  AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
                    } else if (!empty($dR) && empty($cN)){
                        $query = "SELECT * FROM vanporman_orders
                                  WHERE orderDate BETWEEN '$dR'
                                  AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
                    } else if (!empty($cN) && !empty($dR)){
                        $query = "SELECT * FROM vanporman_orders
                                  WHERE customerName = '$cN'
                                  AND orderDate BETWEEN '$dR'
                                  AND orderStatus IN ('Jaeootel', 'Hulgiootel')";
//                    } else if (empty($cN) && empty($dR)) {
//                        $query = "SELECT * FROM vanporman_orders
//                                  WHERE customerName = '$cN'
//                                  OR orderDate BETWEEN '$dR'";
                    } else {
                        echo "<p>tyhjus</p>";
                    }

                    if (isset($_POST['customerName']) || isset($_POST['daterange'])  ){
                        echo $query;
                        if ($result = mysqli_query($connection, $query) or die("$query - ".mysqli_error($connection))){
                            while ($row=mysqli_fetch_assoc($result)){
                                echo "<form action='' method='post' class='form-inline'>
                                    <div class='form-group'>
                                        <label for='oID'>OrderID:</label>
                                        <p>".$row['orderID']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='cN'>Client:</label>
                                        <p>".$row['customerName']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='oD'>DateOfOrder:</label>
                                        <p>".$row['orderDate']."</p>
                                    </div>
                                    |
                                    <div class='form-group has-feedback'>
                                        <label for='sD'>DateOfSale:</label>
                                        <p><input type='text' class='form-control' id='oD' name='saleDate'></p>
                                        <i class='glyphicon glyphicon-calendar form-control-feedback'></i>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='aM'>OrderAmount:</label>
                                        <p>".$row['orderAmount']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='pOI'>PriceOfItem:</label>
                                        <p>".$row['priceOfItem']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='sOF'>SumOfOrder:</label>
                                        <p>".$row['sumOfOrder']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='sOP'>SizeOfPack:</label>
                                        <p>".$row['sizeOfPack']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='oS'>OrderStatus:</label>
                                        <p><select class='form-control' id='oS' name='orderStatus'><br>
                                            <option value=''>".$row['orderStatus']."</option>
                                            <option value='Jaemüük'>Jaemüük</option>
                                            <option value='Hulgimüük'>Hulgimüük</option>
                                        </select></p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='wIR'>WhoIsResponsible:</label>
                                        <p>".$row['whoIsResponsible']."</p>
                                    </div>
                                    |
                                    <div class='form-group'>
                                        <label for='oC'>Comments:</label>
                                        <p>".$row['orderComments']."</p>
                                    </div>
                                    <div class='form-group'>
                                        <input type='submit' class='btn btn-danger' value='Muuda!'>
                                    </div>
                                </form>";
                            }
                            mysqli_free_result($result);
                        }
                    }
                    mysqli_close($connection);

                    $connection2 = mysqli_connect($host, $user, $pass, $db);

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (isset($_POST['saleDate']) && $_POST['saleDate'] != "") {
                        $sD = htmlspecialchars($_POST['saleDate']);
                        }
                        if (isset($_POST['orderStatus']) && $_POST['orderStatus'] != "") {
                        $oS = htmlspecialchars($_POST['orderStatus']);
                        }
                    }

                    //WHERE saleDate = unikaalne ID!!! see tuleb genereerida
                    $query2 = "UPDATE vanporman_orders SET saleDate = '$sD' WHERE saleDate = '0000-00-00'";

                    $result2 = mysqli_query($connection2, $query2) or die("$query2 - ".mysqli_error($connection2));

                    mysqli_close($connection2);

                    ?>
      </div>
      <hr>

    </div>  
      
  </body>
</html>