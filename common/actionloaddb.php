<?php
session_start();

/* heroku deploy 
$_SESSION['db_host'] = "ec2-54-164-40-66.compute-1.amazonaws.com";
$_SESSION['db_name'] = "d5jpsu05ngdp98";
$_SESSION['db_user'] = "gufvvvxbtvglqn";
$_SESSION['db_port'] = "5432";
$_SESSION['db_pass'] = "f4121ca0b5c6dbe1a289575016152315b6c81ad4701eb0fb39a5b6e4f7fb0c5a";
*/

// local
$_SESSION['db_host'] = "localhost";
$_SESSION['db_name'] = "php_blog";
$_SESSION['db_user'] = "djdols";
$_SESSION['db_port'] = "5432";
$_SESSION['db_pass'] = "";
