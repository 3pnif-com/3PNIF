<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
    <?php include('common/functions.php');
          include('common/header.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// DELETE BY ID
if ($_POST["action"] == "delete") {
  $id = $_POST["id"];

  $sql = "DELETE FROM tools WHERE id=$id";

  // APAGA FICHEIRO, CASO TOOL TYPE == FILE
  if ($_POST["type"] == "file") {
     unlink(TOOLS . $_POST["file"]);
  }
 
  if ($conn->query($sql) === TRUE) {
    showToastMessage("Tool deleted successfully!");
  }
} // END DELETE BY ID

// EDIT BY ID
if ($_POST["action"] == "edit") {
  $edit = 2; // valor 2 para quando vem do botão New Tool
  if (isset($_POST["id"]) || isset($_POST["idtool"])) {
    $edit = 1; // valor 1 se vier do botão Edit, na tabela
    if ($_POST["id"] == "" ) { $id = $_POST["idtool"]; }
    else { $id = $_POST["id"]; } 

    $sql = "SELECT * FROM tools WHERE id=$id";
    $result = $conn->query($sql); 
    $row = $result->fetch_assoc();

    $namee = $row['name'];
    $descriptione = $row['description'];
    $typee = $row['type'];
    $filee = $row['file'];
    $domaine = $row['domain'];
    $wincmde = $row['wincmd'];
    $paramse = json_decode($row['params']);
    $paramsvale = json_decode($row['paramsval']);
    $paramsdesce = json_decode($row['paramsdesc']);
    $supportxmle = $row['supportxml'];
    if ($supportxmle == "1") {
      $xmlparame = $row['xmlparam'];
      $xmlkeyse = json_decode($row['xmlkeys']);
      $xmlkeysdesce = json_decode($row['xmlkeysdesc']);
    } else {
      $xmlparame = "";
      $xmlkeyse = "";
      $xmlkeysdesce = "";
    }
    $typexmle = $row['typexml'];
    $notese = $row['notes'];
    $reservede = $row['reserved'];
    $alerte = $row['alert'];
  }
} // END EDIT TOOL BY ID

// ADD TOOL
if ($_POST["action"] == "add") {
  $name = $_POST["name"];
  $description = $_POST["description"];
  $type = $_POST["type"];
  $params = str_replace("\\","\\\\", $_POST["params"]);
  $params = json_encode($params);
  $paramsval = json_encode($_POST["paramsval"]);
  $paramsdesc = json_encode($_POST["paramsdesc"]);
  $supportxml = $_POST["supportxml"];
  if ($supportxml == "1") {
    $xmlparam = $_POST["xmlparam"];
    $xmlkeys = json_encode($_POST["xmlkeys"]);
    $xmlkeysdesc = json_encode($_POST["xmlkeysdesc"]);
  } else {
    $xmlparam = "";
    $xmlkeys = "";
    $xmlkeysdesc = "";
  }
  $typexml = $_POST["typexml"];
  $notes = $_POST["notes"];
  $reserved = $_POST["reserved"];
  $alert = $_POST['alert'];

  if ($type == "file") {
    $file = $_FILES["fileToUpload"]["name"];
    $domain = "";
    $wincmd = "";
    $target_file = TOOLS . $file;
    // Check if file already exists
    if (file_exists($target_file)) {
      showToastMessage("Tool file already exists!");
    } else {
      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
      $sql = "INSERT INTO tools (user, name, description, type, file, domain, wincmd, params, paramsval, paramsdesc, supportxml, typexml, xmlparam, xmlkeys, xmlkeysdesc, notes, reserved, alert) VALUES ('" . USER . "', '" . $name . "', '" . $description . "', '" . $type . "', '" . $file . "', '" . $domain . "', '" . $wincmd . "', '" . $params . "', '" . $paramsval . "', '" . $paramsdesc . "', '" . $supportxml . "', '" . $typexml . "', '" . $xmlparam . "', '" . $xmlkeys . "', '" . $xmlkeysdesc . "', '" . $notes . "', '" . $reserved . "', '" . $alert . "')";
    }
  } else {
    if ($type == "domain") {
      $file = "";
      $domain = $_POST["domain"];
      $wincmd = "";
      $sql = "INSERT INTO tools (user, name, description, type, file, domain, wincmd, params, paramsval, paramsdesc, supportxml, typexml, xmlparam, xmlkeys, xmlkeysdesc, notes, reserved, alert) VALUES ('" . USER . "', '" . $name . "', '" . $description . "', '" . $type . "', '" . $file . "', '" . $domain . "', '" . $wincmd . "', '" . $params . "', '" . $paramsval . "', '" . $paramsdesc . "', '" . $supportxml . "', '" . $typexml . "', '" . $xmlparam . "', '" . $xmlkeys . "', '" . $xmlkeysdesc . "', '" . $notes . "', '" . $reserved . "', '" . $alert . "')";
    } else {
      $file = "";
      $domain = "";
      $wincmd = $_POST["wincmd"];
      $sql = "INSERT INTO tools (user, name, description, type, file, domain, wincmd, params, paramsval, paramsdesc, supportxml, typexml, xmlparam, xmlkeys, xmlkeysdesc, notes, reserved, alert) VALUES ('" . USER . "', '" . $name . "', '" . $description . "', '" . $type . "', '" . $file . "', '" . $domain . "', '" . $wincmd . "', '" . $params . "', '" . $paramsval . "', '" . $paramsdesc . "', '" . $supportxml . "', '" . $typexml . "', '" . $xmlparam . "', '" . $xmlkeys . "', '" . $xmlkeysdesc . "', '" . $notes . "', '" . $reserved . "', '" . $alert . "')";
    }
  }
  if ($conn->query($sql) === TRUE) {
    showToastMessage("Tool added successfully!");
  }
} // END ADD TOOL

// UPDATE TOOL
if ($_POST["action"] == "update") {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $type = $_POST["type"];
  $params = str_replace("\\","\\\\", $_POST["params"]);
  $params = json_encode($params);
  $paramsval = json_encode($_POST["paramsval"]);
  $paramsdesc = json_encode($_POST["paramsdesc"]);
  $supportxml = $_POST["supportxml"];
  if ($supportxml == "1") {
    $xmlparam = $_POST["xmlparam"];
    $xmlkeys = json_encode($_POST["xmlkeys"]);
    $xmlkeysdesc = json_encode($_POST["xmlkeysdesc"]);
  } else {
    $xmlparam = "";
    $xmlkeys = "";
    $xmlkeysdesc = "";
  }
  $typexml = $_POST["typexml"];
  $notes =  $_POST["notes"];
  $reserved = $_POST["reserved"];
  $alert = $_POST["alert"];

  if ($type == "file") {
    $file = $_FILES["fileToUpload"]["name"];
    $domain = "";
    $wincmd = "";
    // Se o ficheiro não foi atualizado, UPDATE sem file
    if ($file == "") {
      $sql = "UPDATE tools SET name = '".$name."', description = '".$description."', type = '".$type."', domain = '".$domain."', wincmd = '".$wincmd."', params = '".$params."', paramsval = '".$paramsval."', paramsdesc = '".$paramsdesc."', supportxml = '".$supportxml."', typexml = '".$typexml."', xmlparam = '".$xmlparam."', xmlkeys = '".$xmlkeys."', xmlkeysdesc = '".$xmlkeysdesc."', notes = '".$notes."', reserved = '".$reserved."', alert = '".$alert."' WHERE id = $id";
    } else {
      $target_file = TOOLS . $file;
      // Check if file already exists
      if (file_exists($target_file)) {
        showToastMessage("Tool file already exists!");
      } else {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $sql = "UPDATE tools SET name = '".$name."', description = '".$description."', type = '".$type."', file = '".$file."', domain = '".$domain."', wincmd = '".$wincmd."', params = '".$params."', paramsval = '".$paramsval."', paramsdesc = '".$paramsdesc."', supportxml = '".$supportxml."', typexml = '".$typexml."', xmlparam = '".$xmlparam."', xmlkeys = '".$xmlkeys."', xmlkeysdesc = '".$xmlkeysdesc."', notes = '".$notes."', reserved = '".$reserved."', alert = '".$alert."' WHERE id = $id";
      }
      // APAGA FICHEIRO ANTIGO
      unlink(TOOLS . $_POST["fileToKeep"]);
    }
  } else {
    if ($type == "domain") {
      $file = "";
      $domain = $_POST["domain"];
      $wincmd = "";

      $sql = "UPDATE tools SET name = '".$name."', description = '".$description."', type = '".$type."', file = '".$file."', domain = '".$domain."', wincmd = '".$wincmd."', params = '".$params."', paramsval = '".$paramsval."', paramsdesc = '".$paramsdesc."', supportxml = '".$supportxml."', typexml = '".$typexml."', xmlparam = '".$xmlparam."', xmlkeys = '".$xmlkeys."', xmlkeysdesc = '".$xmlkeysdesc."', notes = '".$notes."', reserved = '".$reserved."', alert = '".$alert."' WHERE id = $id";

      // APAGA FICHEIRO ANTIGO
      unlink(TOOLS . $_POST["fileToKeep"]);
    } else {
      $file = "";
      $domain = "";
      $wincmd = $_POST["wincmd"];

      $sql = "UPDATE tools SET name = '".$name."', description = '".$description."', type = '".$type."', file = '".$file."', domain = '".$domain."', wincmd = '".$wincmd."', params = '".$params."', paramsval = '".$paramsval."', paramsdesc = '".$paramsdesc."', supportxml = '".$supportxml."', typexml = '".$typexml."', xmlparam = '".$xmlparam."', xmlkeys = '".$xmlkeys."', xmlkeysdesc = '".$xmlkeysdesc."', notes = '".$notes."', reserved = '".$reserved."', alert = '".$alert."' WHERE id = $id";

      // APAGA FICHEIRO ANTIGO
      unlink(TOOLS . $_POST["fileToKeep"]);
    }
  }

  if ($conn->query($sql) === TRUE) {
    showToastMessage("Tool updated successfully!");
  }

  // Button click Edit from Model
  if (isset($_POST["windowFromEdit"])) { ?>
    <script>
      window.open('','_self').close();
    </script>
  <?php }

} // END UPDATE TOOL ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" id="toHideSize" style="margin-left:270px;margin-top:43px;">

  
  <?php if ($edit == 0) { ?>
    <?php showPageTitle('Tools » List','fa-wrench'); ?>

    <div class="w3-container">
      <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
        <div class="w3-container w3-white w3-card-4 w3-padding-16">
          <div>
            <form method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="background-color: #ffa366; border-radius: 14px; margin-bottom: 20px; padding: 10px;">
              <input name="action" type="hidden" value="edit">
              <button class="w3-btn w3-orange" type="submit"><i class='fa fa-plus-circle'></i>New</button>
            </form>
            <?php showFilterTable(""); ?>

            <table class="w3-table w3-bordered w3-border w3-hoverable w3-white" id="table">
              <?php 
              $sql = "SELECT id, date, user, name, description, type, file, reserved FROM tools ORDER BY date DESC";
              $result = $conn->query($sql);
              echo "<thead>";
                echo "<tr>";
                  echo "<th><strong># &nbsp; &nbsp; &nbsp; Name </strong></th>";
                  echo "<th width='35%'><strong> Description </strong></th>";
                  echo "<th><strong> User </strong></th>";
                  echo "<th><strong> Date </strong></th>";
                  echo "<th></th>";
                echo "</tr>";
              echo "</thead>";
              echo "<tbody id='tableList'>";
              $count = 1;
              while ($row = $result->fetch_assoc()) {
                //unset($id, $date, $user, $name, $description);
                $id = $row['id']; 
                $date = $row['date']; 
                $user = $row['user'];
                $name = $row['name'];
                $description = $row['description'];
                $type = $row['type'];
                $file = $row['file'];
                $reserved = $row['reserved'];
                echo "<tr>";
                echo "<td><strong>$count</strong> &nbsp; &nbsp; $name</td>";
                echo "<td>$description</td>";
                echo "<td>$user</td>";
                echo "<td>$date</td>";

                // ICON TRASH DELETE / EDIT
                echo "<td>"; ?>

                <button class="w3-button w3-large" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='block'"><i class="fa fa-trash-o"></i></button>

                <button class="w3-button w3-large" type="submit" form="formedit<?php echo $id; ?>"onclick="document.getElementById('pro').style.display='block'"><i class="fa fa-pencil-square-o"></i></button>

                <form id="formedit<?php echo $id; ?>" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding: 20px; display: none;">
                  <input name="id" type="hidden" value="<?php echo $id; ?>">
                  <input name="action" type="hidden" value="edit"> 
                </form>

                <div id="formdel<?php echo $id; ?>" class="w3-modal"> <!-- por omissão: display: none -->
                  <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:330px; border-radius: 10px;">
                    <div class="w3-center" style="padding-top: 10px;">
                      <h5>Delete tool?</h5>
                      <form id="form" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                        <input name="id" type="hidden" value="<?php echo $id; ?>">
                        <!-- Próximas 2 linhas, para apagar ficheiro caso tool type == file -->
                        <input name="type" type="hidden" value="<?php echo $type; ?>">
                        <input name="file" type="hidden" value="<?php echo $file; ?>">

                        <input name="action" type="hidden" value="delete">
                        <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                        <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                      </form>
                    </div>
                  </div>
                </div> <?php 
                if ($reserved == 1) { ?>
                  <button class="w3-button" style="cursor: default; overflow: unset;"><i class="tooltip fa fa-cogs"><span class="tooltiptext" style="width: 150px; margin-left: -75px;"><p style="margin: 5px 0;">System Tool</p></span></i></button>
                <?php }
    
                echo "</td>";
                echo "</tr>";
                $count++;
              }
              echo "</tbody>";
            echo "</table><br>";
          } else { // New Tool ?>
          <?php 
          if ($edit == 1) { showPageTitle('Tools » Edit','fa-wrench'); }
          else { showPageTitle('Tools » New','fa-wrench'); } ?>
          
          <div class="w3-container">
          <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
            <div class="w3-container w3-white w3-card-4 w3-padding-16">
            <div>
            <form id="toHide" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="background-color: #ffa366; border-radius: 14px; margin-bottom: 20px; padding: 10px;">
              <button class="w3-btn w3-orange" type="submit"><i class='fa fa-list-ul'></i>Show List</button>
            </form>

            <?php //FORM  ?>
            <form method="post" action="<?php $_PHP_SELF ?>" enctype="multipart/form-data" >

              <!-- TOOL -->
              <?php showSubTitle('Tool:'); ?>
              <div class="w3-row">
                <div class="w3-row-padding">
                  <!-- CHECKBOXES -->
                  <div class="w3-row" style="padding-left: 15px;">
                    <!-- SYSTEM TOOL -->
                    <input type="checkbox" id="reserved1" <?php if ($reservede == 1) { echo "checked='checked'"; } ?> >&nbsp&nbspSystem &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <!-- ALERT -->
                    <input type="checkbox" id="alert1" <?php if ($alerte == 1) { echo "checked='checked'"; } ?> >&nbsp&nbspAlert
                  </div>
                  <br>
                  <input type="hidden" name="reserved" id="reserved" value="">
                  <input type="hidden" name="alert" id="alert" value="">

                  <div class="w3-quarter">
                    <input type="text" name="name" placeholder="Name" value="<?php if ($edit == 1) { echo $namee; } ?>">
                  </div>
                  <div class="w3-half">
                    <input type="text" name="description" placeholder="Description" value="<?php if ($edit == 1) { echo $descriptione; } ?>">
                  </div>
                </div>
              </div>
              <div class="w3-row">
                <div class="w3-row-padding" style="padding-top: 3px;">
                  <div class="w3-quarter" style="display: inline-flex; padding-bottom: 10px;">
                    <select id="typetool" onchange="typeToolChange(this);">
                      <option value="file">File</option>
                      <option value="domain">Domain</option>
                      <option value="wincmd">Win Command</option>
                    </select>
                  </div>
                  <input type="hidden" name="type" id="type" value="<?php if ($edit == 1) { echo $typee; } else { echo "file"; } ?>"> 

                  <div class="w3-quarter">
                    <?php if ($edit == 1 && $typee == "file") { ?>
                      <input type="text" name="fileToKeep" id="fileToKeep" value="<?php echo $filee; ?>" readonly style="background: rgb(235, 235, 228);">
                    <?php } else { ?>
                      <input type="text" name="fileToKeep" id="fileToKeep" style="display: none;">
                    <?php } ?>
                  </div>

                  <div class="w3-half">
                    <input type="file" name="fileToUpload" id="fileToUpload" style="padding: 3px 2px;">
                    <input type="text" name="domain" id="domain" placeholder="Domain" value="<?php if ($edit == 1) { echo $domaine; } ?>" style="display: none;">
                    <input type="text" name="wincmd" id="wincmd" placeholder="Win Command" value="<?php if ($edit == 1) { echo $wincmde; } ?>" style="display: none;">
                  </div>

                </div>
              </div>

              <?php showSubTitle('Parameters:'); ?>
              <!-- PARAMETERS -->
              <div class="container1 w3-row-padding">  
                <div class="w3-quarter">
                  <button style="margin: 10px 8px 10px; width:180px;" class="add_parameter_field">Add New Parameter &nbsp; <span style="font-size:16px; font-weight:bold;">+ </span></button>
                </div>
                  <?php if ($edit == 1) {
                    $i = 0;
                    while ($i < count($paramse, true)) {
                      echo "<div class='w3-row-padding' style='padding-top: 3px;'>";
                        echo" <div class='w3-quarter'>";
                          echo "<input type='text' name='params[]' value='$paramse[$i]'>";
                        echo "</div>";
                        echo "<div class='w3-quarter'>";
                          echo "<select name='paramsval[]'>";
                            echo "<option value='none'"; if ($paramsvale[$i] == "none") { echo " selected='selected'>Value?"; } else { echo ">Value?"; } echo "</option>";
                            echo "<option value='service'"; if ($paramsvale[$i] == "service") { echo " selected='selected'>Service"; } else { echo ">Service"; } echo "</option>";
                            echo "<option value='host'"; if ($paramsvale[$i] == "host") { echo " selected='selected'>Host"; } else { echo ">Host"; } echo "</option>";
                            echo "<option value='network'"; if ($paramsvale[$i] == "network") { echo " selected='selected'>Network"; } else { echo ">Network"; } echo "</option>";
                            echo "<option value='domain'"; if ($paramsvale[$i] == "domain") { echo " selected='selected'>Domain"; } else { echo ">Domain"; } echo "</option>";
                          echo "</select>";
                        echo "</div>";
                        echo" <div class='w3-quarter'>";
                          echo "<input type='text' name='paramsdesc[]' value='$paramsdesce[$i]'>";
                        echo "</div>";
                        if ($i > 0) {
                          echo "<a href='#' class='delete'><i style='color:" . COLOR_ORANGE . "' class='fa fa-times-circle fa-lg' style='margin: 5px 0; font-size: 19px;'></i></a>";
                        }
                      echo "</div>";
                      $i++;
                    } 
                  } else {
                    echo "<div class='w3-row-padding'>";
                      echo" <div class='w3-quarter'>";
                        echo "<input type='text' name='params[]' placeholder='Parameter'>";
                      echo "</div>";
                      echo "<div class='w3-quarter'>";
                        echo "<select name='paramsval[]'>";
                          echo "<option value='none'>Value?</option>";
                          echo "<option value='service'>Service</option>";
                          echo "<option value='host'>Host</option>";
                          echo "<option value='network'>Network</option>";
                          echo "<option value='domain'>Domain</option>";
                        echo "</select>";
                      echo "</div>";
                      echo "<div class='w3-quarter'>";
                        echo "<input type='text' name='paramsdesc[]' placeholder='Description'>";
                      echo "</div>";
                    echo "</div>";
                  } ?>
              </div>
              <?php showSubTitle('Output:'); ?>
              <div class="w3-row-padding">

                <!-- OUTPUT -->
                <div class="w3-quarter">
                  <p style="margin: 3px 0px 0px 8px;">Support XML?&nbsp;&nbsp;
                    <input onclick="checkSupportXML()" type="radio" name="supportxml" value="1" 
                    <?php if ($supportxmle == "1") { echo "checked='checked'"; } ?>
                    >&nbsp;Yes&nbsp;&nbsp;&nbsp;
                    <input onclick="checkSupportXML()" type="radio" name="supportxml" value="0"
                    <?php if ($supportxmle == "0") { echo "checked='checked'"; } if ($supportxmle == "") { echo "checked"; } ?> 
                    id="supportXMLNo">&nbsp;No

                  </p>
                </div>
                
                <div class="w3-quarter">
                  <input style="margin-left: 4px; display: none;" type="text" id="paramxml" name="xmlparam" placeholder="Parameter" value="<?php if ($edit == 1) { echo $xmlparame; } ?>">
                </div>

                <div class="w3-quarter" id="typexml" style="display: none;">
                  <p style="margin: -6px 0px 0px 8px;">XML Data in:<br>
                    <input type="radio" name="typexml" value="1" 
                    <?php if ($typexmle == "1") { echo "checked='checked'"; } ?> checked>&nbsp;Attributes&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="typexml" value="0"
                    <?php if ($typexmle == "0") { echo "checked='checked'"; } ?> >&nbsp;Child Elements
                  </p>
                </div>
              </div>

              <div class="container2 w3-row-padding" id="containerXMLKey" style="display: none;">
                <div class="w3-quarter">
                  <button style="margin: 10px 8px 10px; width:180px;" class="add_key_field">Add New Key &nbsp; <span style="font-size:16px; font-weight:bold;">+ </span></button>
                </div>
                  <?php if ($edit == 1) {
                    $i = 0;
                    while ($i < count($xmlkeyse, true)) {
                      echo "<div class='w3-row-padding' style='padding-top: 3px;'>";
                        echo" <div class='w3-quarter'>";
                          echo "<input type='text' name='xmlkeys[]' value='$xmlkeyse[$i]'>";
                        echo "</div>";
                        echo "<div class='w3-half'>";
                          echo "<input type='text' name='xmlkeysdesc[]' value='$xmlkeysdesce[$i]'>";
                        echo "</div>";
                        if ($i > 0) {
                          echo "<a href='#' class='delete'><i style='color:" . COLOR_ORANGE . "' class='fa fa-times-circle fa-lg' style='margin: 5px 0; font-size: 19px;'></i></a>";
                        }
                      echo "</div>";
                      $i++;
                    }
                  } else {
                    echo "<div class='w3-row-padding'>";
                      echo "<div class='w3-quarter'>";
                        echo "<input type='text' name='xmlkeys[]' placeholder='Key'>";
                      echo "</div>";
                      echo "<div class='w3-half'>";
                        echo "<input type='text' name='xmlkeysdesc[]' placeholder='Description'>";
                      echo "</div>";
                    echo "</div>";
                  } ?>              
              </div>

              <!-- Caso  Edit = 1 verifica condição de supportXML -->
              <?php if ($edit == 1) { ?>
                <script type="text/javascript">
                  if(document.getElementById("supportXMLNo").checked) {
                     document.getElementById("containerXMLKey").style.display= "none";
                     document.getElementById("paramxml").style.display= "none";
                     document.getElementById("typexml").style.display= "none";
                  } else { document.getElementById("containerXMLKey").style.display= "block";
                  document.getElementById("paramxml").style.display= "block";
                  document.getElementById("typexml").style.display= "block"; }
                </script>
              <?php } ?>

              <?php showSubTitle('Notes:'); ?>
              <div class="w3-row-padding">
                <div class="w3-threequarter">
                  <textarea rows="6" name="notes" placeholder="Notes" style="width: 93%;"><?php if ($edit == 1) { echo $notese; } ?></textarea>
                </div>
              </div>
              <input name="id" type="hidden" value="<?php echo $id; ?>">

              <!-- VERIFICA CONDIÇÃO PARA ADD OU UPDATE -->
              <?php if ($edit == 1) {

                echo "<input name='action' type='hidden' value='update'>"; 

                if (isset($_POST["windowFromEdit"])) { 
                  echo "<input name='windowFromEdit' type='hidden'>";
                } ?>

                <button class="w3-btn w3-orange" type="submit" onclick="document.getElementById('pro').style.display='block'; checkReservedAlert(); "style="margin-top: 13px;"><i class='fa fa-plus-circle'></i>Update</button>

              <?php } else {
                echo "<input name='action' type='hidden' value='add'>"; ?>

                <button class="w3-btn w3-orange" type="submit" onclick="document.getElementById('pro').style.display='block'; checkReservedAlert(); "style="margin-top: 13px;"><i class='fa fa-plus-circle'></i>Add</button>
 
              <?php } ?>
              <button id="toHide" class="w3-btn w3-orange" onclick="window.location='Tools.php?tab=Tools'; return false;" style="margin-top: 13px;"><i class='fa fa-times-circle'></i>Cancel</button>
            </form>
          <?php } $conn->close();

          // Button click Edit from Model
          if (isset($_POST["windowFromEdit"])) { ?>
            <script>
              windowFromEdit();
            </script>
          <?php }?>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

// Add new Parameter ou new Key
$(document).ready(function() {
    var max_parameters   = <?php echo MAX_PARAMETERS; ?>;
    var max_keys         = <?php echo MAX_KEYS; ?>;
    var wrapper1         = $(".container1");
    var wrapper2         = $(".container2");
    var add_button1      = $(".add_parameter_field");
    var add_button2      = $(".add_key_field");
    var p = 1;
    var k = 1;
    $(add_button1).click(function(e){
      e.preventDefault();
      if(p < max_parameters){
          p++;
          $(wrapper1).append('<div class="w3-row-padding" style="padding-top: 3px;"><div class="w3-quarter"><input type="text" name="params[]" placeholder="Parameter"></div><div class="w3-quarter"><select name="paramsval[]"><option value="none">Value?</option><option value="service">Service</option><option value="host">Host</option><option value="network">Network</option><option value="domain">Domain</option></select></div><div class="w3-quarter"><input type="text" name="paramsdesc[]" placeholder="Description"></div><a href="#" class="delete"><i style="color:<?php echo COLOR_ORANGE; ?>" class="fa fa-times-circle fa-lg" style="margin: 5px 0; font-size: 19px;"></i></a></div></div>');
      }
      else { alert('You reached the limit: <?php echo MAX_PARAMETERS; ?> parameters') }
    });

    $(add_button2).click(function(e){
      e.preventDefault();
      if(k < max_keys){
          k++;
          $(wrapper2).append('<div class="w3-row-padding" style="padding-top: 3px;"><div class="w3-quarter"><input type="text" name="xmlkeys[]" placeholder="Key"></div><div class="w3-half"><input type="text" name="xmlkeysdesc[]" placeholder="Description"></div><a href="#" class="delete"><i style="color:<?php echo COLOR_ORANGE; ?>" class="fa fa-times-circle fa-lg" style="margin: 5px 0; font-size: 19px;"></i></a></div></div>');
      }
      else { alert('You reached the limit: <?php echo MAX_KEYS; ?>  keys') }
    });
  
    $(wrapper1).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); p--;
    })

    $(wrapper2).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); k--;
    })

    document.getElementById("typetool").value = $("#type").val();
    typeToolChange(document.getElementById("typetool"));

});

