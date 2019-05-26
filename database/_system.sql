-- MySQL dump 10.13  Distrib 5.6.35, for Win32 (AMD64)
--
-- Host: localhost    Database: 3pnifdb
-- ------------------------------------------------------
-- Server version	5.6.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `3pnifdb`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `3pnifdb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `3pnifdb`;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `last_export` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `idtools` tinytext NOT NULL,
  `commands` text NOT NULL,
  `notes` text NOT NULL,
  `reserved` tinyint(11) NOT NULL,
  `alert` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,'2019-04-02 21:39:52','user','Model CP-1','Modelo para Caso Prático Amb. Doméstico','27\r\n27\r\n34\r\n','nmap\\\\nmap.exe -sP network\r\nnmap\\\\nmap.exe -p service host\r\nsysteminfo ','Modelo para deteção de equipamentos na rede, estados portos locais e systeminfo.',1,0),(2,'2019-04-08 22:27:56','user','Model CP-2','Modelo para Caso Prático Amb. Doméstico','28\r\n42\r\n43\r\n43\r\n43\r\n43\r\n43\r\n','https://crt.sh/?q=%domain\r\nwhois.exe -v -nobanner domain\r\nnslookup domain\r\nnslookup -type=ns domain\r\nnslookup -type=soa domain\r\nnslookup -type=mx domain\r\nnslookup -type=any domain\r\n','Modelo para obter informação de domínios web num ambiente doméstico',1,1),(3,'2019-04-23 11:18:14','user','Model CP-6','Modelo para Caso Prático Amb. Profissional','27\r\n','nmap\\\\nmap.exe -sP network\r\n','',1,0),(4,'2019-04-30 21:04:29','user','Model CP-3','Modelo para Caso Prático Amb. Doméstico','45\r\n45\r\n45\r\n45\r\n46\r\n','Netsh wlan show networks\r\nNetsh wlan show profiles\r\nNetsh wlan show drivers\r\nNetsh wlan show interfaces\r\nWifiInfoView.exe /stab\r\n','Modelo para obter informação das redes sem fios e interfaces num ambiente doméstico',1,0),(5,'2019-05-02 13:22:47','user','Model CP-4','Modelo para Caso Prático Amb. Doméstico','50\r\n50\r\n50\r\n50\r\n52\r\n49\r\n47\r\n','reg query HKLM\\Software\\Microsoft\\Windows\\CurrentVersion\\Run\r\nreg query HKLM\\Software\\Microsoft\\Windows\\CurrentVersion\\Runonce\r\nreg query HKCU\\Software\\Microsoft\\Windows\\CurrentVersion\\Run\r\nreg query HKCU\\Software\\Microsoft\\Windows\\CurrentVersion\\Runonce\r\npslist.exe -nobanner\r\ntasklist /svc\r\nnetstat -ano\r\n','Modelo para obter informações de processos em execução.',1,0);
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pentests`
--

DROP TABLE IF EXISTS `pentests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pentests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `port` tinytext NOT NULL,
  `host` tinytext NOT NULL,
  `network` tinytext NOT NULL,
  `domain` tinytext NOT NULL,
  `notes` text NOT NULL,
  `idmodel` tinyint(4) NOT NULL,
  `commands` text NOT NULL,
  `result` longtext NOT NULL,
  `resultxml` mediumtext NOT NULL,
  `elapsedtime` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pentests`
--

