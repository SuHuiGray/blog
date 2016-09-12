-- phpMyAdmin SQL Dump
-- version 4.4.15.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-09-13 01:41:51
-- 服务器版本： 5.7.11-log
-- PHP Version: 7.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(5) NOT NULL COMMENT '主键id',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `content` text NOT NULL COMMENT '文章内容',
  `tag` varchar(255) DEFAULT NULL COMMENT '文章标签',
  `author` varchar(255) DEFAULT 'Gray' COMMENT '文章作者',
  `create_time` datetime NOT NULL COMMENT '文章创建时间',
  `view_time` int(11) NOT NULL DEFAULT '0' COMMENT '文章查看次数'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `tag`, `author`, `create_time`, `view_time`) VALUES
(6, 'this is the first article', '```php\r\n<?php\r\n	$arr = array();\r\n	for($i=0; $i<10; $i++){\r\n		$arr[] = $i;\r\n	}\r\n	\r\n?>\r\n```', '', '', '2016-08-31 12:08:49', 0),
(15, '测试', '测试', NULL, 'Gray', '2016-09-06 17:37:08', 0),
(17, '测试', '哈哈哈\r\n`code`\r\n```php\r\n/*phpdaima*/\r\necho "hello world";\r\n```\r\n```c\r\nint main()\r\n{\r\n	printf("Hello World");\r\n}\r\n```\r\n    echo "print";\r\n    var_dump($arr);', 'c', 'Gray', '2016-09-13 01:23:27', 0);

-- --------------------------------------------------------

--
-- 表的结构 `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL COMMENT '主键id',
  `tag_name` varchar(255) NOT NULL COMMENT '标签名',
  `total` int(11) NOT NULL DEFAULT '0' COMMENT '标签下的文章数'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tag`
--

INSERT INTO `tag` (`id`, `tag_name`, `total`) VALUES
(1, 'Linux', 0),
(2, 'c', 0),
(5, 'JavaScript', 0),
(6, 'Python', 0),
(7, 'PHP', 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `passwd`) VALUES
(1, 'gray', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
