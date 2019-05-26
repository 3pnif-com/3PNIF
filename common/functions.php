
<?php session_start();

// FUNÇÕES

function actionDB($sql) {
  // Create connection
  $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 
  if ($conn->query($sql) === TRUE) {
    //echo "<br>Command executed successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  return $c;
}

function show3PNIFTitle() {
  echo '<h3><strong style="color:' . COLOR_ORANGE . '">P</strong><strong>rivate </strong><strong style="color:' . COLOR_ORANGE . '">P</strong><strong>ortable </strong><strong style="color:' . COLOR_ORANGE . '">P</strong><strong>entest and </strong><strong style="color:' . COLOR_ORANGE . '">N</strong><strong>etwork </strong><strong style="color:' . COLOR_ORANGE . '">I</strong><strong>nformation </strong><strong style="color:' . COLOR_ORANGE . '">F</strong><strong>ramework</strong></h3>';
}

function showFooter() {
  echo "<strong> © " . date('Y') .  " 3PNIF<br> </strong>";
  echo "<a href='http://www.3pnif.com/' target='_blank'>www.3pnif.com</a><br>";
}

function check_version() {
  $output = shell_exec('dir /o:-d /a:a');
  $output = preg_split('#[\r\n]+#', trim($output));
  $version = preg_replace('/\s+/', '', $output[3]);
  $version = str_replace('/', '', $version);
  $version = strpos($version, ":") ? substr($version, 0, strpos($version, ":")+4) : $version;
  $version = substr($version, 0, 8) . '-' . substr($version, 8);
  $version = str_replace(':', '', $version);
  $version2 = substr ($version, -10, 4); //ano
  $version2 = $version2 . substr ($version, -12, 2); //mes
  $version2 = $version2 . substr ($version, -14, 2); //dia
  $version2 = $version2 . substr ($version, -6, 5); //horas + minutos

  //29052018-22172
  // $x = '1234567';
  // echo substr ($x, 0, 3);  // outputs 123
  // echo substr ($x, 1, 1);  // outputs 2
  // echo substr ($x, -2);    // outputs 67
  // echo substr ($x, 1);     // outputs 234567
  // echo substr ($x, -2, 1); // outputs 6

  echo "<p style='font-size: 11px; color: black; margin: -10px 0px 0px 0px;'>Version: 0." . $version2 . "</p>";
}

function showPageTitle($title, $icon) {
  echo "<table id='toHide' style='width: 90%; margin-top: 100px; margin-bottom: 20px; border-spacing: 0px; background: linear-gradient(to right, rgba(255,100,0,1), rgba(255,0,0,0)); padding: 5px; border-radius: 14px; opacity: 0.9;'>";
  echo "<tr style='color: white;'>";
    echo "<td style='padding-left: 20px; width: 30px; text-align: center;'><i style='margin-left: 5px;' class='fa $icon fa-2x'></i></td>";
    echo "<td style='padding-bottom: 3px;'><strong style='font-size: 21px; margin-left: 10px;'> $title</strong></td>";
  echo "</tr>";
  echo "</table>";
}

function showSubTitle($title) {
  echo "<div class='w3-row'>";
  echo "<h4><strong><i class='fa fa-arrow-right'></i> $title</strong></h4>";
  echo "</div>";
}

function showItemMenu($title, $file, $icon) {
  if ($file == '') { $file = $title; }
  if ($title == 'Overview') {
    echo '<tr id="'.$file.'" onclick="document.getElementById(\'icon'.$file.'H\').style.display=\'none\'; document.getElementById(\'icon'.$file.'S\').style.display=\'inline-grid\'; location.href=\'index.php?tab='.$file.'\'" class="w3-button" style="border-radius: 15px; display: flex; cursor: pointer; padding: 3px 25px!important; margin-left: -15px; margin-right: 14px;">';
  } else {
    echo '<tr id="'.$file.'" onclick="document.getElementById(\'icon'.$file.'H\').style.display=\'none\'; document.getElementById(\'icon'.$file.'S\').style.display=\'inline-grid\'; location.href=\''.$file.'.php?tab='.$file.'\'" class="w3-button" style="border-radius: 15px; display: flex; cursor: pointer; padding: 3px 25px!important; margin-left: -15px; margin-right: 14px;">';
  }
  if ($icon == 'Internet') {
    echo '<td>';
      if($sock != @fsockopen('www.google.com', 80)) {
        echo '<i id="icon'.$file.'"class="fa fa-cloud-upload fa-fw fa-lg"style="color:green"></i>';
      } else {
        echo '<i id="icon'.$file.'"class="fa fa-cloud-download fa-fw fa-lg"style="color:red"></i>';
      }
    echo '</td>';
  } else {
    echo '<td><i id="icon'.$file.'" class="fa '.$icon.' fa-fw fa-lg"></i></td>';
  }
  echo '<td class="w3-button" style="text-align: left; padding: 3px 3px;">';
    echo '<i id="icon'.$file.'H" style="display: inline-grid; vertical-align: middle; width: 18px;" class="fa fa-fw" aria-hidden="true"></i>';
    echo '<i id="icon'.$file.'S" style="display: none; vertical-align: middle; font-size: 21px;" class="fa fa-spinner fa-pulse fa-lg" aria-hidden="true"></i>';
    echo '<strong style="padding-left: 10px;"> '.$title.'</strong>';
  echo '</td>';
echo '</tr>';
}

function showOverviewTitle($title, $icon, $value, $type_panel) {
  echo '<div class="w3-quarter" style="padding: 10px;">';
    echo '<div class="w3-container w3-white w3-card-4 w3-padding-16" id="'. $type_panel .'" onclick=
    "document.getElementById(\'pro\').style.display=\'block\'">';
      echo '<div class="w3-left"><i class="fa ' . $icon . ' w3-xxxlarge"></i></div>';
      echo '<div class="w3-center">';
        echo '<h3 style="font-size: 20px;"><strong>' . $title . '</strong></h3>';
      echo '</div>';
      echo '<div class="w3-clear"></div>';
      echo '<h3 style="font-size: 30px;  margin: 0; color:' . COLOR_ORANGE . '"><strong>' . $value . '</strong></h3>';
    echo '</div>';
  echo '</div>';
}

function showFilterTable($id) {
  echo "<div class='w3-row'>";
    echo "<div class='w3-threequarter' style='display: flex; padding-left: 0px;'>";
    echo "<i style='color: rgb(255, 100, 0); padding: 8px;' class='fa fa-filter fa-lg' aria-hidden='true'></i>";
    echo "<input class='form-control' id='inputFilterTable$id' type='text' placeholder='Filter table values...' style='margin: 0 0 10px;'>";
      echo "<div class='w3-quarter' style='padding-top: 3px;'>";
      echo "<span id='visiblelines$id'><span>";
      echo "</div>";  ?>
    <?php 
    echo "</div>";
  echo "</div>";

  // SCRIPT FILTER TABLE... ?>
  <script type="text/javascript">
    $("#inputFilterTable<?php echo $id;?>").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableList<?php echo $id;?> tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
    </script>
  <?php
}

function showToastMessage($message) { ?>
  <div id="toast"><strong><?php echo $message; ?></strong></div>
  <script>
    var x = document.getElementById("toast");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 6100);
  </script>
<?php }

