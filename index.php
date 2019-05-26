<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
    <?php include('common/functions.php');
          include('common/header.php'); ?>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main animate-bottom" style="margin-left:270px; margin-top:43px;">
      <?php showPageTitle('Overview','fa-tachometer');

        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

        // TOOLS
        $sql = "SELECT * FROM tools";
        $result = $conn->query($sql);
        $tools = $result->num_rows;

        // MODELS
        $sql = "SELECT * FROM models";
        $result = $conn->query($sql);
        $models = $result->num_rows;

        // PENTEST
        $sql = "SELECT * FROM pentests";
        $result = $conn->query($sql);
        $pentests = $result->num_rows;

        // REPORTS
        $sql = "SELECT * FROM reports";
        $result = $conn->query($sql);
        $reports = $result->num_rows;

        // LAST HISTORY
        $sql = "SELECT * FROM history WHERE id=0";
        $result = $conn->query($sql); 
        $row = $result->fetch_assoc();
        if ($row['last_export'] != "") {
          $last_history = substr($row['last_export'], 0, 10);
        } else {
          $last_history = "---";
        }

        // LAST BACKUP
        $sql = "SELECT * FROM settings WHERE id=0";
        $result = $conn->query($sql); 
        $row = $result->fetch_assoc();
         if ($row['last_backup'] != "0000-00-00 00:00:00") {
          $last_backup = substr($row['last_backup'], 0, 10);
        } else {
          $last_backup = "---";
        }

        // WORKING TIME
        ///$sql = "SELECT elapsedtime FROM pentests";
        //$result = $conn->query($sql);

        //$wtime = 0;
        //while ($row = $result->fetch_assoc()) {
        //  $wtime = $wtime + $row['elapsedtime'];
        //}
        //$sec_H = floor($wtime / 3600); $sec_i = ($wtime / 60) % 60; $sec_s = $wtime % 60;

        // NETWORKS
        //$sql = "SELECT * FROM detectips";
        //$result = $conn->query($sql);
        //$networks = $result->num_rows;

        // DETECTED IPS
        //$sql = "SELECT qty FROM detectips";
        //$result = $conn->query($sql);
        //$dips = 0;
        //while ($row = $result->fetch_assoc()) {
        //  $dips = $dips + $row['qty'];
        //}
        $conn->close();
      ?>

      <div class="w3-row-padding w3-margin-bottom w3-center" style="margin-right: 20px;">
        
        <div style="background-image: url(images/logo/logo.png); background-repeat: no-repeat; background-position: center; background-size: 400px; height: 480px; background-position-y: 50px;">
          <?php echo "<div class='w3-row-padding'>";
            echo "<a href='tools.php?tab=Tools'>";
            showOverviewTitle($overview_title1, "fa-wrench", '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$tools, "button_panel");
            echo "</a>";
            echo "<a href='models.php?tab=Mools'>";
            showOverviewTitle($overview_title2, "fa-list-alt", '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$models, "button_panel");
            echo "</a>";
            echo "<a href='pentests.php?tab=Pentests'>";
            showOverviewTitle($overview_title3, "fa-shield", '&nbsp&nbsp&nbsp&nbsp&nbsp'.$pentests, "button_panel");
            echo "</a>";
            echo "<a href='reports.php?tab=Reports'>";
            showOverviewTitle($overview_title4, "fa-file-text-o", '&nbsp&nbsp&nbsp&nbsp&nbsp'.$reports, "button_panel");
            echo "</a>";
          echo "</div>";
          echo "<br>";
          echo "<div class='w3-row-padding'>";
            //showOverviewTitle($overview_title6, "fa-clock-o", $wtime . ' sec', "");
            //showOverviewTitle($overview_title7, "fa-share-alt fa-rotate-90", $networks, "");
            //showOverviewTitle($overview_title8, "fa-desktop", $dips, "");
            echo "<a href='history.php?tab=History'>";
            showOverviewTitle('Last export History', "fa-share-square", $last_history, "button_panel");
            echo "</a>";
            echo '<div class="w3-quarter" style="padding: 10px;">';
              echo '<div class="w3-clear"></div>';
            echo '</div>';
            echo '<div class="w3-quarter" style="padding: 10px;">';
              echo '<div class="w3-clear"></div>';
            echo '</div>';
            echo "<a href='settings.php?tab=Settings'>";
            showOverviewTitle('Last backup Database', "fa-database", $last_backup, "button_panel");
            echo "</a>";  
          echo "</div>";
        echo "</div>";
        ?>

      <!--
        <div class="w3-panel">
          <div class="w3-row-padding" style="margin:0 -16px">
            <div class="w3-third">
              <h5>Regions</h5>
              <img src="/w3images/region.jpg" style="width:100%" alt="Google Regional Map">
            </div>
            <div class="w3-twothird">
              <h5>Feeds</h5>
              <table class="w3-table w3-striped w3-white">
                <tr>
                  <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
                  <td>New record, over 90 views.</td>
                  <td><i>10 mins</i></td>
                </tr>
                <tr>
                  <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
                  <td>Database error.</td>
                  <td><i>15 mins</i></td>
                </tr>
                <tr>
                  <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
                  <td>New record, over 40 users.</td>
                  <td><i>17 mins</i></td>
                </tr>
                <tr>
                  <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
                  <td>New comments.</td>
                  <td><i>25 mins</i></td>
                </tr>
                <tr>
                  <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
                  <td>Check transactions.</td>
                  <td><i>28 mins</i></td>
                </tr>
                <tr>
                  <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
                  <td>CPU overload.</td>
                  <td><i>35 mins</i></td>
                </tr>
                <tr>
                  <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
                  <td>New shares.</td>
                  <td><i>39 mins</i></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <hr>
        <div class="w3-container">
          <h5>General Stats</h5>
          <p>New Visitors</p>
          <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
          </div>

          <p>New Users</p>
          <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
          </div>

          <p>Bounce Rate</p>
          <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
          </div>
        </div>
        <hr>

        <div class="w3-container">
          <h5>Countries</h5>
          <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <tr>
              <td>United States</td>
              <td>65%</td>
            </tr>
            <tr>
              <td>UK</td>
              <td>15.7%</td>
            </tr>
            <tr>
              <td>Russia</td>
              <td>5.6%</td>
            </tr>
            <tr>
              <td>Spain</td>
              <td>2.1%</td>
            </tr>
            <tr>
              <td>India</td>
              <td>1.9%</td>
            </tr>
            <tr>
              <td>France</td>
              <td>1.5%</td>
            </tr>
          </table><br>
          <button class="w3-button w3-dark-grey">More Countries  <i class="fa fa-arrow-right"></i></button>
        </div>
        <hr>
        <div class="w3-container">
          <h5>Recent Users</h5>
          <ul class="w3-ul w3-card-4 w3-white">
            <li class="w3-padding-16">
              <img src="/w3images/avatar2.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
              <span class="w3-xlarge">Mike</span><br>
            </li>
            <li class="w3-padding-16">
              <img src="/w3images/avatar5.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
              <span class="w3-xlarge">Jill</span><br>
            </li>
            <li class="w3-padding-16">
              <img src="/w3images/avatar6.png" class="w3-left w3-circle w3-margin-right" style="width:35px">
              <span class="w3-xlarge">Jane</span><br>
            </li>
          </ul>
        </div>
        <hr>

        <div class="w3-container">
          <h5>Recent Comments</h5>
          <div class="w3-row">
            <div class="w3-col m2 text-center">
              <img class="w3-circle" src="/w3images/avatar3.png" style="width:96px;height:96px">
            </div>
            <div class="w3-col m10 w3-container">
              <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
              <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
            </div>
          </div>

          <div class="w3-row">
            <div class="w3-col m2 text-center">
              <img class="w3-circle" src="/w3images/avatar1.png" style="width:96px;height:96px">
            </div>
            <div class="w3-col m10 w3-container">
              <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
              <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
            </div>
          </div>
        </div>
        <br>
        <div class="w3-container w3-dark-grey w3-padding-32">
          <div class="w3-row">
            <div class="w3-container w3-third">
              <h5 class="w3-bottombar w3-border-green">Demographic</h5>
              <p>Language</p>
              <p>Country</p>
              <p>City</p>
            </div>
            <div class="w3-container w3-third">
              <h5 class="w3-bottombar w3-border-red">System</h5>
              <p>Browser</p>
              <p>OS</p>
              <p>More</p>
            </div>
            <div class="w3-container w3-third">
              <h5 class="w3-bottombar w3-border-orange">Target</h5>
              <p>Users</p>
              <p>Active</p>
              <p>Geo</p>
              <p>Interests</p>
            </div>
          </div>
        </div>
      -->

    </div>
  </body>
</html>