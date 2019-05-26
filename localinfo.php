<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
    <?php include('common/functions.php');
          include('common/header.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" style="margin-left:270px; margin-top:43px;">

  <?php showPageTitle('Local Information','fa-info-circle'); ?>

  <div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
      <div class="">
        <div class="w3-container w3-white w3-card-4 w3-padding-16">

          <?php // LOCAL INTERFACE INFORMATION
          $output = shell_exec($get_local_ips);
          $int_array = preg_split('#[\r\n]+#', trim($output)); ?>
          <div>
            <?php showSubTitle('Local interface(s):'); ?>
            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
              <?php for ($i = 0; $i < count($int_array); $i++) {
                if (preg_match('/\badapter\b/',$int_array[$i])) {
                  if (preg_match('/\bAddress\b/',$int_array[$i+1])) {
                    $int_name = end(explode('adapter ', $int_array[$i]));
                    $int_ip = end(explode('. : ', $int_array[$i+1]));
                    echo "<tr>";
                      $int_name = str_replace(":","",$int_name);
                      echo "<td>$int_name</td>";
                      echo "<td>$int_ip</td>";
                      echo "<td>255.255.255.0</td>";
                    echo "</tr>";
                  }
                }
              } ?> 
            </table><br>            
          </div>

          <?php 
          $output = shell_exec('systeminfo');
          $output = preg_split("#[\r\n]+#", $output); ?>
          <div>
            <?php // CHOOSE TOOL
              showSubTitle('System information:');

              showFilterTable("1"); ?>

            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
              <?php
              echo "<tbody id='tableList1'>";
                for ($i = 1; $i < count($output) - 1; $i++) {
                  $output[$i] = utf8_encode($output[$i]);
                  $output[$i] = str_replace('ÿ', ' ', $output[$i]);
                  echo "<tr>";
                  echo "<td>" . $output[$i] . "</td>";
                  echo "</tr>";
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