// Check if input is checked for SYSTEM TOOL
function checkReservedAlert() {
  document.getElementById("reserved").value = ($('#reserved1').is(":checked")) ? 1 : 0;
  document.getElementById("alert").value = ($('#alert1').is(":checked")) ? 1 : 0;
}

// Chech if radiobutton for Output Support XML is No
function checkSupportXML() {
  if(document.getElementById("supportXMLNo").checked) {
     document.getElementById("containerXMLKey").style.display= "none";
     document.getElementById("paramxml").style.display= "none";
     document.getElementById("typexml").style.display= "none";
  } else { document.getElementById("containerXMLKey").style.display= "block";
  document.getElementById("paramxml").style.display= "block";
  document.getElementById("typexml").style.display= "block"; }
}

function typeToolChange(that) {

  if (that.value == "file") {
    if (document.getElementById("fileToKeep").value != "") {
      document.getElementById("fileToKeep").style.display = "block";
    } else {
      document.getElementById("fileToKeep").style.display = "none";
    }
    document.getElementById("fileToUpload").style.display = "block";
    document.getElementById("domain").style.display = "none";
    document.getElementById("wincmd").style.display = "none";
  } else {
    if (that.value == "domain") {
      document.getElementById("fileToKeep").style.display = "none";
      document.getElementById("fileToUpload").style.display = "none";
      document.getElementById("domain").style.display = "block";
      document.getElementById("wincmd").style.display = "none";
    } else {
      document.getElementById("fileToKeep").style.display = "none";
      document.getElementById("fileToUpload").style.display = "none";
      document.getElementById("domain").style.display = "none";
      document.getElementById("wincmd").style.display = "block";
    }
  }

  document.getElementById("type").value = $("#typetool :selected").val();
}

// Reaload page when close child window
window.onunload = refreshParent;
function refreshParent() {
  window.opener.location.reload();
}

</script>
</body>
</html>