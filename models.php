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

  $sql = "DELETE FROM models WHERE id=$id";
  if ($conn->query($sql) === TRUE) {
    showToastMessage("Model deleted successfully!");
  }
} // END DELETE BY ID

// EDIT BY ID
if ($_POST["action"] == "edit") {
  $edit = 2; // valor 2 para quando vem do botão New Tool
  if (isset($_POST["id"])) {
    $edit = 1; // valor 1 se vier do botão Edit, na tabela
    $id = $_POST["id"];

    $sql = "SELECT * FROM models WHERE id = $id";
    $result = $conn->query($sql); 
    $row = $result->fetch_assoc();

    $namee = $row['name'];
    $descriptione = $row['description'];
    $idtoolse = $row['idtools'];
    $commandse = $row['commands'];
    $commandse = str_replace("\\\\n","\\n", $commandse);
    $commandse = str_replace("\\\\r","\\r", $commandse);
    $commandse = str_replace("\\\\t","\\t", $commandse);
    $commandse = str_replace("\\\\a","\\a", $commandse);
    $notese = $row['notes'];
    $reservede = $row['reserved'];
    $alerte = $row['alert'];
  }
} // END EDIT MODEL BY ID

// ADD MODEL
if ($_POST["action"] == "add") {
  $name = $_POST["name"];
  $description = $_POST["description"];
  $idtools = $_POST["idtools"];
    // If exists, remove last value array $idtools, with nothing: \n
  if (end($idtools) == '') {
    array_pop($idtools);
  }
  $commands = $_POST["commandsadded"];
  $commands = str_replace("\\n","\\\\n", $commands);
  $commands = str_replace("\\r","\\\\r", $commands);
  $commands = str_replace("\\t","\\\\t", $commands);
  $commands = str_replace("\\a","\\\\a", $commands);
  $commands = str_replace("\\","\\\\", $commands);
    // If exists, remove last value array $commands, with nothing: \n
  if (end($commands) == '') {
    array_pop($commands);
  }
  $notes = $_POST["notes"];
  $reserved = $_POST["reserved"];
  $alert = $_POST["alert"];

  $sql = "INSERT INTO models (user, name, description, idtools, commands, notes, reserved, alert) VALUES ('" . USER . "', '" . $name . "', '" . $description . "', '" . $idtools . "', '" . $commands . "', '" . $notes . "', '" . $reserved . "', '" . $alert . "')";

  if ($conn->query($sql) === TRUE) { 
    showToastMessage("Model added successfully!");
  }
} // END ADD MODEL

