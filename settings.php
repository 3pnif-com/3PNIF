<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
    <?php include('common/functions.php');
          include('common/header.php');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// SAVE SETTINGS
if ($_POST["action"] == "save") {
  $refresh = 1;
  $sql = "UPDATE settings SET maxparameters = '".$_POST["maxParameters"]."', maxkeys = '".$_POST["maxKeys"]."', ports = '".$_POST["ports"]."', browser = '".$_POST["browser"]."', conection = '".$_POST["conection"]."' WHERE id = 0";
  if ($conn->query($sql) === TRUE) {
    showToastMessage("Settings updated sucessfully!");
  }
} // END SAVE SETTINGS

// CREATE FULL BACKUP
if ($_POST["action"] == "full_backup") {

  $creationDate = $_POST["creationDate"];
  $dateFile = str_replace("-", "", $creationDate);
  $dateFile = str_replace(":", "", $dateFile);
  $fileNameBackup = "database/fullbackup_" . $dateFile . ".sql";

  $sql = "UPDATE settings SET last_backup = '" . $creationDate . "'";
  $result = $conn->query($sql);

  //shell_exec("del database\fullbackup*.*");
  shell_exec("..\core\mysql\bin\mysqldump.exe -u " . DBUSER . " -p" . DBPASS . " --databases " . DBNAME . " > " . $fileNameBackup);

  //$sql = "SELECT * FROM settings WHERE id = 0";
  //$result = $conn->query($sql); 
  //$row = $result->fetch_assoc();
  
  showToastMessage("Backup created successfully!");

} // END CREATE FULL BACKUP

// RESTORE FULL BACKUP
if ($_POST["action"] == "restore_full_backup") {

  $lastbackupDate = $_POST["lastbackupDate"];
  $dateFile = str_replace("-", "", $lastbackupDate);
  $dateFile = str_replace(":", "", $dateFile);
  $dateFile = str_replace(" ", "_", $dateFile);
  $fileNameRestore = "database/fullbackup_" . $dateFile . ".sql";
  //shell_exec("del database\fullbackup*.*");
  shell_exec("..\core\mysql\bin\mysql.exe -u " . DBUSER . " -p" . DBPASS . " --database " . DBNAME . " < " . $fileNameRestore);

  showToastMessage("Backup restored successfully!");

} // END RESTORE FULL BACKUP

// RESTORE SYSTEM DATABASE
if ($_POST["action"] == "restore_system") {

  $lastbackupDate = $_POST["lastbackupDate"];
  $fileNameRestoreSystem = "database/_system.sql";
  //shell_exec("del database\fullbackup*.*");
  shell_exec("..\core\mysql\bin\mysql.exe -u " . DBUSER . " -p" . DBPASS . " --database " . DBNAME . " < " . $fileNameRestoreSystem);

  //$sql = "UPDATE settings SET last_backup = '" . $lastbackupDate . "'";
  $result = $conn->query($sql);

  showToastMessage("System restored successfully!");

} // END RESTORE SYSTEM DATABASE

