-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for gracious_garments
DROP DATABASE IF EXISTS `gracious_garments`;
CREATE DATABASE IF NOT EXISTS `gracious_garments` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `gracious_garments`;

-- Dumping structure for table gracious_garments.admin
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(40) NOT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table gracious_garments.admin: ~3 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`AdminID`, `Name`, `Email`, `Password`) VALUES
	(22, 'Dũng', 'dngo5758@gmail.com', 'ba4868b3f277c8e387b55d9e3d0be7c045cdd89e'),
	(33, 'Ngô Bích Hoa', 'chansoo6112exo@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d'),
	(35, 'admin', 'admin007@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table gracious_garments.category
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table gracious_garments.category: ~4 rows (approximately)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`CategoryID`, `Name`, `Visible`) VALUES
	(63, 'Man', 1),
	(64, 'Woman', 1),
	(65, 'Boy', 1),
	(66, 'Girl', 1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Dumping structure for table gracious_garments.customer
DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `CustomerID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Contact` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table gracious_garments.customer: ~2 rows (approximately)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`CustomerID`, `Name`, `Contact`, `Address`, `Email`) VALUES
	(7, 'Dũng', '0981626703', '285 Đội Cấn, Ba Đình, Hà Nội', 'dung.nq.495@aptechlearning.edu.vn'),
	(8, 'Hoa', '0584137059', '285 Đội Cấn, Ba Đình, Hà Nội', 'hoa.nb.475@aptechlearning.edu.vn');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table gracious_garments.image
DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `ImageID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `ImageUrl` varchar(100) NOT NULL,
  PRIMARY KEY (`ImageID`),
  KEY `ProductID` (`ProductID`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=646 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table gracious_garments.image: ~90 rows (approximately)
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` (`ImageID`, `ProductID`, `ImageUrl`) VALUES
	(426, 76, 'namsp1_2.jpg'),
	(427, 76, 'namsp1_3.jpg'),
	(428, 76, 'namsp1_4.jpg'),
	(433, 77, 'namsp2_2.jpg'),
	(435, 77, 'namsp2_4.jpg'),
	(436, 78, 'nusp1_1.jpg'),
	(437, 78, 'nusp1_2.jpg'),
	(438, 79, 'nusp2_1.jpg'),
	(439, 79, 'nusp2_2.jpg'),
	(440, 79, 'nusp2_3.jpg'),
	(441, 80, 'begaisp1_1.jpg'),
	(442, 80, 'begaisp1_2.jpg'),
	(443, 81, 'begaisp2_1.jpg'),
	(444, 81, 'begaisp2_2.jpg'),
	(445, 81, 'begaisp2_3.jpg'),
	(446, 81, 'begaisp2_4.jpg'),
	(447, 82, 'betraisp1_1.jpg'),
	(448, 82, 'betraisp1_2.jpg'),
	(449, 82, 'betraisp1_3.jpg'),
	(451, 84, 'namsp3_1.jpg'),
	(452, 84, 'namsp3_2.jpg'),
	(453, 84, 'namsp3_3.jpg'),
	(454, 85, 'namsp4_1.jpg'),
	(455, 85, 'namsp4_2.jpg'),
	(456, 85, 'namsp4_3.jpg'),
	(457, 86, 'nusp3_1.jpg'),
	(458, 86, 'nusp3_2.jpg'),
	(459, 86, 'nusp3_3.jpg'),
	(460, 87, 'nusp4_1.jpg'),
	(461, 87, 'nusp4_2.jpg'),
	(462, 87, 'nusp4_3.jpg'),
	(465, 83, 'betraisp2_1.jpg'),
	(466, 83, 'betraisp2_2.jpg'),
	(467, 83, 'betraisp2_3.jpg'),
	(468, 89, 'betraisp4_1.jpg'),
	(469, 89, 'betraisp4_2.jpg'),
	(470, 90, 'begaisp3_1.jpg'),
	(471, 90, 'begaisp3_2.jpg'),
	(472, 90, 'begaisp3_3.jpg'),
	(473, 91, 'begaisp4_1.jpg'),
	(474, 91, 'begaisp4_2.jpg'),
	(475, 91, 'begaisp4_3.jpg'),
	(476, 92, 'namsp5_1.jpg'),
	(477, 92, 'namsp5_2.jpg'),
	(478, 92, 'namsp5_3.jpg'),
	(479, 93, 'namsp6_1.jpg'),
	(480, 93, 'namsp6_2.jpg'),
	(481, 93, 'namsp6_3.jpg'),
	(482, 94, 'nusp5_1.jpg'),
	(483, 94, 'nusp5_2.jpg'),
	(484, 94, 'nusp5_3.jpg'),
	(485, 95, 'nusp6_1.jpg'),
	(486, 95, 'nusp6_2.jpg'),
	(487, 95, 'nusp6_3.jpg'),
	(488, 95, 'nusp6_4.jpg'),
	(495, 98, 'begaisp5_1.jpg'),
	(496, 98, 'begaisp5_2.jpg'),
	(497, 99, 'begaisp6_1.jpg'),
	(498, 99, 'begaisp6_2.jpg'),
	(499, 100, 'namsp7_1.jpg'),
	(500, 100, 'namsp7_2.jpg'),
	(501, 101, 'namsp8_1.jpg'),
	(502, 101, 'namsp8_2.jpg'),
	(503, 102, 'nusp7_1.jpg'),
	(504, 102, 'nusp7_2.jpg'),
	(505, 102, 'nusp7_3.jpg'),
	(506, 103, 'nusp8_1.jpg'),
	(507, 103, 'nusp8_2.jpg'),
	(508, 104, 'betraisp7_1.jpg'),
	(509, 104, 'betraisp7_2.jpg'),
	(510, 105, 'betraisp8_1.jpg'),
	(511, 105, 'betraisp8_2.jpg'),
	(512, 105, 'betraisp8_3.jpg'),
	(513, 106, 'begaisp7_1.jpg'),
	(514, 106, 'begaisp7_2.jpg'),
	(515, 106, 'begaisp7_3.jpg'),
	(516, 107, 'begaisp8_1.jpg'),
	(517, 107, 'begaisp8_2.jpg'),
	(518, 107, 'begaisp8_3.jpg'),
	(528, 77, 'namsp2_3.jpg'),
	(529, 76, 'namsp1_1.jpg'),
	(534, 110, 'betraisp5_1.jpg'),
	(535, 110, 'betraisp5_2.jpg'),
	(536, 110, 'betraisp5_3.jpg'),
	(537, 111, 'betraisp6_1.jpg'),
	(538, 111, 'betraisp6_2.jpg'),
	(539, 111, 'betraisp6_3.jpg'),
	(544, 114, 'betraisp8_1.jpg'),
	(545, 114, 'betraisp8_2.jpg'),
	(546, 114, 'betraisp8_3.jpg');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;

-- Dumping structure for table gracious_garments.order
DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `STT` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` varchar(100) NOT NULL,
  `Price` float NOT NULL,
  PRIMARY KEY (`STT`),
  KEY `CustomerID` (`CustomerID`),
  KEY `ProductID` (`ProductID`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  CONSTRAINT `order_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table gracious_garments.order: ~6 rows (approximately)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`STT`, `CustomerID`, `ProductID`, `Quantity`, `Price`) VALUES
	(15, 7, 76, '1', 39),
	(16, 7, 86, '4', 92),
	(17, 7, 91, '2', 38),
	(18, 8, 102, '3', 69),
	(19, 8, 103, '1', 23),
	(20, 8, 91, '2', 38);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;