LOCK TABLES `pentests` WRITE;
/*!40000 ALTER TABLE `pentests` DISABLE KEYS */;
/*!40000 ALTER TABLE `pentests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` tinytext NOT NULL,
  `idpentest` int(11) NOT NULL,
  `file` tinytext NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `ports` tinytext NOT NULL,
  `browser` tinytext NOT NULL,
  `maxparameters` tinytext NOT NULL,
  `maxkeys` tinytext NOT NULL,
  `conection` tinytext NOT NULL,
  `last_backup` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (0,'21,22,23,25,53,80,110,143','','10','10','ipleiria.pt','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tools`
--

DROP TABLE IF EXISTS `tools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `description` text NOT NULL,
  `type` tinytext NOT NULL,
  `file` tinytext NOT NULL,
  `domain` tinytext NOT NULL,
  `wincmd` tinytext NOT NULL,
  `params` tinytext NOT NULL,
  `paramsval` tinytext NOT NULL,
  `paramsdesc` tinytext NOT NULL,
  `supportxml` tinyint(1) NOT NULL,
  `typexml` tinytext NOT NULL,
  `xmlparam` tinytext NOT NULL,
  `xmlkeys` tinytext NOT NULL,
  `xmlkeysdesc` tinytext NOT NULL,
  `notes` text NOT NULL,
  `reserved` tinyint(11) NOT NULL,
  `alert` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools`
--

LOCK TABLES `tools` WRITE;
/*!40000 ALTER TABLE `tools` DISABLE KEYS */;
INSERT INTO `tools` VALUES (27,'2018-11-03 15:21:12','user','nmap','O Nmap(“Network Mapper”) é uma ferramenta de segurança usada para detectar computadores e serviços numa rede.','file','nmap\\nmap.exe','','','[\"-p\",\"-p\",\"-sP\",\"-sv\",\"-O\"]','[\"service\",\"host\",\"network\",\"host\",\"host\"]','[\"Indicau00e7u00e3o de portos\",\"Host para anu00e1lise portos\",\"Descoberta de hosts\",\"Programas e versu00e3o nas portas u00e0 escuta\",\"detetar SO\"]',1,'1','-oX','[\"address\",\"hostname\"]','[\"Adress for host\",\"Nome for host\"]','Testes com ferramenta nmap - nmap',1,0),(28,'2018-11-07 23:30:13','user','crt.sh','Display information about TLS/SLL certificates','domain','','https://crt.sh/','','[\"?q=%\"]','[\"domain\"]','[\"Find all information\"]',0,'1','','','','',1,0),(42,'2019-04-08 22:25:25','user','Whois','Performs the registration record for the domain name or IP address that you specify.','file','whois.exe','','','[\"-v -nobanner\"]','[\"domain\"]','[\"Print info for referrals, with no banner\"]',0,'1','','','','',1,0),(43,'2019-04-08 23:03:47','user','Nslookup','Network administration command-line tool for querying DNS','wincmd','','','nslookup','[\"\",\"-type=ns\",\"-type=soa\",\"-type=mx\",\"-type=any\"]','[\"domain\",\"domain\",\"domain\",\"domain\",\"domain\"]','[\"Find A record\",\"Check NS records\",\"Query SOA record\",\"Find MX records\",\"Find all available DNS\"]',0,'1','','','','Nslookup it is a network administration command-line tool for querying Domain Name System (DNS) to obtain domain names or IP addresses, mapping or for any other specific DNS Records.',1,0),(45,'2019-04-29 23:12:42','user','Netsh','Network shell (netsh) is a command-line utility that allows you to configure and display the status of various network communications','wincmd','','','Netsh','[\"wlan show networks\",\"wlan show profiles\",\"wlan show drivers\",\"wlan show interfaces\"]','[\"none\",\"none\",\"none\",\"none\"]','[\"Detects networks\",\"Show networks saved\",\"Show NIC info\",\"Adapter settings\"]',0,'1','','','','',1,0),(46,'2019-04-30 21:01:32','user','WifiInfoView','Scans the wireless networks and displays extensive information.','file','WifiInfoView.exe','','','[\"/stab\"]','[\"none\"]','[\"Tab-delimited text file\"]',1,'0','/sxml','[\"ssid\",\"mac_address\",\"channel\",\"security\",\"maximum_speed\"]','[\"Network name\",\"MAC address\",\"Channel\",\"Secutity type\",\"Maximum speed conection\"]','Save the list of wireless networks into a tab-delimited text file.',1,0),(47,'2019-05-02 12:03:37','user','Netstat','Netstat is a useful tool for checking network and Internet connections. Some useful applications for the average PC user are considered, including checking for malware connections.','wincmd','','','netstat','[\"-ano\",\"-r\",\"-s\",\"-fa\"]','[\"none\",\"none\",\"none\",\"none\"]','[\"List network connections and ports\",\"Display the routing table\",\"Displays per-protocol statistics\",\"Display FQDN for each foreign IP addresses\"]',0,'1','','','','',1,0),(48,'2019-05-02 12:37:14','user','Autorunsc','Show what programs are configured to run during system bootup or login','file','autorunsc.exe','','','[\"-nobanner\"]','[\"none\"]','[\"\"]',0,'0','','','','',1,0),(49,'2019-05-02 12:49:28','user','Tasklist','Displays a list of currently running processes','wincmd','','','tasklist','[\"/svc\"]','[\"none\"]','[\" Displays services hosted in each process.\"]',0,'1','','','','',1,0),(50,'2019-05-03 20:43:31','user','Registry (query)','Display information about specific key of the registry.','wincmd','','','reg query','[\"HKLM\\\\Software\\\\Microsoft\\\\Windows\\\\CurrentVersion\\\\Run\",\"HKLM\\\\Software\\\\Microsoft\\\\Windows\\\\CurrentVersion\\\\Runonce\",\"HKCU\\\\Software\\\\Microsoft\\\\Windows\\\\CurrentVersion\\\\Run\",\"HKCU\\\\Software\\\\Microsoft\\\\Windows\\\\CurrentVersion\\\\Runonce\"]','[\"none\",\"none\",\"none\",\"none\"]','[\"HKLM Run\",\"HKLM Runonce\",\"HKCU Run\",\"HKCU Runonce\"]',0,'1','','','','',1,0),(52,'2019-05-03 21:50:03','user','PsList','Show statistics for active processes','file','pslist.exe','','','[\"-nobanner\"]','[\"none\"]','[\"\"]',0,'1','','','','',1,0),(53,'2019-05-04 16:35:39','user','PsLoggedOn','Display active logon sessions locally and via resources shares','file','PsLoggedon.exe','','','[\"-nobanner\"]','[\"none\"]','[\"\"]',0,'1','','','','',1,0);
/*!40000 ALTER TABLE `tools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` tinytext NOT NULL,
  `pass` tinytext NOT NULL,
  `level` tinytext NOT NULL,
  `last_login` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'2018-08-19 23:05:00','user','068726bfdabf4eaef616c12d5ea39b604daf3765','admin','2019-05-13 18:05:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-05-21  0:11:42
