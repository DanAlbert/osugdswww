<?php

session_start();

unset($_SESSION['engr']);
header('Location: /osugds/index.php');

?>