-- Dumping structure for table gracious_garments.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Price` float NOT NULL,
  `Description` varchar(200) NOT NULL,
  PRIMARY KEY (`ProductID`),
  KEY `CategoryID` (`CategoryID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table gracious_garments.products: ~32 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`ProductID`, `CategoryID`, `Name`, `Price`, `Description`) VALUES
	(76, 63, 'Men\'s polo shirts', 41, 'Plain polyester polo shirt.\r\nRegular phom, polo neck, short sleeve.\r\nSimple design, comfortable, suitable for many situations.\r\nSuitable to wear all year round.\r\nCombined with shorts, jeans, khaki ...'),
	(77, 63, 'Men\'s underwear', 45, 'Smooth shorts, cotton.\r\nRegular form, mezzanine.\r\nElastic waistband, waistband. Cross bag\r\nSimple, comfortable, suitable for many situations.\r\nSuitable to wear all year round.\r\nCombine with T-shirts'),
	(78, 64, 'WOMEN JEANS', 34, 'Elastic cotton jeans long pants.\r\nPhom hugged, long figure.'),
	(79, 64, 'WOMEN\'S JEANS CLOTHING', 34, '61/5000\r\nCotton denim shorts.\r\nRegular phom, short appearance.\r\nFrog jaw pouch.'),
	(80, 66, 'GIRLS BABY GIRLS', 24, 'Plain khaki pants, twill elastic spandex cotton khaki material.\r\nRegular regular, long form.\r\nWaistband. Attached the waistband. Bo bear. Body pockets.\r\nSimple, comfortable, suitable for many situatio'),
	(81, 66, 'BABY GIRL CLOTHES', 34, '\r\nHome wear cotton.\r\nRegular clothes, blouses, shorts.\r\nOpen the back button, hands hanging'),
	(82, 65, 'BABY GIRL CLOTHES', 23, '\r\nHome wear cotton.\r\nRegular cheese, round neck shirt, short sleeves.\r\nPants, waistband.'),
	(83, 65, 'BABY SHIRTS', 23, '\r\nSmooth shirt, linen material. Regular phom, chinese neck, short arm. Buttoned along the body. Chest pocket. Simple, comfortable, polite shirt, suitable for many situations. Suitable to wear all year'),
	(84, 63, 'MEN T-SHIRT', 23, '\r\nCotton T-shirt.\r\nRegular cheese, round neck, short sleeves.\r\nThere are pictures printed.\r\nDynamic design, comfortable. Suitable for many situations.\r\nSuitable for summer wear.\r\nCombined wi'),
	(85, 63, 'T-SHIRT UNISEX MICKEY GO VIETNAM', 23, 'T-shirt unisex mickey go Vietnam'),
	(86, 64, 'T-SHIRT Woman', 23, 'Front printed T-shirt, US cotton.\r\nRegular cheese, round neck, short sleeves.\r\nDynamic design, comfortable. Suitable for many situations\r\nSuitable for summer wear.\r\nCombined with shorts, jeans ... wit'),
	(87, 64, 'T-SHIRT Woman', 23, 'Front printed T-shirt, US cotton.\r\nRegular cheese, round neck, short sleeves.\r\nDynamic design, comfortable. Suitable for many situations\r\nSuitable for summer wear.\r\nCombined with shorts, jeans with sh'),
	(89, 65, 'BABY BOYS CLOTHES', 14, 'Smooth shorts, khaki twisted cotton material.\r\nRegular phom, short appearance.\r\nCross bag Elastic waistband, waistband.'),
	(90, 66, 'POLO BABY GIRLS', 24, 'Cotton polo shirts.\r\nRegular phom, ancient virtues, short-handed.'),
	(91, 66, 'DRESS GIRL', 19, 'Instant dress with print / overflow print.\r\nRegular form, round neck, short sleeves.\r\nSquare pocket.'),
	(92, 63, 'MEN\'S JEANS PANTS', 45, 'Elastic cotton jeans long pants.\r\nPhom hugged, long figure.'),
	(93, 63, 'MEN\'S SHIRTS', 50, 'Checkered shirt, bamboo mixed material.\r\nRegular form, ancient virtue, short arm.'),
	(94, 64, 'DRESS WOMEN', 20, 'Textured dress, cotton.\r\nRegular form, round neck, armpit.\r\nSimple style, comfortable. can wear many circumstances.\r\nSuitable for summer wear.\r\nCan be combined with sandal'),
	(95, 64, 'DRESS WOMEN', 42, '\r\nSkirts in the picture, cotton material US.\r\nRegular form, round neck, short sleeves. Appearance.\r\nRipped ribs.\r\nSimple, comfortable, suitable for many situations.\r\nSuitable to wear all yea'),
	(98, 66, 'DRESSING THE GIRLS IN PICTURE', 34, 'A shape skirt, cotton, printed with princess Elsa image.\r\nRegular cheese, round neck, armpits.\r\nCut skirt parts.\r\nMelodious, feminine, suitable for many situations\r\nCombine sandal, something doll.'),
	(99, 66, 'DRESSING THE GIRLS IN PICTURE', 30, 'Cotton home wear skirt.\r\nShape slender A, round neck, short sleeves.\r\nTie the back of the body.\r\nFeeling comfortable and comfortable to wear at home'),
	(100, 63, 'MEN\'S SHIRT MEN LONG SHIRT', 37, 'Cotton shirt.Regular phom, ancient virtue, long-sleeved. Suitable to wear all year round. Simple and polite design suitable for many situations. Can coordinate with many designs: jeans, khak, lazy sho'),
	(101, 63, 'T-SHIRT MAN', 34, 'Polyester T-shirt with print pattern.\r\nRegular cheese, round neck, long sleeves. Suitable for autumn and winter. Simple design, suitable for many circumstances. Can be combined with jeans, khaki, spor'),
	(102, 64, 'T-SHIRT Woman', 23, 'Plain T-shirt, stretchy polyester material.\r\nRegular form, heart neck, short arm.\r\n'),
	(103, 64, 'WOMEN\'S WOMEN', 23, 'Cotton blend hoodie.\r\nRegular form, long form, hat, long sleeves.\r\nHand-woven lanyard, with pockets on both sides.\r\nSuitable for autumn and winter. Simple design, suitable for many circumstances. Can '),
	(104, 65, 'JACKET  BABY BOY', 24, 'Fur coat made of polyester fabric.\r\nRegular form, with hat, long sleeves, with sides.\r\nLike to combine with each other, collect, optimize. The software combines with felt, jeans, khaki.'),
	(105, 65, 'BOYS SWEATSHIRTS', 23, 'Cotton sweatshirts with mickey character printing.\r\nRegular cheese, round neck, long sleeves.\r\nBo body and bear body.\r\nSuitable for winter wear. Simple design, suitable for many circumstances. Easily '),
	(106, 66, 'SWEATER BABY GIRL', 23, 'Blended cotton baby girl sweater.\r\nform regular, high neck,'),
	(107, 66, 'GIRLS DRESS GIRLS', 34, 'Plaid cotton dress.\r\nRegular phom, long-sleeved round neck.\r\nChun waisted.Suitable for autumn and winter. Dynamic design, personality, suitable for many situations, combined with doll shoes, sandals, '),
	(110, 65, 'ACTIVE BOYS SET', 24, 'Sportswear with color scheme, polyester. Regular phom, shirt-style, armpit. Elastic waistband, short design. Suitable for summer wear. Physical style, dynamic suitable for gym sessions.'),
	(111, 65, 'T-SHIRT BOY', 16, 'Cotton T-shirt, print in front of chest. regular form, round neck, short sleeves.'),
	(114, 65, 'LONG BABY CLOTHES', 23, '\r\nPolyester stretch pants.\r\nCheese jogger, elastic waistband, drawstring.\r\nInterference in the knee.\r\nSuitable for autumn and winter.\r\nStylish personality, dynamic, suitable for many situati');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
