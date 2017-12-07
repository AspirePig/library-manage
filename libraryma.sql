-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-12-07 12:20:03
-- 服务器版本： 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libraryma`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminID` int(11) NOT NULL COMMENT '管理员ID',
  `passwd` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `adminID`, `passwd`, `name`, `phone`) VALUES
(1, 1, '123456', '张三', '15968166305'),
(2, 2, '123456789', '李四', '13506705073'),
(3, 123456, '123456', '房东', '4321414');

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bnum` varchar(100) NOT NULL COMMENT '书号',
  `bname` varchar(100) NOT NULL COMMENT '书名',
  `writer` varchar(100) NOT NULL,
  `publish` varchar(100) NOT NULL COMMENT '出版社',
  `category` varchar(100) NOT NULL COMMENT '类别',
  `year` date DEFAULT NULL,
  `total` int(5) NOT NULL COMMENT '总藏书量',
  `inventory` int(5) NOT NULL COMMENT '库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `book`
--

INSERT INTO `book` (`id`, `bnum`, `bname`, `writer`, `publish`, `category`, `year`, `total`, `inventory`) VALUES
(1, '0000000001', 'SPSS统计分析', '程棕', '中国统计出版社', '数学', '2005-10-10', 6, 6),
(2, '0000000002', '信息安全技术浅谈', '赵战生等编著', '科学出版社', '信息安全', '2010-02-10', 3, 2),
(3, '0000000003', '网络信息安全及保密', '杨义先，李明选编著', '北京邮电学院出版社', '信息安全', '2003-01-01', 5, 4),
(4, '0000000004', '平凡世界', '路遥', '北京十月文艺出版社', '中国文学', '2015-12-12', 10, 8),
(5, '0000000005', '巨人的陨落', '（英）Ken Follett著', '江苏凤凰文艺出版社', '外国文学', '2016-05-05', 8, 4),
(6, '0000000006', '白银时代', '王小波', '作家出版社', '中国文学', '2015-04-04', 8, 6),
(7, '0000000007', '活着', '余华', '作家出版社', '', '2017-02-02', 8, 4),
(8, '0000000008', '计算机及其在管理中心的应用', '胡维华，孙祖德编', '电子工业出版社', '计算机', '1997-07-07', 5, 5),
(9, '0000000009', 'PHP4编程与实例', '白鉴聪等编著', '机械工业出版社', '计算机', '2005-05-05', 5, 4),
(10, '0000000010', '情报数据库系统', '周宁编', '武汉大学出版社', '计算机', '2007-07-07', 5, 3);

-- --------------------------------------------------------

--
-- 表的结构 `borrow`
--

DROP TABLE IF EXISTS `borrow`;
CREATE TABLE IF NOT EXISTS `borrow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `snum` int(10) NOT NULL COMMENT '学号',
  `bid` text NOT NULL COMMENT '借的书的id',
  `bdate` date DEFAULT NULL COMMENT '借期',
  `rdate` date DEFAULT NULL COMMENT '应还期',
  `realtime` date NOT NULL DEFAULT '1970-01-01',
  `adminID` text NOT NULL COMMENT '管理员ID',
  `breturn` tinyint(1) NOT NULL COMMENT '是否还书',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `borrow`
--

INSERT INTO `borrow` (`id`, `snum`, `bid`, `bdate`, `rdate`, `realtime`, `adminID`, `breturn`) VALUES
(1, 15084206, '0000000001', '2017-11-28', '2017-12-28', '2017-12-07', '1', 1),
(2, 123, '0000000002', '2017-11-21', '2017-12-21', '2017-11-27', '1', 1),
(3, 15084206, '0000000005', '2017-10-21', '2017-11-21', '1969-12-01', '2', 0),
(4, 123, '0000000003', '2017-11-21', '2017-12-21', '1970-01-01', '1', 0),
(5, 123, '0000000003', '2017-12-07', '2017-12-21', '1970-01-01', '1', 0),
(6, 123, '0000000001', '2017-12-07', '2018-01-06', '2017-12-07', '1', 1);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `snum` int(10) NOT NULL,
  `passwd` text NOT NULL,
  `academy` varchar(20) NOT NULL,
  `sname` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `snum`, `passwd`, `academy`, `sname`) VALUES
(1, 15084206, '12345', '网络空间安全学院', '王三'),
(2, 15084208, '', '网络空间安全学院', '尹四'),
(3, 122345678, '', '机械工程学院', '罗五'),
(4, 12345677, '', '卓越学院', '杨一'),
(5, 123, '123', 'fggfd', 'fd'),
(7, 1234, '1234', '网络空间安全学院', '阎天盟');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
