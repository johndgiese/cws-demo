CREATE DATABASE IF NOT EXISTS cws_demo;

USE cws_demo;

CREATE TABLE `complexes` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(70) NOT NULL,
      `state` char(2) NOT NULL,
      `url` varchar(255) NOT NULL,
      PRIMARY KEY (`id`)
);