// CLEAN DATABSE
if ($_POST["action"] == "clean") {

  $lastbackupDate = $_POST["lastbackupDate"];
  $fileNameClean = "database/_structure.sql";
  //shell_exec("del database\fullbackup*.*");
  shell_exec("..\core\mysql\bin\mysql.exe -u " . DBUSER . " -p" . DBPASS . " --database " . DBNAME . " < " . $fileNameClean);

  $sql = "UPDATE settings SET last_backup = '" . $lastbackupDate . "'";
  $result = $conn->query($sql);

  showToastMessage("Clean database successfully!");

} // END CLEAN DATABASE
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main animate-bottom" style="margin-left:270px;margin-top:43px;">
  <?php showPageTitle('Settings','fa-cog'); ?>

  <div class="w3-container">
    <div class="w3-row-padding w3-margin-bottom" style="margin-right: 20px;">
      <?php if ($refresh==1) { ?>
        <script type="text/javascript"> window.location.href="Settings.php?tab=Settings"; </script>
      <?php $refresh = 0; } ?>
      <div class="w3-container w3-white w3-card-4 w3-padding-16">
        <div class="w3-row-padding">
          
          <a href="explore.php" target="_blank"><i class="fa fa-folder-open fa-fw fa-2x"></i> Explore Apache Web Root Directory (www)</a>
          <?php showSubTitle('Add New Tool:'); ?>
          <div class="w3-row" style="padding-bottom: 5px;">
            <div class="w3-quarter">
              <p style="text-align: right; margin: 3px 5px;">Max Parameters:</p>
            </div>
            <div class="w3-threequarter">
              <input name="maxParameters1" type="text" id="maxParameters1" style="width:300px;" value="<?php echo MAX_PARAMETERS; ?>" />
            </div>
          </div>
          <div class="w3-row" style="padding-bottom: 5px;">
            <div class="w3-quarter">
              <p style="text-align: right; margin: 3px 5px;">Max XML Keys:</p>
            </div>
            <div class="w3-threequarter">
              <input name="maxKeys1" type="text" id="maxKeys1" style="width:300px;" value="<?php echo MAX_KEYS; ?>" />
            </div>
          </div>

          <?php showSubTitle('Pentest:'); ?>
          <div class="w3-row" style="padding-bottom: 5px;">
            <div class="w3-quarter">
              <p style="text-align: right; margin: 3px 5px;">Default ports for Service:</p>
            </div>
            <div class="w3-threequarter">
              <input name="ports1" type="text" id="ports1" style="width:300px;" value="<?php echo PORTS_NUMBERS; ?>" />
            </div>
          </div>

          <?php showSubTitle('Browser portable:'); ?>
          <div class="w3-row" style="padding-bottom: 5px;">
            <div class="w3-quarter">
              <p style="text-align: right; margin: 3px 5px;">Executable file:</p>
            </div>
            <div class="w3-threequarter">
              <input name="browser1" type="text" id="browser1" style="width:300px;" value="<?php echo BROWSER; ?>" />
            </div>

            <form>
              <input type="file">
            </form>
            <script>
              $(":file").change(function(){
                $("#file1").val() = $(":file").val();
              });
            </script>
          </div>

          <?php showSubTitle('Conection test:'); ?>
          <div class="w3-row" style="padding-bottom: 5px;">
            <div class="w3-quarter">
              <p style="text-align: right; margin: 3px 5px;">Example with:</p>
            </div>
            <div class="w3-threequarter">
              <input name="conection1" type="text" id="conection1" style="width:300px;" value="<?php echo CONECTION_TEST; ?>" />
            </div>
          </div>

          <?php showSubTitle('Database:');
           $creationDate = date('Y-m-d_H:i:s'); ?>

          <?php $sql = "SELECT * FROM settings WHERE id = 0";
          $result = $conn->query($sql); 
          $row = $result->fetch_assoc(); ?>

          <div class="w3-row" style="padding-left: 15px;">
            <div style="display: flex;">

              <!-- BACKUP DATABASE -->
              <button style="margin: 0 10px 0 0;" onclick="document.getElementById('formbackup').style.display='block'" class="w3-btn w3-orange" onclick="document.getElementById('pro').style.display='block';"><i class='fa fa-download'></i>Backup</button>

              <div id="formbackup" class="w3-modal"> <!-- por omissão: display: none -->
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="padding: 20px;max-width:330px; border-radius: 10px;">
                  <div class="w3-center" style="padding-top: 10px;">
                    <h5>Backup database?</h5>
                    <form method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                      <input type="hidden" name="action" value="full_backup"> 
                      <input type="hidden" name="creationDate" value="<?php echo $creationDate; ?>">
                      <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formbackup').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                      <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formbackup').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- RESTORE DATABASE -->
              <?php if ($row['last_backup'] !="0000-00-00 00:00:00") { ?>
                <button style="margin: 0 10px;" onclick="document.getElementById('formrestore').style.display='block'" class="w3-btn w3-orange" onclick="document.getElementById('pro').style.display='block';"><i class='fa fa-upload'></i>Restore</button>
               <?php } ?>

               <div id="formrestore" class="w3-modal"> <!-- por omissão: display: none -->
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="padding: 20px;max-width:330px; border-radius: 10px;">
                  <div class="w3-center" style="padding-top: 10px;">
                    <h5>Restore database from last backup?</h5>
                    <form method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                      <input type="hidden" name="action" value="restore_full_backup">
                      <input type="hidden" name="lastbackupDate" value="<?php echo $row['last_backup']; ?>">
                      <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formrestore').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                      <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formrestore').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- RESTORE SYSTEM DATABASE -->
              <button style="margin: 0 10px; width: 200px;" onclick="document.getElementById('formrestoresystem').style.display='block'" class="w3-btn w3-orange" onclick="document.getElementById('pro').style.display='block';"><i class='fa fa-cogs'></i>Restore System</button>
 
              <div id="formrestoresystem" class="w3-modal"> <!-- por omissão: display: none -->
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="padding: 20px;max-width:330px; border-radius: 10px;">
                  <div class="w3-center" style="padding-top: 10px;">
                    <h5>Restore database to default System Tools and Models?</h5>
                    <form method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                      <input type="hidden" name="action" value="restore_system"> 
                      <input type="hidden" name="lastbackupDate" value="<?php echo $row['last_backup']; ?>">
                      <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formrestoresystem').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                      <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formrestoresystem').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- CLEAN DATABASE -->
              <button style="margin: 0 10px;" onclick="document.getElementById('formclean').style.display='block'" class="w3-btn w3-orange" onclick="document.getElementById('pro').style.display='block';"><i class='fa fa-eraser'></i>Clean</button>
 
              <div id="formclean" class="w3-modal"> <!-- por omissão: display: none -->
                <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="padding: 20px;max-width:330px; border-radius: 10px;">
                  <div class="w3-center" style="padding-top: 10px;">
                    <h5>Clean database with no data and only the structure?</h5>
                    <form method="post" class="w3-container" action="<?php $_PHP_SELF ?>" style="padding-bottom: 20px;">
                      <input type="hidden" name="action" value="clean">
                      <input type="hidden" name="lastbackupDate" value="<?php echo $row['last_backup']; ?>">
                      <button style="width: 100px;" class="w3-btn w3-orange" type="submit" onclick="document.getElementById('formclean').style.display='none'; document.getElementById('pro').style.display='block'"><i class='fa fa-check-circle'></i>Yes</button>
                      <button style="width: 100px;" type="button" class="w3-btn w3-orange" onclick="document.getElementById('formclean').style.display='none'"><i class='fa fa-times-circle'></i>No</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- LAST BACKUP INFO -->
            <?php if ($row['last_backup'] !="0000-00-00 00:00:00") {
                echo "<div style='margin: 10px 0;'><strong>Last backup: </strong>" . $row['last_backup'] . "</div>";
              } else { echo "<div style='margin: 10px 0;'><strong>Last backup: </strong>Not created.</div>"; } ?>
          </div>

           <!-- - Backup estrutura no-data
           ..\core\mysql\bin\mysqldump --add-drop-table --no-data -u root -ppass 3pnifdb > file.sql -->

        <form method="post" action="<?php $_PHP_SELF ?>">
          <input type="hidden" name="action" value="save">
          <input type="hidden" name="maxParameters" id="maxParameters" value="">
          <input type="hidden" name="maxKeys" id="maxKeys" value="">
          <input type="hidden" name="ports" id="ports" value="">
          <input type="hidden" name="browser" id="browser" value="">
          <input type="hidden" name="conection" id="conection" value="">
          
          <button style="margin-top: 13px;" type="submit" class="w3-btn w3-orange" onclick="document.getElementById('pro').style.display='block'; actionSave();"><i class='fa fa-check-circle'></i>Save</button>
        </form>

      </div>
    </div>
  </div>

  <script type="text/javascript">
    function actionSave(that) {

    // Quando botão Save pressionado, especifica os valores do form       
    document.getElementById("maxParameters").value = $("#maxParameters1").val();
    document.getElementById("maxKeys").value = $("#maxKeys1").val();
    document.getElementById("ports").value = $("#ports1").val();
    document.getElementById("browser").value = $("#browser1").val();
    document.getElementById("conection").value = $("#conection1").val();

    //document.getElementById("file").value= $("#models :selected").val();

    }

  </script>

</div>
</body>
</html>
