<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
    <link rel="stylesheet" href="css/style.css">
  </head>
    <?php include('common/functions.php');
          include('common/header.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// CREATE LOG
if ($_POST["action"] == "create") {

  $export = $_POST["export"];
  $creationDate = $_POST["creationDate"];
  $dateFile = str_replace("-", "", $creationDate);
  $dateFile = str_replace(":", "", $dateFile);
  $fileNameExport = "tmp/export_" . $dateFile . ".txt";
  file_put_contents($fileNameExport, $export);

  $sql = "SELECT * FROM history WHERE id = 0";
  $result = $conn->query($sql); 
  $row = $result->fetch_assoc();

  if ($row !="") {
    $sql = "UPDATE history SET last_export = '" . $creationDate . "'";
  } else {
    $sql = "INSERT history (id, last_export) VALUES (0, '" . $creationDate . "')";
  }
  $result = $conn->query($sql);
  
  showToastMessage("History successfully exported!");

  $download = 1;

} // END CREATE LOG
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" style="margin-left:270px;margin-top:43px;">
  <?php showPageTitle('History','fa-history'); ?>

  <div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
      <div class="w3-container w3-white w3-card-4 w3-padding-16">
        <div class="w3-row-padding">

          <?php showSubTitle('Last export:');

          $export = "";

          $sql = "SELECT * FROM history WHERE id = 0";
          $result = $conn->query($sql); 
          $row = $result->fetch_assoc(); ?>

          <!-- LAST EXPORT -->
          <div class="w3-row" style="padding-left: 15px;">
            <?php if ($row !="") {
                echo $row['last_export'];
              } else { echo "Not created."; } ?>
          </div>

          <?php showSubTitle('All content:');

          $export = $export . "\n";
          $creationDate = date('Y-m-d_H:i:s');
          $export = $export . "History created at: " . $creationDate . "\n";
          $export = $export . "\n";
          ?>  
          <!-- TOOLS -->
          <button class="accordion" style="width: 70%;"><p style="margin-top: 15px; display: inherit;"><strong>&nbsp;Tools (<span id="count_tools"></span>)</strong></p></button>
          <div class="panel">
            <br>
            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white" id="table">
              <?php
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $export = $export . "***** TOOLS *****\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $export = $export . "# - Name - Description - Date - System\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $sql = "SELECT date, name, description, reserved FROM tools ORDER BY date DESC";
              $result = $conn->query($sql);
              echo "<thead>";
                echo "<tr>";
                  echo "<th><strong># &nbsp; &nbsp; &nbsp; Name </strong></th>";
                  echo "<th><strong> Description </strong></th>";
                  echo "<th><strong> Date </strong></th>";
                  echo "<th></th>";
                echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                  $export = $export . "$count - " . $row['name'] . " - " . $row['description'] . " - " . $row['date'];
                  echo "<tr>";
                    echo "<td width='20%'><strong>$count</strong> &nbsp; &nbsp; " . $row['name'] . "</td>";
                    echo "<td width='55%'>" . $row['description'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>";
                      if ($row['reserved'] == 1) {
                        $export = $export . " - *\n"; ?>
                        <button class="w3-button" style="cursor: default; overflow: unset;"><i class="tooltip fa fa-cogs"><span class="tooltiptext" style="width: 150px; margin-left: -75px;"><p style="margin: 5px 0;">System Tool</p></span></i></button>
                      <?php } else { $export = $export . "\n"; }   
                    echo "</td>";
                  echo "</tr>";
                  $count++;
                }
              echo "</tbody>";
            echo "</table>"; ?>
            <script type="text/javascript">
              document.getElementById("count_tools").innerHTML = "<?php echo $count-1;?>";
              
            </script>
          
          </div><br>

          <!-- MODELS -->
          <button class="accordion" style="width: 70%;"><p style="margin-top: 15px; display: inherit;"><strong>&nbsp;Models (<span id="count_models"></span>)</strong></p></button>
          <div class="panel">
            <br>
            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white" id="table">
              <?php 
              $export = $export . "\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $export = $export . "***** MODELS *****\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $export = $export . "# - Name - Description - Date - System\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $sql = "SELECT date, name, description, reserved FROM models ORDER BY date DESC";
              $result = $conn->query($sql);
              echo "<thead>";
                echo "<tr>";
                  echo "<th><strong># &nbsp; &nbsp; &nbsp; Name </strong></th>";
                  echo "<th><strong> Description </strong></th>";
                  echo "<th><strong> Date </strong></th>";
                  echo "<th></th>";
                echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                  $export = $export . "$count - " . $row['name'] . " - " . $row['description'] . " - " . $row['date'];
                  echo "<tr>";
                    echo "<td width='20%'><strong>$count</strong> &nbsp; &nbsp; " . $row['name'] . "</td>";
                    echo "<td width='55%'>" . $row['description'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>";
                      if ($row['reserved'] == 1) {
                         $export = $export . " - *\n"; ?>
                        <button class="w3-button" style="cursor: default; overflow: unset;"><i class="tooltip fa fa-cogs"><span class="tooltiptext" style="width: 150px; margin-left: -75px;"><p style="margin: 5px 0;">System Tool</p></span></i></button>
                      <?php } else {  $export = $export . "\n"; }  
                    echo "</td>";
                  echo "</tr>";
                  $count++;
                }
              echo "</tbody>";
            echo "</table>"; ?>
            <script type="text/javascript">
              document.getElementById("count_models").innerHTML = "<?php echo $count-1;?>";
            </script>
          </div><br>

          <!-- PENTESTS -->
          <button class="accordion" style="width: 70%;"><p style="margin-top: 15px; display: inherit;"><strong>&nbsp;Pentests (<span id="count_pentests"></span>)</strong></p></button>
          <div class="panel">
            <br>
            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white" id="table">
              <?php
              $export = $export . "\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $export = $export . "***** PENTESTS *****\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
               $export = $export . "# - Name - Description - Date\n";
               $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $sql = "SELECT date, name, description FROM pentests ORDER BY date DESC";
              $result = $conn->query($sql);
              echo "<thead>";
                echo "<tr>";
                  echo "<th><strong># &nbsp; &nbsp; &nbsp; Name </strong></th>";
                  echo "<th><strong> Description </strong></th>";
                  echo "<th><strong> Date </strong></th>";
                echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                  $export = $export . "$count - " . $row['name'] . " - " . $row['description'] . " - " . $row['date'] . "\n";
                  echo "<tr>";
                    echo "<td width='20%'><strong>$count</strong> &nbsp; &nbsp; " . $row['name'] . "</td>";
                    echo "<td width='55%'>" . $row['description'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";    
                  echo "</tr>";
                  $count++;
                }
              echo "</tbody>";
            echo "</table>"; ?>
            <script type="text/javascript">
              document.getElementById("count_pentests").innerHTML = "<?php echo $count-1;?>";
            </script>
          </div><br>

          <!-- REPORTS -->
          <button class="accordion" style="width: 70%;"><p style="margin-top: 15px; display: inherit;"><strong>&nbsp;Reports (<span id="count_reports"></span>)</strong></p></button>
          <div class="panel">
            <br>
            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white" id="table">
              <?php
              $export = $export . "\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $export = $export . "***** REPORTS *****\n";
              $export = $export . "---------------------------------------------------------------------------------------------------\n";
               $export = $export . "# - File - Date\n";
               $export = $export . "---------------------------------------------------------------------------------------------------\n";
              $sql = "SELECT date, file FROM reports ORDER BY date DESC";
              $result = $conn->query($sql);
              echo "<thead>";
                echo "<tr>";
                  echo "<th><strong># &nbsp; &nbsp; &nbsp; File </strong></th>";
                  echo "<th><strong> Date </strong></th>";
                  echo "<th></th>";
                echo "</tr>";
              echo "</thead>";
              echo "<tbody>";
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                  $export = $export . "$count - " . str_replace("reports/", "", $row['file']) . " - " . $row['date'] . "\n";
                  echo "<tr>";
                    echo "<td width='50%'><strong>$count</strong> &nbsp; &nbsp; " . $row['file'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>";
                      if ($row['reserved'] == 1) { ?>
                        <button class="w3-button" style="cursor: default; overflow: unset;"><i class="tooltip fa fa-cogs"><span class="tooltiptext" style="width: 150px; margin-left: -75px;"><p style="margin: 5px 0;">System Tool</p></span></i></button>
                      <?php }   
                    echo "</td>";
                  echo "</tr>";
                  $count++;
                }
              echo "</tbody>";
            echo "</table>"; ?>
            <script type="text/javascript">
              document.getElementById("count_reports").innerHTML = "<?php echo $count-1;?>";
            </script>
          </div><br>
          <?php
          $export = $export . "\n";
          $export = $export . "---------------------------------------------------------------------------------------------------\n";
          $export = $export . "End of file history.\n";
          ?>

          <form method="post" action="<?php $_PHP_SELF ?>">
            <input type="hidden" name="action" value="create">
            <input type="hidden" name="export" value="<?php echo $export; ?>">
            <input type="hidden" name="creationDate" value="<?php echo $creationDate; ?>">
            <button style="margin-top: 13px;" type="submit" class="w3-btn w3-orange" onclick="document.getElementById('pro').style.display='block';"><i class='fa fa-share-square'></i>Export</button>
          </form>

          <?php if ($download == 1) { ?>
            <a id="download" href="<?php echo $fileNameExport; ?>" download hidden></a>
            <script type="text/javascript">
              document.getElementById('download').click();
            </script>
            <?php $download = 0;
            //unlink($fileNameExport);
          } ?>
            
      </div>
    </div>
  </div>

<script type="text/javascript">
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight){
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      } 
    });
  }
  
</script>

</div>
</body>
</html>