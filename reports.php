<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
    <?php include('common/functions.php');
          include('common/header.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// DELETE FILE BY ID
if (isset($_POST["id"])) {
  $id = $_POST["id"];
  $file = $_POST["file"];

  $file_show = substr(strstr($file, 'reports/'), strlen('reports/'));

  //$sql = "DELETE FROM reports WHERE id=$id";
  $sql = "UPDATE reports SET deleted='1' WHERE id=$id";
  if ($conn->query($sql) === TRUE) {
    unlink($file); // DELETE FILE
    showToastMessage("Report deleted successfully!");
  }
} // END DELETE FILE BY ID

// CONVERT TO PDF FILE, OfficeToPDF.exe don't need second argument: name of pdf file
if (isset($_POST["filepdf"])) {
  $fileNameConvert = $_POST["filepdf"];
  shell_exec($convertPDF . "\"" . $fileNameConvert . "\""); // "" para nomes com espaços, nome do pentest
  showToastMessage("Report converted to PDF successfully!");
  $convert = 1;
}

if (isset($_POST["action"]) && $_POST["action"] == "report") {
  $idpentest = $_POST["idpentest"]; 

  $sql = "SELECT * FROM pentests WHERE id = $idpentest";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $userPentest = $row['user'];
  $datePentest = $row['date'];
  $namePentest = $row['name'];
  $descriptionPentest = $row['description'];
  $idmodel = $row['idmodel'];
  $port = $row['port'];
  $host = $row['host'];
  $network = $row['network'];
  $domain = $row['domain'];
  $commandsPentest = explode('","', $row['commands']);
  $notesPentest = $row['notes'];

  $resultPentest = $row['result'];
  $elapsedtime = $row['elapsedtime'];

  $sql = "SELECT * FROM models WHERE id = $idmodel";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  $nameModel= $row['name'];
  $descriptionModel = $row['description'];
  $commands = explode("\n", str_replace("\r", "", $row['commands']));
  $idtools = explode("\n", str_replace("\r", "", $row['idtools']));
  // If exists, remove last value array $idtools, with nothing: \n
  if (end($idtools) == '') {
    array_pop($idtools);
  }
  $notesModel = $row['notes'];

  // CREATE REPORT

  if ($_POST["action"] == "report") {

    if ($namePentest != "") {
      $fileNameReportHTML = "tmp/report_" . $namePentest . "_" . date('Ymd_His') . ".html";
    } else {
      $fileNameReportHTML = "tmp/report_" . date('Ymd_His') . ".html";
    }

    
    $fileReport = fopen($fileNameReportHTML, "w") or die("Unable to open file!");

    // PAGE 1
    fwrite($fileReport, '<html>');

    fwrite($fileReport, '<head>');
    fwrite($fileReport, '<style>');
    fwrite($fileReport, 'p, h1, h2, h3 {');
    fwrite($fileReport, 'font-family: Encode Sans SemiCondensed;');
    fwrite($fileReport, '}');
    fwrite($fileReport, 'th, td {');
    fwrite($fileReport, 'border-collapse: collapse; border: 1px solid black;');
    fwrite($fileReport, '}');
    fwrite($fileReport, 'p.line {');
    fwrite($fileReport, 'font-family: Times New Roman;');
    fwrite($fileReport, '}');
    fwrite($fileReport, 'html,body{');
    fwrite($fileReport, 'height:297mm;');
    fwrite($fileReport, 'width:210mm;');
    fwrite($fileReport, '}');
    fwrite($fileReport, '@page { size: 21cm 29.7cm; margin: 2cm }');
    fwrite($fileReport, '</style>');
    fwrite($fileReport, '</head>');

    fwrite($fileReport, '<body style="font-family: "Encode Sans", sans-serif;">');
    
    fwrite($fileReport, "<div class=Section1>");
    fwrite($fileReport, "<p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p>");
    fwrite($fileReport, "<center><img src='http://localhost/images/logo/logo-name.png'/></center>"); 
    fwrite($fileReport, '<center><h2><strong style="color:' . COLOR_ORANGE . '">P</strong><strong>rivate </strong><strong style="color:' . COLOR_ORANGE . '">P</strong><strong>ortable </strong><strong style="color:' . COLOR_ORANGE . '">P</strong><strong>entest<br>and </strong><strong style="color:' . COLOR_ORANGE . '">N</strong><strong>etwork </strong><strong style="color:' . COLOR_ORANGE . '">I</strong><strong>nformation </strong><strong style="color:' . COLOR_ORANGE . '">F</strong><strong>ramework</strong></h2></center>');
    fwrite($fileReport, "<p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p>");
    fwrite($fileReport, "<center><h1>PENTEST REPORT</h1></center>");
    fwrite($fileReport, "<p><pre> </pre></p><p><pre> </pre></p>");
    fwrite($fileReport, "<p><b>Name: </b>" . $namePentest . "</p>");
    if ($descriptionPentest != "") { fwrite($fileReport, "<p><b>Description: </b>" . $descriptionPentest . "</p>"); }
    fwrite($fileReport, "<p><pre> </pre></p>");
    fwrite($fileReport, "<p><b>Pentest date: </b>" . $datePentest . "</p>");

    $elapsedtimeArray = explode(".", $elapsedtime);
    $showElapsedtime = gmdate("H:i:s", $elapsedtimeArray[0]) . "." . $elapsedtimeArray[1];

    fwrite($fileReport, "<p><b>Pentest elapsed time: </b>" . $showElapsedtime . "</p>");
    fwrite($fileReport, "<p><b>Report date: </b>" . date('Y-m-d H:i:s') . "</p>");
    fwrite($fileReport, "<p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p><p><pre> </pre></p>");
    fwrite($fileReport, "<p><b>Created by: </b>" . $userPentest . "</p>");

    // Page break
    //fwrite($fileReport, '<p style="margin-bottom: 0cm; line-height: 100%"><br/></p><p style="margin-bottom: 0cm; line-height: 100%; page-break-before: always">');
    fwrite($fileReport, '<br><br><br><br><br><br><br><br><br>');

    // PAGE 2
    // READ COMMANDS AND RESULTS
    fwrite($fileReport, "<p><pre> </pre></p>");
    fwrite($fileReport, "<center><h2 style='background-color: gray;'>Result of the execution tools</h2></center>");
    fwrite($fileReport, "<p><b><u>Model:</u></b> " . $nameModel . "</p>");
    fwrite($fileReport, "<p><b>Description:</b> " . $descriptionModel . "</p>");
    fwrite($fileReport, "<p><b>Notes:</b> " . $notesModel . "</p>");

    $i=0;
    $resultPentest = json_decode($resultPentest);
    $count = count($commandsPentest, true);

    // Remove start: [" and end: "]
    $commandsPentest[0] = substr($commandsPentest[0], 2);
    $commandsPentest[$count -1] = substr($commandsPentest[$count -1], 0, -2);

    while ($i < $count) {

      fwrite($fileReport, "<p class='line'>______________________________________________________________________</p>");
      
      $sql = "SELECT * FROM tools WHERE id = $idtools[$i]";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $nameTool = $row['name'];

      fwrite($fileReport, "<p><b><u>Tool:</u></b> " . $nameTool . "</p>");

      // Show current command

      // Analisa se é do tipo = wincmd para remover "tools\"
      if ($row['type'] == "wincmd") {
        $commandsPentest[$i] = str_replace(TOOLS, "", $commandsPentest[$i]);
      }

      fwrite($fileReport, "<p><code><b>Command ". ($i+1) ."/".$count." > </b>" . $commandsPentest[$i] . "</code></p>");

      if ($resultPentest[$i] != NULL) {

        // detect if command start with http -> test Domain
        if (substr($commandsPentest[$i], 0, 4 ) === "http") {
          fwrite($fileReport, "<p style='font-size: small; background-color: lightgrey;'><b>#&emsp;crt.sh ID&emsp;&emsp;Logged At&emsp;Not Before&emsp;Not After&emsp;&emsp;Identity&emsp;&emsp;Issuer Name</b></p>");
          $j=1;
          foreach ($resultPentest[$i] as $item) {
            fwrite($fileReport, "<p style='font-size: small;'><b>" . $j . "</b>&emsp;" . $item->min_cert_id . "&emsp;" . substr($item->min_entry_timestamp,0,10) . "&emsp;" . substr($item->not_before,0,10) . "&emsp;" . substr($item->not_after,0,10) . "&emsp;" . $item->name_value . "&emsp;" . $item->issuer_name . "</p>");
            $j++;
          }
        } else { // test diferent: service, host or network
          fwrite($fileReport, "<p style='font-size: small; background-color: lightgrey;'><b>#&emsp;Line command output</b></p>");
            $j=1;
          foreach ($resultPentest[$i] as $item) {
            // Convert HTML entities to characters
            //$item = html_entity_decode($item);
            fwrite($fileReport, "<p style='font-size: small;'><b>" . $j . "&emsp;</b>" . $item . "</p>");
            $j++;
          }
        }
      } else {
        fwrite($fileReport, "<p><b>No results for this tool.</b></p>");
      }
      $i++;    
    }

    // Page break
    fwrite($fileReport, "<br clear=all style='mso-special-character:line-break;page-break-before:always'>");
    fwrite($fileReport, "<p><pre> </pre></p>");
    fwrite($fileReport, "<center><h2 style='background-color: gray;'>Tools used in pentest</h2></center>");

    // New array with only uniques values with id tools used (array_values to reindex)
    $idtools = array_values(array_unique($idtools));
    
    $i=0;
    $count = count($idtools, true);
    while ($i < $count) {
      $sql = "SELECT * FROM tools WHERE id = $idtools[$i]";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      $nameTool = $row['name'];
      $descriptionTool = $row['description'];
      $notesTool = $row['notes'];

      fwrite($fileReport, "<p><b>Tool #" . ($i+1) . ":</b> " . $nameTool . "</p>");
      fwrite($fileReport, "<p><b>Description:</b> " . $descriptionTool . "</p>");
      fwrite($fileReport, "<p><b>Notes:</b> " . $notesTool . "</p>");
      fwrite($fileReport, "<p class='line'>______________________________________________________________________</p>");
      $i++;
    }

    fwrite($fileReport, "</div>");

    fwrite($fileReport, "</body>");
    fwrite($fileReport, "</html>");
    fclose($fileReport);
    $fileNameReportODT = (substr($fileNameReportHTML, 0, strpos($fileNameReportHTML, "html"))) . "odt";
    $fileNameReportODT = str_replace("tmp","reports", $fileNameReportODT);
    shell_exec("Tools\pnif\pandoc.exe \"" . $fileNameReportHTML . "\" -o \"" . $fileNameReportODT . "\"");
    
    actionDB("INSERT INTO reports (user, idpentest, file) VALUES ('". USER . "', '" . $idpentest . "', '" . $fileNameReportODT . "')");

    unlink($fileNameReportHTML);

  }
  showToastMessage("Report created successfully!");
}
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" style="margin-left:270px;margin-top:43px;">

  <?php showPageTitle('Reports » List','fa-file-text'); ?>

  <div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
      <div class="w3-container w3-white w3-card-4 w3-padding-16">
        <div>

          <?php showFilterTable("1"); ?>

          <table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
            <?php 

            $sql = "SELECT id, date, user, file, deleted FROM reports ORDER BY date DESC";
            $result = $conn->query($sql);
            echo "<thead>";
              echo "<tr>";
                echo "<th><strong># &nbsp; &nbsp; &nbsp; Filename </strong></th>";
                echo "<th><strong> User </strong></th>";
                echo "<th><strong> Date </strong></th>";
                echo "<th></th>";
                echo "<th></th>";
              echo "</tr>";
            echo "</thead>";
            echo "<tbody id='tableList1'>";
              $count = 1;
              while ($row = $result->fetch_assoc()) {
                unset($id, $date, $user, $file, $deleted);
                $id = $row['id']; 
                $date = $row['date']; 
                $user = $row['user'];
                $file = $row['file'];
                $deleted = $row['deleted'];
                // remove folder in name to show on table
                $file_show = substr(strstr($file, 'reports/'), strlen('reports/'));
                if ($deleted == '0') {
                  echo "<tr>";

                  if (file_exists($file)) {
                    echo "<td><strong>$count</strong> &nbsp; &nbsp; <a href='$file' download>$file_show</a></td>";
                  } else {
                    echo "<td><strong>$count</strong> &nbsp; &nbsp;";
                    echo "<i style='color:COLOR_ORANGE;' class='tooltip fa fa-exclamation-circle fa-lg'>";
                    echo "<span class='tooltiptext'>File not found!</span></i>";
                    echo " <span style='color:red; text-decoration: line-through;'>$file_show</span></td>";
                  }
                  echo "<td>$user</td>";
                  echo "<td>$date</td>";

                  // ICON TRASH DELETE ?>           
                  <td>
                    <button onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='block'" class="w3-button w3-large"><i class="fa fa-trash-o"></i></button>
                    <div id="formdel<?php echo $id; ?>" class="w3-modal"> <!-- por omissão: display: none -->
                      <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:330px; border-radius: 10px;">
                        <div class="w3-center" style="padding-top: 10px;">
                          <h5>Delete report?</h5>
                          <form id="form" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                            <input name="id" type="hidden" value="<?php echo $id; ?>">
                            <input name="file" type="hidden" value="<?php echo $file; ?>">
                            <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                            <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td> <?php 
                  if (file_exists($file)) {
                  
                  // ICON CONVERT TO PDF FILE ?>
                  <td>
                    <button onclick="document.getElementById('formpdf<?php echo $id; ?>').style.display='block'" class="w3-button w3-large"><img src="images/pdf_file.png"></button>

                    <div id="formpdf<?php echo $id; ?>" class="w3-modal"> <!-- por omissão: display: none -->
                      <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:330px; border-radius: 10px;">
                        <div class="w3-center" style="padding-top: 10px;">
                          <h5>Convert to PDF?</h5>
                          <form id="form" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                            <input name="filepdf" type="hidden" value="<?php echo $file; ?>">
                            <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formpdf<?php echo $id; ?>').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                            <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formpdf<?php echo $id; ?>').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td> 

                  <?php } else { echo "<td></td>"; }

                  echo "</tr>";
                  $count++;
                }
              }
              $conn->close();  ?>
            </tbody>
          </table><br>        
        </div>

        <?php if ($convert == 1) {
          $fileNamePDF = substr($fileNameConvert, 0, strpos($fileNameConvert, ".odt"));
          $fileNamePDF = $fileNamePDF . ".pdf";
          ?>
          <a id="download" href="<?php echo $fileNamePDF; ?>" download hidden></a>
          <script type="text/javascript">
            document.getElementById('download').click();
          </script>
          <?php $download = 0;
          //unlink($fileNameExport);
        } ?>

      </div>
      <br>
    </div>
  </div>
</div>
</body>
</html>