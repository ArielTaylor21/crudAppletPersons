<?php

include_once './database/function.php';
session_start();
//session_destroy();
unset($_SESSION['person']);
redirect("index.php");