function runCommands($type, $namePentest, $descriptionPentest, $port, $host, $network, $domain, $idmodel, $idtools, $nameModel, $descriptionModel, $commands, $notesPentest, $startTime, $elapsedtime, $resultPentest, $resultXml) {

  $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

  if ($type == "Result of the execution") {
    $type = "executed";
  } elseif ($type == "Repeat pentest") {
    $namePentest = $namePentest . "(repeated)";
    $type = "repeated"; 
  } else { $type = "viewed"; }

  echo "<strong>Pentest name:</strong> " . $namePentest . "<br>";
  echo "<strong>Pentest description:</strong> " . $descriptionPentest . "<br>";
  echo "<strong>Pentest notes:</strong> " . $notesPentest . "<br>"; ?>
  <button class="accordion" style="width: 50%;"><p style="margin-top: 15px; display: inherit;"><strong>&nbsp;Values of tools parameters</strong></p></button>
  <div class="panel">
    <p> <?php 
      echo "<strong>Service:</strong> " . $port . "<br>";
      echo "<strong>Host:</strong> " . $host . "<br>"; 
      echo "<strong>Network:</strong> " . $network . "<br>";
      echo "<strong>Domain:</strong> " . $domain . "<br>"; ?>
    </p>
  </div> <?php 
  echo "<strong>Model name:</strong> " . $nameModel . "<br>";
  echo "<strong>Model description:</strong> " . $descriptionModel . "<br>";
  echo "<br><strong>Elapsed time: </strong><span id='elapsedtime'></span><br><br>";

  // Limpa linhas do array em branco, que venham de Commands do model
  $i=0;
  while ($i < count($commands, true)) {
    if ($commands[$i] != "") { //Se a linha do array não for em branco
      
      // add final space to str_replace
      $commands[$i] = $commands[$i] . " ";
      // Replace for real values
      $commands[$i] = str_replace("service ", $port . " ", str_replace("host ", $host . " ", str_replace("network ", $network . " ", str_replace("domain ", $domain . " ", $commands[$i]))));

      // Se o comando não começar por http, é tool normal
      if (substr($commands[$i], 0, 4 ) !== "http") { 
        $commands[$i] = TOOLS . $commands[$i];
        //$commands[$i] = str_replace('\"', '', $commands[$i]);
      }

    } else { // Se for linha em branco no array, remove 1 elemento da posição $i
      unset($commands[$i]); //array_splice($commands, $i, 1);
      $i--;
    }
    $i++;

    // array para gravar na bd, sem o caminho completo da tool, que será feito no while seguinte
    $commands_db = json_encode($commands);

    // EXECUTA COMANDOS
    $output_db = array();
    $output_db_xml = array();
  }

  $i=0;
  
  while ($i < count($commands, true)) {

    // Analisa se é do tipo = wincmd para remover "tools\"
    $sql = "SELECT * FROM tools WHERE id = $idtools[$i]";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
  
    if ($row['type'] == "wincmd") {
      $commands[$i] = str_replace(TOOLS, "", $commands[$i]);
    }
    $commands[$i] = str_replace("\\\\","\\", $commands[$i]);
    echo "&nbsp;&nbsp;<i style='cursor: pointer; color: #FF6400;' onclick='copyCommand($i)' class='tooltip fa fa-clipboard fa-lg' aria-hidden='true'><span class='tooltiptext'>Copy command</span></i>&nbsp;&nbsp;&nbsp;&nbsp;";

    echo "<button id='buttonAccordion' class='accordion' style='width: 95%; user-select: text; margin-bottom: 15px;'><code style='margin-top: 15px; display: inherit;'><strong>&nbsp;Command ".($i + 1)."/".count($commands)."></strong></code> <code id='command$i'>" . $commands[$i] . "</code></button>";
    
    echo "<div class='panel'>";
    
    // detect if command start with http -> test Domain
    if (substr($commands[$i], 0, 4 ) === "http") {
      if (strpos($commands[$i], 'crt.sh') !== false) { // Website crt.sh
        
        $url = $commands[$i] . "&output=json";

        $command = 'powershell -command "& { (New-Object Net.WebClient).DownloadFile(\''.$url.'\', \'tmp\\cmd.txt\') }';
        shell_exec($command);

        $cmd = file_get_contents("tmp\\cmd.txt");
        
        //substituir: }{ -> }, {
        $cmd = str_replace("}{","}, {",$cmd);

        // **** REMOVIDO ****
        // adicionar: incício: [  fim: ]
        //$cmd = "[" . $cmd . "]";

        // remove ' (\') by nothing, problem when store in db
        $cmd = str_replace('\'', '', $cmd);
        // remove ' (\"") by nothing, problem when validate json
        $cmd = str_replace('\"', '', $cmd);

        $output = json_decode($cmd,true);

        showFilterTable($i); ?>
        <table id="resultsTable<?php echo $i; ?>" style="font-size: small;" class="w3-table w3-bordered w3-border w3-hoverable w3-white">
          <?php
          echo "<thead>";
            echo "<tr>";
              echo "<th style='width: 12%'><strong># &nbsp; &nbsp; crt.sh ID </strong></th>";
              echo "<th style='width: 9%'><strong> Logged At </strong></th>";
              echo "<th style='width: 9%'><strong> Not Before </strong></th>";
              echo "<th style='width: 9%'><strong> Not After </strong></th>";
              echo "<th style='width: 15%'><strong> Identity </strong></th>";
              echo "<th style='width: 35%'><strong> Issuer Name </strong></th>";
            echo "</tr>";
          echo "</thead>"; ?>
          <tbody id="tableList<?php echo $i; ?>"> <?php
            $j=1;
            foreach ($output as $item) {
              echo "<tr>";
                echo "<td><strong>$j &nbsp;</strong>".$item['min_cert_id']."</td>";
                echo "<td>".substr($item['min_entry_timestamp'],0,10)."</td>";
                echo "<td>".substr($item['not_before'],0,10)."</td>";
                echo "<td>".substr($item['not_after'],0,10)."</td>";
                echo "<td>".$item['name_value']."</td>";
                echo "<td>".$item['issuer_name']."</td>";
              echo "</tr>";
              $j++;
            }
          echo "</tbody>";
        echo "</table>";
        rowClickedTable($i); ?>
        <script type="text/javascript">
          //document.getElementById("visiblelines<?php echo $i; ?>").innerHTML = "&nbsp;&nbsp;Lines: " + ($("#tableList<?php echo $i;?> tr").length);
        </script>
        <?php echo "<br>";

        // Add to array to store in DB
        array_push($output_db, json_decode($cmd,true));
        // No value do array $output_db_xml, because no XML option for domains
       // array_push($output_db_xml, "");

        // Delete file cmd.txt in tmp folder
        unlink("tmp\\cmd.txt");

      } else {
        // TODO
        // Test with another domain
      }
    } else { // test diferent: service, host or network

      if ($type != "viewed") {
       // if ($i == 6) {
      //    $file_tmp = "c:\\dir.txt";
      //  } else {
          $file_tmp = "tmp\\" . $i . "_tool_" . $idtools[$i] . ".txt";
          $cmd = $commands[$i] . " > " . $file_tmp;
          shell_exec($cmd);
      //  }
 
        $output = file_get_contents($file_tmp);
      } else {
        $output = $resultPentest[$i];
      }
      $arraycmd = array();
      if (strlen($output) > 3) { // if output is not empty
        if ($type != "viewed") {
          $output = preg_split("#[\r\n]+#", $output);
        } else {
          $output = explode("\",\"", $output);
        }

        showFilterTable($i); ?>

        <table id="resultsTable<?php echo $i; ?>" style="font-size: small;" class="w3-table w3-bordered w3-border w3-hoverable w3-white">
          <tbody id="tableList<?php echo $i; ?>"> <?php
            $h = 0;
            for ($j = 0; $j < count($output); $j++) {
              if ($type == "viewed") { // When view report, remove 3 first chars
                if ($j == 0) { $output[$j] = substr($output[$j], 3); }
              }
              if (strlen($output[$j]) > 2) {
                $output[$j] = utf8_encode(str_replace("", "", preg_replace('/\t+/', ' - ', $output[$j])));
                
                echo "<tr>";

                  // Remove &nbsp;
                  $output[$j] = str_replace('ÿ', ' ', $output[$j]);
                  $output[$j] = str_replace('þ', ' ', $output[$j]);
                  $output[$j] = str_replace("\\\\","\\", $output[$j]);
                  // Convert characters to HTML entities
                  //$output[$j] = htmlentities($output[$j]);
                  echo "<td><strong>" . ($j - $h + 1) . "</strong> &nbsp; &nbsp;$output[$j]</td>";
                  echo "</tr>";
                // Replace "\" to "\\" for correct store in json format in DB
                $output[$j] = str_replace("\\","\\\\", $output[$j]);
                array_push($arraycmd, $output[$j]);
              } else {
                $h++; 
              }
            }  ?>
          </tbody>
        </table><br> <?php
        rowClickedTable($i); ?>
        <script type="text/javascript">
          //document.getElementById("visiblelines<?php echo $i; ?>").innerHTML = "&nbsp;&nbsp;Lines: " + ($("#tableList<?php echo $i;?> tr").length);
        </script> <?php 
        // ******************** Output XML

        // https://stackoverflow.com/questions/16930765/displaying-xml-contents-in-a-table-with-php

        if ($row['supportxml'] == "1") {
          
          $doc = new DOMDocument();

          $file_xml = "tmp\\" . $i . "_tool_" . $idtools[$i] . ".xml";

          if ($type != "viewed") { 

            $cmd = $commands[$i] . " " . $row['xmlparam'] . " " . $file_xml;
 
            shell_exec($cmd);
            //$xml = simplexml_load_file(htmlentities($file_xml));
            $save_db = file_get_contents($file_xml);
 
            $save_db = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $save_db);
            $save_db = str_replace("802.11_standards","_802.11_standards", $save_db);

            $doc->loadXML($save_db);

          } else {

            // Create XML file
            $file = fopen($file_xml, "w");

            // If is the first...
            if ($i == 0) {
              $resultXml[$i] = substr($resultXml[$i], 2);
            } else {
              $resultXml[$i] = substr($resultXml[$i], 1);

              //IF is the last...
              if ($i+1 == count($resultXml)) {
                $resultXml[$i] = substr($resultXml[$i], 0, -2);
              }
            }

            fwrite($file, $resultXml[$i]);
            fclose($file);

            $doc->loadXML(file_get_contents($file_xml));

           /* if ($i+1 == count($resultXml)) {
              // Remove last line from XML file
              $lines = file($file_xml); 
              $last = sizeof($lines) - 1 ; 
              unset($lines[$last]);

              // write the XML file 
              $file = fopen($file_xml, 'w'); 
              fwrite($file, implode('', $lines)); 
              fclose($file); 
            } */
          }
                    
          $xpath = new DOMXpath($doc);
 
          $xmlkeys = json_decode($row['xmlkeys']);

          showFilterTable("a" . $i); // "a" para distinguir outros só com $i
          ?>
          <table id="resultsTablea<?php echo $i; ?>" style="font-size: small;" class="w3-table w3-bordered w3-border w3-hoverable w3-white">
          <?php 
            echo "<thead>";
                echo "<tr>";
                  echo "<th style='width: 20%'><strong># &nbsp; &nbsp; XML Key </strong></th>";
                  echo "<th style='width: 70%'><strong> Value </strong></th>";
                echo "</tr>";
              echo "</thead>";
            echo "<tbody id='tableList" . "a" . $i . "'>";

              $j = 0;
              while ($j < count($xmlkeys, true)) {
                echo "<tr>";
                  // Search all with xmlkeys[$j]
 
                  if ($row['typexml'] == "1") { // Attributes
                    $nodes = $xpath->query("//" . $xmlkeys[$j] . "/@*");
                  } else { // Child Elements
                    $nodes = $xpath->query("//" . $xmlkeys[$j] . "/node()");
                  }
                  
                  // For testing: <div style="display: none">
                  ?> <div style="display: none"> <?php var_dump($nodes); ?></div> <?php 
                
                  echo "<td id='xmlkey' style='vertical-align: top; padding-top: 4px;'><strong>" . ($j+1) . " &nbsp; &nbsp; </strong>".$xmlkeys[$j]."</td>";
                  echo "<td>";
                    $first_node = "";
                    foreach ($nodes as $node) {
                      if ($first_node == "") { // 1st time
                        $first_node = $node->nodeName;
                        if ($row['typexml'] == "1") { // Attributes
                          echo "<u>" . $node->nodeName . "</u>: " . $node->nodeValue . " ";
                        } else { echo $node->nodeValue; }
                      } else { // 2nd time and others
                        if ($node->nodeName != $first_node) {
                          if ($row['typexml'] == "1") { // Attributes
                          echo "<u>" . $node->nodeName . "</u>: " . $node->nodeValue . " ";
                        } else { echo $node->nodeValue; }
                        } else {
                          echo "<br>";
                          if ($row['typexml'] == "1") { // Attributes
                          echo "<u>" . $node->nodeName . "</u>: " . $node->nodeValue . " ";
                        } else { echo $node->nodeValue; }
                        }
                      }
                    }
                  echo "</td>";
                echo "</tr>";
                $j++;
              }
            echo "</tbody>";
          echo "</table><br>";
          rowClickedTable("a" . $i); ?>
          <script type="text/javascript">
            document.getElementById("visiblelines<?php echo "a" . $i; ?>").innerHTML = "";
          </script> <?php 

          array_push($output_db_xml, $save_db);

          // Delete file xml in tmp folder
          //unlink($file_xml);
        } else {
          if ($type != "viewed") {
            array_push($output_db_xml, "");
          }
        }

      } else { 
        echo "No results for this command.<br><br>";
        array_push($arraycmd, "");
      }

      // Add to array to store in DB
      if ($type != "viewed") {
        array_push($output_db, $arraycmd);
      }
    }
    $i++;
    //unlink($file_tmp);
    echo "</div>";
  }

  if ($type != "viewed") {
    $endTime = microtime(true);
    $elapsedtime = number_format($endTime - $startTime,2,'.','');
    $elapsedtimeArray = explode(".", $elapsedtime);

    $output_json = json_encode($output_db);
    $output_json = str_replace('\\u0000', "", $output_json);

    $output_xml_json = json_encode($output_db_xml);
    $output_xml_json = str_replace('\\u0000', "", $output_xml_json);

    $sql = "INSERT INTO pentests (user, name, description, port, host, network, domain, notes, idmodel, commands, result, resultxml, elapsedtime) VALUES ('" . USER . "', '" . $namePentest . "', '" . $descriptionPentest . "', '" . $port . "', '" . $host . "', '" . $network . "', '" . $domain . "', '" . $notesPentest . "', '" . $idmodel . "', '" . $commands_db . "', '" .  $output_json . "', '" . $output_xml_json . "', '" . $elapsedtime . "')";

    if ($conn->query($sql) === TRUE) {
      showToastMessage("Pentest " . $type . " successfully!");
    } else {  showToastMessage("Error insert into table: " . $conn->error); }
  } else {
    $elapsedtimeArray = explode(".", $elapsedtime);
  }
  // valor entre 0 e 9, acrescenta um zero
  if (strlen((string)$elapsedtimeArray[1]) == 1) {
    $elapsedtimeArray[1] = "0" . $elapsedtimeArray[1];
  }
  $showElapsedtime = gmdate("H:i:s", $elapsedtimeArray[0]) . "." . $elapsedtimeArray[1];

  ?> <script>
    document.getElementById("elapsedtime").innerHTML = "<?php echo $showElapsedtime; ?>";
  </script>
  <?php $conn->close();

}

