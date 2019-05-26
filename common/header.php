
<?php if (!isset($_SESSION['USER'])) //SE NÃO EXISTIR AUTENTICAÇÃO
{ ?>
  <div class="content" style="max-width: 700px; margin: auto; background: none; padding: 10px; text-align: center; margin: 0; position: absolute; top: 30%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
    <img src='images/logo/logo-name.png'/>
    <?php show3PNIFTitle(); ?>
    <br>

    <h1 style="background: red; color: white;"><strong><?php echo $message_restricted_area; ?></strong></h1>
    <div><?php echo $message_redirect_login; ?></div>
    <strong><div id="counter">5</div></strong>
    <script>
        var count = 5;
        setInterval(function(){
            if (count > 0) {
              count--;
              document.getElementById('counter').innerHTML = count;
              if (count == 1) { window.location = 'login.php'; }
            } 
        },1000);
    </script>
   <!--  <button class="button" onclick="location.href='login.php'">Login</button> -->

  </div>
  <div class="w3-bottom" style="font-size: 12px; margin-bottom: 20px; text-align: center; width: 100%;">
    <strong><?php showFooter(); ?></strong>
  </div>
  <?php exit(); } ?>

<!-- onkeydown para desativar a tecla F5 - Refresh  onkeydown="return (event.keyCode != 116)" -->
<body class="w3-light-grey">

  <?php // Waiting spinner for all pages: document.getElementById('pro').style.display='block'"
  processing(); ?>

  <!-- SCROLL TO TOP -->
  <button onclick="$('html, body').animate({scrollTop:0}, 'slow')" id="gotoTop" title="Go to top"><i style="color: white;" class="fa fa-arrow-circle-up fa-2x"></i></button>
  <span class="back-to-top" style="display: none;">Back to Top</span>

  <!-- Full Screen -->
  <script src="js/screenfull.js"></script>
  <script src="js/jquery2.0.3.min.js"></script>

  <!-- JAVASCRIPT FUNCTIONS -->
  <script type="text/javascript">
    
    // SCROLL TO TOP
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() { scrollFunction() };
    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("gotoTop").style.display = "block";
      } else {
        document.getElementById("gotoTop").style.display = "none";
      }   
    }
  </script>

  <div class="w3-bar w3-top w3-black w3-large" id="toHide" style="z-index:4; border: 0px; border-bottom: #FF6400; border-style: double;">
    <a href="index.php?tab=Overview">
      <div>
        <span class="w3-bar-item w3-left"> 
            <img src='images/logo/logo-name.png' style="margin-left: 20px;" />
        </span>
        <span class="w3-bar-item w3-left" style="color:black;">
          <?php show3PNIFTitle();
          check_version(); ?>
        </span>
      </div>
    </a>

    <table style="float: right;">
      <!-- USERNAME -->
      <tr>
        <td id="user" class="w3-button" style="display: flex; cursor: pointer; padding: 18px 16px!important; background-color: white!important;">
          <div class="dropdown">
            <button class="dropbtn"><i id="iconuser"class="fa fa-user-circle-o fa-fw fa-2x"></i><strong style="vertical-align: super;"><?php echo " " . USER . "&nbsp;&nbsp;"; ?></strong><i style="vertical-align: super;" class="fa fa-chevron-down fa-1"></i></button>

              <div class="dropdown-content" style="border:1px solid #FF6400; position: fixed; margin-left: 25px; text-align: left;">

                <a id="account" onmouseover="document.getElementById('account').style.color='#FF6400';" onmouseleave="document.getElementById('account').style.color='black';" style="font-size: 15px;" href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;&nbsp;Account</a>
                <a id="setting" onmouseover="document.getElementById('setting').style.color='#FF6400';" onmouseleave="document.getElementById('setting').style.color='black';"style="font-size: 15px;" href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-cog"></i>&nbsp;&nbsp;Setting</a>

                <a id="logout" onmouseover="document.getElementById('logout').style.color='#FF6400';" onmouseleave="document.getElementById('logout').style.color='black';"style="font-size: 15px;" href="logout.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-power-off"></i>&nbsp;&nbsp;Logout</a>
              </div>
          </div>
        </td>
        <td>
          <!-- ICON FULL SCREEN -->
          <div class="full-screen">
            <section class="full-top">
              <button onclick="toggleFullScreen();" onmouseover="document.getElementById('toggle').style.color='#FF6400'; document.getElementById('icon').classList.add('fa-2x')" onmouseleave="document.getElementById('toggle').style.color='black'; document.getElementById('icon').classList.remove('fa-2x')" id="toggle"><i id="icon" class="fa fa-arrows fa-lg" aria-hidden="true"></i></button>  
            </section>
          </div>
        </td>
      </tr>
    </table>
  </div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="width:250px;margin-top: -46px;" id="mySidebar">

  <div class="w3-bar-block">
    <hr>

    <table style="width: 100%">
      <?php 
      //OVERVIEW
      showItemMenu('Overview','','fa-tachometer'); 
      // TOOLS
      showItemMenu('Tools','','fa-wrench');
      // MODELS
      showItemMenu('Models','','fa-list-alt');
      // PENTEST
      showItemMenu('Pentests','','fa-shield');
      // REPORTS
      showItemMenu('Reports','','fa-file-text-o');
      //DISCOVER NETWORK
      /* showItemMenu('Discover Network','Dnetwork','fa-share-alt fa-rotate-90'); */
      // LOCAL INFORMATION
      showItemMenu('Local Information','localinfo','fa-info-circle');
      // HISTORY
      showItemMenu('History','','fa-history');
      // SETTINGS
      showItemMenu('Settings','','fa-cog');
      // ABOUT
      showItemMenu('About','','fa-question-circle');
      // INTERNET
      showItemMenu('Internet','','Internet');
      ?>
    </table>

  </div>
  <div class="w3-bottom" style="font-size: 12px; margin: 10px 0;text-align: center;width: 250px;">
    <hr style="margin: 0px;"><strong>
    <?php showFooter(); ?>Template by <a href="https://www.w3schools.com/" target="_blank">W3Schools</a></strong>
  </div>
</nav>

<!-- Adiciona class w3-blue (laranja) ao menu selecionado no Dashboard -->
<script type="text/javascript">
  var tab = getQueryVariable("tab");
  document.getElementById(tab).classList.add("w3-blue");
  document.getElementById("icon"+tab).style.color = "white";
  function getQueryVariable(variable) {   
    var query = window.location.search.substring(1);
    if (!query) { return "Overview"; }
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable) { return pair[1]; }
    }
    return(false);
  }

function toggleFullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    
   (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if (document.documentElement.requestFullScreen) {  
      document.documentElement.requestFullScreen();  
    } else if (document.documentElement.mozRequestFullScreen) {  
      document.documentElement.mozRequestFullScreen();  
    } else if (document.documentElement.webkitRequestFullScreen) {  
      document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);  
    }  
  } else {  
    if (document.cancelFullScreen) {  
      document.cancelFullScreen();  
    } else if (document.mozCancelFullScreen) {  
      document.mozCancelFullScreen();  
    } else if (document.webkitCancelFullScreen) {  
      document.webkitCancelFullScreen();  
    }  
  }  
}

</script>