-- MySQL dump 10.14  Distrib 5.5.44-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: cahyacyb_db
-- ------------------------------------------------------
-- Server version	5.5.42-MariaDB-cll-lve

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES (1,'wahyu','wahyu'),(2,'gudang','gudang');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bayar`
--

DROP TABLE IF EXISTS `bayar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bayar` (
  `id_bayar` int(5) NOT NULL AUTO_INCREMENT,
  `id_order` int(5) NOT NULL,
  `judul` varchar(250) DEFAULT NULL,
  `userName` varchar(20) NOT NULL,
  `foto_transfer` varchar(250) DEFAULT NULL,
  `keterangan` text,
  `tanggal_bayar` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bayar`
--

LOCK TABLES `bayar` WRITE;
/*!40000 ALTER TABLE `bayar` DISABLE KEYS */;
INSERT INTO `bayar` (`id_bayar`, `id_order`, `judul`, `userName`, `foto_transfer`, `keterangan`, `tanggal_bayar`, `status`) VALUES (4,20,'konfirmasi transfer','sukmo','Screenshot_1.jpg','gan sudah ditransfer ','2015-09-16',1),(8,25,'udah ditransfer gan','jokowi','arus data.jpg','segera dikirim','2015-09-18',1),(9,26,'sidiasda','suro','dc.jpg','asaassda','2015-09-18',1),(10,27,'asddfasf','suro','dc.jpg','dsafasff','2015-09-18',1),(11,28,'afaf','suro','arus data.jpg','sacfasc','2015-09-18',1),(12,29,'sudah dikirim','eka','dc.jpg','cepat dikirim','2015-09-18',0),(13,30,'fafaj','joko','arus data.jpg','skafnlank','2015-09-18',1);
/*!40000 ALTER TABLE `bayar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `halaman`
--

DROP TABLE IF EXISTS `halaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `halaman` (
  `id_halaman` int(5) NOT NULL AUTO_INCREMENT,
  `judul_halaman` varchar(250) NOT NULL,
  `isi_halaman` text NOT NULL,
  PRIMARY KEY (`id_halaman`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `halaman`
--

LOCK TABLES `halaman` WRITE;
/*!40000 ALTER TABLE `halaman` DISABLE KEYS */;
INSERT INTO `halaman` (`id_halaman`, `judul_halaman`, `isi_halaman`) VALUES (1,'Hubungi Kami','Silahkan hubungi kami melalui \r\nHP : 0898127121<br>\r\nEmail : info@cahyacyber.co.id'),(2,'Cara Pembayaran','Pembeli setelah melakukan pemesanan barang dapat melakukan pembayaran melalui transfer bank, melalui ATM.\r\nUntuk pembayaran melalui:\r\nBank BCA\r\nBCA\r\nKCP Kota metro\r\nNo. Rek. : 5035 010201\r\n\r\nBank Mandiri\r\nBANK MANDIRI\r\nKCP Kota metro\r\nNo. Rek. : 070-00-0500364-0\r\nAtas Nama CV.CMMandiri. \r\nPembayaran harus dilakukan secara penuh .\r\nSemua biaya yang tercantum menggunakan mata uang Rupiah Indonesia.\r\nPesanan akan diproses setelah CV. Cahya Mulya Mandiri menerima pembayaran.\r\nSetelah melakukan proses transfer, mohon konfirmasikan transfer dengan mengirimkan bukti pembayaran.');
/*!40000 ALTER TABLE `halaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_barang`
--

DROP TABLE IF EXISTS `kategori_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_barang` (
  `id_kategori` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(250) NOT NULL,
  `foto_kategori` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_barang`
--

LOCK TABLES `kategori_barang` WRITE;
/*!40000 ALTER TABLE `kategori_barang` DISABLE KEYS */;
INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`, `foto_kategori`) VALUES (1,'Laptop','laptop.jpg'),(2,'Komputer','komputer.jpg'),(3,'Printer',NULL),(4,'Alat komputer',NULL);
/*!40000 ALTER TABLE `kategori_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_barang`
--

DROP TABLE IF EXISTS `list_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_barang` (
  `id_barang` int(5) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(5) NOT NULL,
  `nama_barang` varchar(250) NOT NULL,
  `foto_barang` varchar(250) DEFAULT NULL,
  `deskripsi_barang` text,
  `stok` int(5) NOT NULL,
  `tanggal_input` date DEFAULT NULL,
  `harga_barang` varchar(100) NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_barang`
--

