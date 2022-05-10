<?php
session_start();
unset($_SESSION['session_user']);
header("Location: /home/index.php");
