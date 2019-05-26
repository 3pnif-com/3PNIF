<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
    <?php include('common/functions.php');
          include('common/header.php');
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" style="margin-left:270px;margin-top:43px;">
  <?php showPageTitle('Internet','fa-cloud'); ?>

  <div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
      <div class="w3-container w3-white w3-card-4 w3-padding-16">
        <div class="w3-row-padding" style="padding-left: 40px; padding-right: 150px;">
          
	      	<?php
            $output = shell_exec("tools\whois.exe " . CONECTION_TEST . " -nobanner");
            $output = preg_split("#[\r\n]+#", $output);

            if(count($output) > 2) {
              echo '<i id="icon'.$file.'"class="fa fa-cloud-upload fa-fw fa-2x"style="color:green"></i> <strong>OK!</strong> Internet is up! You can use tools that need Internet.';
            } else {
              echo '<i id="icon'.$file.'"class="fa fa-cloud-download fa-fw fa-2x"style="color:red"></i> <strong>Attention!</strong> Internet is down! You can\'t use tools that need Internet.';
            }
            showSubTitle('Connection test (example with "' . CONECTION_TEST . '", you can change in Settings):'); ?>
            <div>
              <table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
                <?php
                echo "<tbody>";
                  echo "<tr>";
                    echo "<td>";
                    for ($i = 0; $i < count($output) - 1; $i++) {
                      $output[$i] = utf8_encode($output[$i]); 
                      echo $output[$i] . "<br>"; 
                    }
                    echo "</td>";
                  echo "</tr>";
                echo "</tbody>"; ?>
              </table>
            </div>
        
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