function processing() { ?>
  <div id="pro" class="w3-modal" style="padding-top: 10%;"> <!-- por omissão: display: none -->
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:330px; border-radius: 10px;">
      <div class="w3-center">
        <div id="pro" style="width: 100%; position: absolute; display: block;">
          <div style="margin: 0 auto; position: relative; border: solid 20px <?php echo COLOR_ORANGE ?>; border-radius:50%; width: 150px; height: 150px;">
            <i style="margin-top: 16%; color: <?php echo COLOR_ORANGE ?>" class="fa fa-spinner fa-pulse fa-5x" aria-hidden="true"></i>  
          </div>
          <p style="background: <?php echo COLOR_ORANGE ?>; color: white; border-radius: 11px; margin-top: 5px;"><strong>Processing...</strong></p>
        </div>
      </div>
    </div>
  </div>
<?php } 

// detect clicked row and hide before
function rowClickedTable($id) { ?>
  <script type="text/javascript">
  $("#resultsTable<?php echo $id;?>").find('tr').click( function(){
    var table = document.getElementById("resultsTable<?php echo $id; ?>");
    var alltr = table.querySelectorAll("tr");
    var row = $(this).index()+1;

    var lenghtalltr = Object.keys(alltr).length;
    console.log("- " + lenghtalltr + "-" + row + " = " + (lenghtalltr - row));
    // show all
    for (var i = 1; i < lenghtalltr; i++) { alltr[i].style.display = "table-row"; }
    // hide before click row
    for (var i = 1; i < row; i++) { alltr[i-1].style.display = "none"; }

    //document.getElementById("visiblelines<?php echo $id;?>").innerHTML = "&nbsp;&nbsp;Lines: " + ((lenghtalltr+1) - row);
  });
  </script>
  <?php 
}
?>
<script type="text/javascript">

