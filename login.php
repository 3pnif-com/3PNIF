<!DOCTYPE html>
<html>
  <head>
    <?php include('common/vars.php'); ?>
  </head>
  <?php include('common/functions.php');

  $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
  if(isset($_REQUEST['submit_button']))
      {
        
        //CONSULTA DO UTILIZADOR

        $sql="SELECT * FROM users WHERE user='" . $_POST['user'] . "' AND pass='" . sha1($_POST['pass']) . "'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        if ($row > 0) //SE O USER E A PASSWORD COINCIDIREM
        {

          // actualiza data ultimo login com sucesso
          $sql="UPDATE users SET last_login='" . date('Y:m:d H:i:s') . "' WHERE user='" . $_POST['user'] . "'";
          $result = $conn->query($sql);

          $_SESSION['USER']=$_POST['user'];

          echo '<script type="text/javascript"> window.location = "index.php?tab=Overview" </script>';        
        } else { $error = TRUE; }
      } ?>

  <!-- !PAGE CONTENT! -->
  <?php // Waiting spinner for login page: document.getElementById('pro').style.display='block'"
  processing(); ?>

  <div class="content" style="max-width: 700px; margin: auto; background: none; padding: 10px; text-align: center; margin: 0; position: absolute; top: 30%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
    <img src='images/logo/logo-name.png'/>

    <?php show3PNIFTitle(); ?>
    
    <br> 

      <form id="form" method="post" action="">
        <input style="margin: 0 1px; background: rgb(250, 255, 189); visibility:visible; width:300px; height: 40px; border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: solid; border-left-color: #FF6400; border-left-width: 3px;" type="text" name="user" id="user" placeholder="User" value="<?php echo DEFAULTUSER; ?>">
        <p style="margin: 5px;"></p>
        <input style="margin: 0 1px; padding: 12px 20px; background: rgb(250, 255, 189); visibility:visible; width:300px; height: 40px;  border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: solid; border-left-color: #FF6400; border-left-width: 3px;" type="password" name="pass" id="pass" placeholder="Password"  value="<?php echo DEFAULTPASSWORD; ?>">
        <i id="eye" onmousedown="document.getElementById('pass').type='text'" onmouseup="document.getElementById('pass').type='password'" onmouseover="document.getElementById('eye').style.color='#FF6400'" onmouseout="document.getElementById('eye').style.color='#ffc299'" class="fa fa-eye fa-lg" style="color: #ffc299; cursor: pointer; margin: 13px 0 0 -30px; position: absolute;"></i>
        <p></p>
        <button class="button" type="submit" name="submit_button" onclick="document.getElementById('pro').style.display='block'">OK</button>
      </form>
    <?php $conn->close();

    if ($error) { echo "<br><div style='background: red; color: white; width: 300px; margin: 0 auto;'>$message_error</div>"; }
    else { echo "<br><div>&nbsp;</div>"; } ?>
      
    </div>
    <div class="w3-bottom" style="font-size: 12px; margin-bottom: 20px; text-align: center; width: 100%;">
      <strong><?php showFooter(); ?></strong>
    </div>
  </body>
</html>