// UPDATE MODEL
if ($_POST["action"] == "update") {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $idtools = $_POST["idtools"];
  $commands = $_POST["commandsadded"];
  $commands = str_replace("\\n","\\\\n", $commands);
  $commands = str_replace("\\r","\\\\r", $commands);
  $commands = str_replace("\\t","\\\\t", $commands);
  $commands = str_replace("\\a","\\\\a", $commands);
  $commands = str_replace("\\","\\\\", $commands);
  $notes =  $_POST["notes"];
  $reserved =  $_POST["reserved"];
  $alert =  $_POST["alert"];

  $sql = "UPDATE models SET name = '".$name."', description = '".$description."', idtools = '".$idtools."', commands = '".$commands."', notes = '".$notes."', reserved = '".$reserved."', alert = '".$alert."' WHERE id = $id";
  if ($conn->query($sql) === TRUE) {
    showToastMessage("Model updated sucessfully!");
  }

  // Button click Edit from Pentest
  if (isset($_POST["windowFromEdit"])) { ?>
    <script>
      window.open('','_self').close();
    </script>
  <?php }

} // END UPDATE MODEL ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" id="toHideSize" style="margin-left:270px; margin-top:43px;">

  
  <?php if ($edit == 0) { ?>
    <?php showPageTitle('Models » List','fa-list-alt'); ?>

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
              $sql = "SELECT id, date, user, name, description, reserved FROM models ORDER BY date DESC";
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
                  $reserved = $row['reserved'];
                  echo "<tr>";
                  echo "<td><strong>$count</strong> &nbsp; &nbsp; $name</td>";
                  echo "<td>$description</td>";
                  echo "<td>$user</td>";
                  echo "<td>$date</td>";
                   // ICON TRASH DELETE / EDIT         
                  echo "<td>"; ?>

                    <button onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='block'" class="w3-button w3-large"><i class="fa fa-trash-o"></i></button>

                    <button class="w3-button w3-large" type="submit" form="formedit<?php echo $id; ?>" onclick="document.getElementById('pro').style.display='block'"><i class="fa fa-pencil-square-o"></i></button>

                    <form id="formedit<?php echo $id; ?>" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding: 20px; display: none;">
                      <input name="id" type="hidden" value="<?php echo $id; ?>">
                      <input name="action" type="hidden" value="edit"> 
                    </form>

                    <div id="formdel<?php echo $id; ?>" class="w3-modal"> <!-- por omissão: display: none -->
                      <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:330px; border-radius: 10px;">
                        <div class="w3-center" style="padding-top: 10px;">
                          <h5>Delete model?</h5>
                          <form id="form" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                            <input name="id" type="hidden" value="<?php echo $id; ?>">
                            <input name="action" type="hidden" value="delete">
                            <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                            <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formdel<?php echo $id; ?>').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                          </form>
                        </div>
                      </div>
                    </div><?php 
                  if ($reserved == 1) { ?> 
                    <button class="w3-button" style="cursor: default; overflow: unset;"><i class="tooltip fa fa-cogs"><span class="tooltiptext" style="width: 150px; margin-left: -75px;"><p style="margin: 5px 0;">System Model</p></span></i></button>
                  <?php }

                  echo "</td>";
                  echo "</tr>";
                  $count++;
                }
              echo "</tbody>";
            echo "</table><br>";
          } else { // New Model ?>
          <?php if ($edit == 1 ) { showPageTitle('Models » Edit','fa-list-alt'); }
          else {showPageTitle('Models » New','fa-list-alt'); } ?>
          <div class="w3-container">
          <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
            <div class="w3-container w3-white w3-card-4 w3-padding-16">
            <div>
            <form id="toHide" method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="background-color: #ffa366; border-radius: 14px; margin-bottom: 20px; padding: 10px;">
              <button class="w3-btn w3-orange" type="submit"><i class='fa fa-list-ul'></i>Show List</button>
            </form>

            <?php //FORM ADD MODEL ?>
            
            <div class="w3-row">
              <div class="w3-row-padding">

                <?php showSubTitle('Model:'); ?>    
                <!-- SYSTEM MODEL -->
                <div class="w3-row" style="padding-left: 15px;">
                  <input type="checkbox" id="reserved1" <?php if ($reservede == 1) { echo "checked='checked'"; } ?> >&nbsp&nbspSystem 
                </div>
                <br>   
                <div class="w3-quarter">
                  <input type="text" name="name1" id="name1" placeholder="Name" value="<?php if ($edit == 1) { echo $namee; } ?>">
                </div>
                <div class="w3-half">
                  <input type="text" name="description1" id="description1" placeholder="Description" value="<?php if ($edit == 1) { echo $descriptione; } ?>"> 
                </div>
              </div>
            </div>
            <div class="w3-row">
              <div class="w3-row-padding" style="padding-top: 3px;">
                <div class="w3-quarter" style="display: inline-flex; padding-bottom: 10px;">
                </div>
                <?php // ******************************
                // ******* BUILD COMMAND 

                $sql = "SELECT id, name, description, type, file, domain, wincmd, supportxml, xmlparam, alert FROM tools ORDER BY name ASC";
                $result = $conn->query($sql); ?>

                <?php // CHOOSE TOOL
                showSubTitle('Build command:'); ?>
                <div class="w3-row-padding">
                  <div class="w3-row">
                    <div class="w3-threequarter">
                      Tool: <select onchange="toolChange(this);" id="tools1" name="tools1">
                        <option value="none">Select...</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                          <option style="width: 20px;" type="<?php echo $row['type']; ?>" file="<?php echo $row['file']; ?>" domain="<?php echo $row['domain']; ?>" wincmd="<?php echo $row['wincmd']; ?>" value="<?php echo $row['id']; ?>" alert="<?php echo $row['alert']; ?>"><?php if ($row['type'] == "file") { echo $row['file']; } else { echo $row['domain']; } echo " (".$row['name']." - ".$row['description'] .")"; ?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <!-- EDIT TOOL -->
                    <div class="w3-quarter" style="padding-left: 5px; padding-top: 21px;">
                      <form target="result" method="post" class="w3-container" action="Tools.php?tab=Tools" style="padding: 0;" onsubmit="window.open('','result','width=844,height=680');">
                        <input name="idtool" id="idtool" type="hidden" value="">
                        <input name="action" type="hidden" value="edit">
                        <input name="windowFromEdit" type="hidden">
                        <button class="w3-button" style="padding: 0px;"><i id="edittool" style="color: #FF6400 ;display: none; margin: 7px 10px;" class='fa fa-pencil-square-o fa-lg'></i></button>
                      </form>             
                    </div>
                  </div>
                </div>
              
                <!-- Form começa aqui porque tem outro form anterior -->
                <form method="post" action="<?php $_PHP_SELF ?>">
                  <input type="hidden" name="name" id="name" value="">
                  <input type="hidden" name="description" id="description" value="">
                  <input type="hidden" name="tools" id="tools" value="">
                  <input type="hidden" name="reserved" id="reserved" value="">
                  <input type="hidden" name="alert" id="alert" value="<?php if ($edit == 1) { echo $alerte; } ?>">

                  <?php // CHOOSE PARAMETER
                  $sql = "SELECT id, name, params, paramsval, paramsdesc FROM tools ORDER BY name ASC";
                  $result = $conn->query($sql); ?>
                  <div class="w3-row-padding">
                    <div class="w3-row">
                      <div class="w3-threequarter" style="padding-top: 3px;">
                        Parameter: <select id="parameters" name="parameters" disabled>
                        <option parvalue="none">Select tool...</option>
                        <?php while ($row = $result->fetch_assoc()) {
                          $i = 0;
                          $params = json_decode($row['params']);
                          $paramsval = json_decode($row['paramsval']);
                          $paramsdesc = json_decode($row['paramsdesc']);

                          while ($i < count($params, true)) {
                            if ($paramsval[$i] == "none") { $paramsval[$i] = ""; }?>
                            <option value1="<?php echo $row['id']; ?>" value="<?php echo $params[$i]; ?>" parvalue="<?php if ($paramsval[$i] != "") echo $paramsval[$i]; else echo "none"; ?>"><?php echo $params[$i] . " " . $paramsval[$i] ." (".$paramsdesc[$i] .")"; ?></option>
                            <?php $i++;
                          } 
                        } ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="w3-row-padding">
                    <div class="w3-row">
                      <button class="w3-btn w3-orange" id="buttonAdd" onclick="addCommand(); return false;" style="margin-top: 13px;" disabled><i style="color: white; margin: 0 3px 0 0;" class='fa fa fa-plus-circle'></i> Command</button>
                    </div>
                  </div>

                  <?php showSubTitle('Commands:'); ?>
                  <div class="w3-threequarter"> 
                    <code><textarea rows="8" name="commandsadded" id="commandsadded"><?php if ($edit == 1) { echo $commandse; } ?></textarea></code>
                  </div>

                  <i onclick="delLine(document.getElementById('commandsadded'));" style="margin-left: -30px;color:<?php echo COLOR_ORANGE; ?>" class="tooltip fa fa-times-circle fa-lg"><span class="tooltiptext" style="width: 350px; margin-left: -175px;"><p style="margin: 5px 0;">Delete selected line</p></span></i>

                  <!-- NOTES -->
                  <?php showSubTitle('Notes:'); ?>
                  <div class="w3-threequarter">
                    <textarea name="notes" placeholder="Notes" style="width: 93%;"><?php if ($edit == 1) { echo $notese; } ?></textarea>
                  </div>

                  <!-- ID and IDTOOLS hidden -->
                  <input name="id" type="hidden" value="<?php echo $id; ?>">
                  <textarea name="idtools" id="idtools" style="display: none;"><?php if ($edit == 1) { echo $idtoolse; } ?></textarea>

                  <div class="w3-row">
                    <!-- VERIFICA CONDIÇÃO PARA ADD OU UPDATE -->
                    <?php if ($edit == 1) {

                      echo "<input name='action' type='hidden' value='update'>";

                      if (isset($_POST["windowFromEdit"])) { 
                        echo "<input name='windowFromEdit' type='hidden'>";
                      } ?>

                      <button class="w3-btn w3-orange" type="submit" onclick="addValues(); document.getElementById('pro').style.display='block'; checkReserved(); "style="margin-top: 13px;"><i class='fa fa-plus-circle'></i>Update</button> 

                    <?php } else {
                      echo "<input name='action' type='hidden' value='add'>"; ?>
                      <button class="w3-btn w3-orange" type="submit" onclick="addValues(); document.getElementById('pro').style.display='block'; checkReserved(); "style="margin-top: 13px;"><i class='fa fa-plus-circle'></i>Add</button>
       
                    <?php } ?>

                    <button id="toHide" class="w3-btn w3-orange" onclick="window.location='Models.php?tab=Models'; return false;" style="margin-top: 13px;"><i class='fa fa-times-circle'></i>Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          <?php } ?>
        </div>
        <?php $edit = 0; $conn->close();

        // Button click Edit from Pentest
        if (isset($_POST["windowFromEdit"])) { ?>
          <script>
            windowFromEdit();
          </script>
        <?php }?>

      </div>
    </div>
  </div>

  <script type="text/javascript">

    function  toolChange(that) {
      if (that.value == "none") {
        document.getElementById("parameters").disabled = true;
        //document.getElementById("xmlkeys").disabled = true;
        document.getElementById("buttonAdd").disabled = true;
      } else {
        document.getElementById("parameters").disabled = false; 
        //document.getElementById("xmlkeys").disabled = false;
        document.getElementById("buttonAdd").disabled = false; 
      }

      document.getElementById("idtool").value = $("#tools1 :selected").val();
      if ($("#tools1 :selected").val() == "none" ) {
        document.getElementById("edittool").style.display = "none";
      } else {
        document.getElementById("edittool").style.display = "block";
      }

      document.getElementById("tools").value = $("#tools1").val();
    }

    // Check if input is checked for SYSTEM MODEL
    function checkReserved() {
      document.getElementById("reserved").value = ($('#reserved1').is(":checked")) ? 1 : 0;
    }

    function addValues() {
      document.getElementById("name").value = $("#name1").val();
      document.getElementById("description").value = $("#description1").val();
    }

    function addCommand() {

      if ($("#tools1 :selected").attr("alert") == "1") {
        document.getElementById('alert').value = 1;
      } else {
        if (document.getElementById('alert').value != 1) {
          document.getElementById('alert').value = 0;
        }
      }

      var id = $("#tools1 :selected").val();

      if ($("#tools1 :selected").attr("file") != "") {
        var tool = $("#tools1 :selected").attr("file") + " ";
      } else {
        if ($("#tools1 :selected").attr("domain") != "") {
          var tool = $("#tools1 :selected").attr("domain"); // Domain é tudo seguido, no link...
        } else {
          var tool = $("#tools1 :selected").attr("wincmd") + " ";
        }
      }

      var param = $("#parameters :selected").val();

      // Se a tool não tem valor de parâmetro
      if ($("#parameters :selected").attr("parvalue") == "none") {
        var parvalue = "";
      } else {
        if (($("#tools1 :selected").attr("type") == "domain") && ($("#parameters :selected").attr("parvalue") == "domain")) {
          var parvalue = $("#parameters :selected").attr("parvalue");
        } else {
          var parvalue = " " + $("#parameters :selected").attr("parvalue");
        }
      }

      // Construção do comando final a adicionar
      command = tool + param + parvalue;
      // analisa se existe já um parâmetro igual para juntar ao comando
      var linesCommandsAdded = $("#commandsadded").val().split('\n');
      var linesIdTools = $("#idtools").val().split('\n');

      // Loop through all lines
      for (var j = 0; j < linesCommandsAdded.length; j++) {
        // se contem já o param e tool (os 2 pois param pode ser = a outra tool, n faz nada
        if (linesCommandsAdded[j].indexOf(param) >= 0 && linesCommandsAdded[j].indexOf(tool) >= 0) {
          if (linesCommandsAdded[j] == command) {
            command = "";
            //id = "";
          } else {
            if (linesCommandsAdded[j].indexOf(parvalue) >= 0 ) {
               command = "";
               id = "";
             } else {
              command = linesCommandsAdded[j] + parvalue;
              // remove a linha igual anterior
              linesCommandsAdded.splice(j,1);
              linesIdTools.splice(j,1);
              // populate textarea
              document.getElementById("commandsadded").value = linesCommandsAdded.join("\n");
              document.getElementById("idtools").value = linesIdTools.join("\n");
            }    
          }          
          break;
        }    
      }
      if (command != "") {
        document.getElementById("commandsadded").value += command + "\n";
        document.getElementById("idtools").value += id + "\n";
      }
    }

    // Button lick to delete line in Textarea "CommandsAdded" and "IdTools"
    function delLine(textarea) {
      var line = textarea.value.substr(0, textarea.selectionStart).split("\n").length;
      //console.log("Line Click: " + line);

      // Remove linha onse se encontra o cursor
      var linesCommandsAdded = $("#commandsadded").val().split('\n');
      var linesIdTools = $("#idtools").val().split('\n');

      // Loop through all lines
      for (var j = 0; j < linesCommandsAdded.length; j++) {
        // se contem já o param e tool (os 2 pois param pode ser = a outra tool, n faz nada
        lineCommand = j + 1;
        //console.log("line command: " + lineCommand);
        if (line == lineCommand) {
          // remove a linha
          linesCommandsAdded.splice(j,1);
          linesIdTools.splice(j,1);

          // populate textarea
          document.getElementById("commandsadded").value = linesCommandsAdded.join("\n");
          document.getElementById("idtools").value = linesIdTools.join("\n");
        }    
      }          
    }

    // FILTRA PELO ID SELECIONADO DE TOOLS, OS PARAMETERS
    $("#tools1").change(function() {
      var id = $(this).val();

      if ($(this).data('options1') == undefined) {
        $(this).data('options1', $('#parameters option').clone());
      }
      var options1 = $(this).data('options1').filter('[value1=' + id + ']'); 
      $('#parameters').html(options1);

    });

    // Reaload page when close child window
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }

  </script>

</div>

</body>
</html>