LOCK TABLES `list_barang` WRITE;
/*!40000 ALTER TABLE `list_barang` DISABLE KEYS */;
INSERT INTO `list_barang` (`id_barang`, `id_kategori`, `nama_barang`, `foto_barang`, `deskripsi_barang`, `stok`, `tanggal_input`, `harga_barang`) VALUES (1,1,'Acer Aspire One','15lenovo-9079-25597-1-zoom.jpg','Dijual acer',1,'2015-09-10','5000000'),(2,2,'Asus K430 I','56asus.jpg','Asus Ram 1 GB Hardisk 90GB',2,'2015-09-13','5000000'),(3,3,'Asus K430 A','64asus-9605-88418-1-.jpg','Asus Murah',2,'2015-09-13','9000000'),(4,1,'Asus A435','56asus.jpg','Asus',6,'2015-09-13','5000000'),(5,2,'Lenovo','15lenovo-9079-25597-1-zoom.jpg','Lenovo',10,'2015-09-13','7000000'),(6,3,'Acer ','gambarkosong.jpg','Acewr',7,'2015-09-13','8000000'),(7,3,'Acer Aspire One','small_15lenovo-9079-25597-1-zoom.jpg',NULL,5,NULL,'9000000'),(8,3,'Printer Cannon','76Epson L210 (32).jpg','Printer',85,NULL,'500000'),(9,3,'1212891','small_15lenovo-9079-25597-1-zoom.jpg','jsakjsa',89,'2015-09-13','9000'),(10,3,'Printer Epson','752.jpg','Printer Epson',7,'2015-09-13','800.000'),(11,4,'Pembersih Laptop','11185441_763878333709729_1986222637_n.jpg','Pembersih',1,'2015-09-13','60000');
/*!40000 ALTER TABLE `list_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(5) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  `passPass` varchar(20) NOT NULL,
  `nama_lengkap` varchar(30) DEFAULT NULL,
  `foto_profil` varchar(250) DEFAULT NULL,
  `alamat` text,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` int(12) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`, `userName`, `passPass`, `nama_lengkap`, `foto_profil`, `alamat`, `email`, `no_hp`, `tanggal_daftar`) VALUES (1,'Kos','kostumer','kostumer','kostumer.jpg','kostumer','kostumer@gmail.com',817621211,'2015-09-09'),(2,'joni','masuk123','Joni Iskandar','bePn4lUUtTkhF-N41P3d6pZQFbL4oW0dDHH37ZwRIoo.png','Joni Jalan jalan','joni@gmail.com',2147483647,'2015-09-15'),(3,'Dedi','masuk123','Dedi','Screenshot_1.jpg','hashajs','j@aska.com',1929812911,'2015-09-15'),(4,'monyet','monyet','Monyet','aneh.jpg','Monyet','moynyr@gmail.com',2147483647,'2015-09-15'),(5,'','','sukoco','veby.jpg','ahsaks','in@mas.com',2903232,'2015-09-15'),(6,'susu','susu','susu','baby.jpg','susu','susu@gmail.com',2147483647,'2015-09-15'),(7,'wahyu','wahyu','Wahyu Sukmo','Screenshot_4.jpg','aus','aas@gmail.com',99899233,'2015-09-15'),(8,'sukmo','sukmo','sukmo','no-image.jpg','sukmo','sukmo@hs.com',283921372,'2015-09-16'),(9,'jokowi','masukin','jokowidodo','no-image.jpg','jakarta','lalaal@sfs.com',98721,'2015-09-18'),(10,'suro','masukin','surodi','no-image.jpg','jalan ahmad yani','suro@gmail.com',876262722,'2015-09-18'),(11,'eka','12345','eka aja','no-image.jpg','lampung','eka@gmail.com',983525323,'2015-09-18'),(12,'joko','masuk123','ari aja','no-image.jpg',NULL,'afaskfl@com',9240104,'2015-09-18');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_order`
--

DROP TABLE IF EXISTS `user_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_order` (
  `id_order` int(5) NOT NULL AUTO_INCREMENT,
  `userName` varchar(20) NOT NULL,
  `id_barang` int(5) NOT NULL,
  `jumlah_order` int(5) NOT NULL,
  `tanggal_order` date NOT NULL,
  `jam_order` time DEFAULT NULL,
  `status_order` int(1) NOT NULL,
  `total_bayar` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_order`
--

LOCK TABLES `user_order` WRITE;
/*!40000 ALTER TABLE `user_order` DISABLE KEYS */;
INSERT INTO `user_order` (`id_order`, `userName`, `id_barang`, `jumlah_order`, `tanggal_order`, `jam_order`, `status_order`, `total_bayar`) VALUES (1,'1',1,2,'2015-09-13','08:15:01',0,NULL),(2,'1',1,1,'2015-09-13','08:25:03',0,NULL),(3,'1',1,1,'2015-09-13','08:26:16',0,NULL),(4,'1',1,2,'2015-09-13','09:17:43',1,NULL),(22,'sukmo',1,2,'2015-09-16','09:27:41',0,'10000000'),(25,'jokowi',3,1,'2015-09-18','07:06:13',1,'9000000'),(26,'suro',4,1,'2015-09-18','08:23:51',1,'5000000'),(28,'suro',8,1,'2015-09-18','09:39:47',1,'500000'),(29,'eka',3,1,'2015-09-18','10:09:28',0,'9000000'),(30,'joko',8,2,'2015-09-18','11:00:29',0,'1000000');
/*!40000 ALTER TABLE `user_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'cahyacyb_db'
--

--
-- Dumping routines for database 'cahyacyb_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-20 17:33:34
