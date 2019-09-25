<?php 
  require_once 'config/header.php'; 
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["addItem"])) {
      $item = htmlentities(trim($_POST["item"]), ENT_QUOTES, "UTF-8");
      $amount = htmlentities(trim($_POST["amount"]), ENT_QUOTES, "UTF-8");
      $date = date("D M Y H:i:s");
      $description = htmlentities(trim($_POST["description"]), ENT_QUOTES, "UTF-8");

      if (empty($item) || empty($amount) || empty($date) || empty($description)) {
        $err = "Fill the form";
      }else{
        
        $insert = $mysqli->prepare("INSERT INTO transaction(item, amount, description, date) VALUES(?,?,?,?)");
        $insert->bind_param("ssss", $item, $amount, $description, $date);
        $insert->execute();

        if ($insert->affected_rows > 0) {
          
            $success = "Item added successfully";
          
        }else{
          die($insert->error);
        }
      }
    }
  }
?>

<body>
  <div class="wrapper">
    
    <!-- Require Side Bar Script -->
    <?php require_once 'config/sidebar.php'; ?>
    <!-- End of Side Bar Script-->

    <div class="main-panel">
      
      <!-- Navbar -->
      <?php require_once 'config/top_nav.php'; ?>
      <!-- End Navbar -->

      <div class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <p class="card-category">Transactions</p>
                </div>
                <div class="card-body">
                  <?php 
                        if (isset($err)) { ?>
                          <h5 style="color: red;"><?php echo $err; ?></h5>
                        <?php }else if(isset($success)){ ?>
                          <h5 style="color: green;"><?php echo $success; ?></h5>
                        <?php }
                      ?>
                      <form method="POST">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating">Item</label>
                              <input type="text" class="form-control" name="item">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating">Amount</label>
                              <input type="text" class="form-control" name="amount">
                            </div>
                          </div>
                        
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="bmd-label-floating">Date</label>
                              <input type="date" class="form-control" name="date">
                            </div>
                          </div>
                          
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="bmd-label-floating">Description</label>
                              <input type="text" class="form-control" name="description">
                            </div>
                          </div>
                          
                        </div>
                        
                        <button type="submit" name="addItem" class="btn btn-primary pull-right">Add Item</button>
                        <div class="clearfix"></div>
                      </form>
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <div class="col-xl-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <p class="card-category">Transactions</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date Added</th>
                      </thead>
                      <tbody>
                        <?php 
                          $result = getTransaction($mysqli);

                          if ($result->num_rows > 0) {
                            while ($rows = $result->fetch_assoc()) { ?>
                              <tr>
                                <td><?php echo $rows["item"]; ?></td>
                                <td><?php echo $rows["amount"]; ?></td>
                                <td><?php echo $rows["description"]; ?></td>
                                <td><?php echo $rows["date"]; ?></td>
                              </tr>      
                            <?php }
                          }else{ ?>
                            <tr>
                              <td colspan="10" style="text-align: center;">No staff yet!</td>
                            </tr>
                          <?php }
                        ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
          
        </div>
      </div>
<?php require_once 'config/footer.php'; ?>