<?php

session_start();

unset($_SESSION['engr']);
unset($_SESSION['valid']);
header('Location: /osugds/index.php');

?>