// Change Tittle
var isOldTitle = true;
var oldTitle = "3PNIF";
var newTitle = "3PNIF ⸭"; //" . . . . .";
function changeTitle() {
     document.title = isOldTitle ? oldTitle : newTitle;
     isOldTitle = !isOldTitle;
     setTimeout(changeTitle, 700);
}
changeTitle();

// Button pencil click Edit tool/model
function windowFromEdit() {
  $('#toHideSize').css('margin-top', '0px');
  var ids = document.querySelectorAll("[id='toHide']");
  for(var i = 0; i < ids.length; i++) 
    ids[i].style.display='none';
}

function ValidateIPaddress(inputText) {
  var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
  if(inputText.value.match(ipformat)) {
    inputText.focus();
    return true;
  }
    else {
    alert("You have entered an invalid IP address!");
    inputText.focus();
    return false;
  }
}

function start_count_time() {
  $('input[type="time"][value="now"]').each(function(){    
    var d = new Date(),        
        h = d.getHours(),
        m = d.getMinutes(),
        s = d.getSeconds();
        ms = d.getMilliseconds();
    if(h < 10) h = '0' + h; 
    if(m < 10) m = '0' + m; 
    if(s < 10) s = '0' + s;
    if(ms < 10) ms = '0' + ms;
    $(this).attr({
      'value': h + ':' + m + ':' + s + ':' + ms
    });
  });
}

function copyCommand(i) {
  var text = document.getElementById("command"+i).textContent;
  //console.log("--> "+i+" --> "+text);
  var copyFrom = $('<textarea/>');
  copyFrom.css({
    position: "absolute",
    left: "-1000px",
    top: "-1000px",
  });
  copyFrom.text(text);
  $('body').append(copyFrom);
  copyFrom.select();
  document.execCommand('copy');
  alert('Command copied: ' + copyFrom.text(text).text());
}

</script>