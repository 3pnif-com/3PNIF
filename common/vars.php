
<?php define('SITE_NAME','3PNIF');
session_start(); ?>

<title><?php echo SITE_NAME; ?></title>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/googlefonts.css">
<link rel="stylesheet" href="css/font-awesome.min.css">

<?php 

// DATABASE MYSQL
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','pass');
define('DBNAME','3pnifdb');

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
$sql = "SELECT * FROM settings WHERE id = 0";
$result = $conn->query($sql); 
$row = $result->fetch_assoc();

define('DEFAULTUSER','user');
define('DEFAULTPASSWORD','resu');

define('USER', $_SESSION['USER']);

define('COLOR_ORANGE','#FF6400');
define('COLOR_BLUE','#2196F3');

define('MAX_PARAMETERS', $row['maxparameters']);
define('MAX_KEYS', $row['maxkeys']);

define('PORTS_TIP','FTP 21, SSH 22, Telnet 23, SMTP 25, DNS 53, HTTP 80, POP3 110 and IMAP 143');
define('PORTS_NUMBERS', $row['ports']);

define('BROWSER', $row['browser']);

define('CONECTION_TEST', $row['conection']);

define('HOST_TIP','You can choose IP from local interface or another.');

define('TOOLS','tools\\');

define('ALERT','The selected model contains one or more checked tools that may cause some service to stop or some other type of unintended and unwanted related constraint.');

// COMANDOS

$convertPDF = TOOLS . 'pnif\OfficeToPDF.exe ';

$new_pentest_cmd_service = 'nmap -p ';
$new_pentest_cmd_host = '';
$new_pentest_cmd_network = '';

$get_local_ips = 'ipconfig | FINDSTR /R "adapter Address.*[0-9][0-9]*\.[0-9][0-9]*\.[0-9][0-9]*\.[0-9][0-9]*"';
$get_network_ips1 = TOOLS . 'nmap\nmap.exe -sP ';
$get_network_ips2 = '/24 | findstr "Nmap scan report"';
$get_network_ports1 = TOOLS . 'nmap\nmap.exe -p ';
$get_network_ports2 = ' -oX ' . TOOLS . 'nmap\scan.xml';

// VARIÁVEIS COMUNS
$msg_wait = "Please wait...";

// LOGIN
$message_restricted_area = 'Reserved page.';
$message_redirect_login = 'You will be redirected to Login page in 5 seconds...';
$message_error = 'Wrong User or Password. Please try again.';

// OVERVIEW - DASHBOARD PRINCIPAL
$overview_title1 = 'Tools'; 
$overview_title2 = 'Models';
$overview_title3 = 'Pentests';
$overview_title4 = 'Reports';
$overview_title5 = 'Other...'; 
$overview_title6 = 'Working time';
$overview_title7 = 'Networks';
$overview_title8 = 'Detected IPs';

// PAGE "NEW PENTEST"
$message_new_pentest = 'Here you are! Let\'s start a new pentest! Please enter some values first!';
$message_new_pentest_names = 'Networks saved';
$message_new_pentest_kind = 'Select destination test: ';
$message_new_pentest_service_placeholder = '20,25,53,80';
$message_new_pentest_host_placeholder = '192.168.1.1';

// PAGE "NEW PENTEST GO"
$message_new_pentest_go_title = 'End of the test';
$message_new_pentest_go_test = 'All done for destination test: ';

// PAGE "DETECT IPS"
$message_detect_ips = 'Provide network address for IP detection:';
$message_detect_ips_placeholder = '192.168.1.0';
$message_detect_ips_name = 'Network name for this detection: ';

// PAGE "DETECT IPS GO"
$message_detect_ips_go_title = 'Detected IPs';
$message_detect_ips_go_list = 'All detected IPs for network: ';
$total_ips = 'Total of hosts: ';

$conn->close();

?>