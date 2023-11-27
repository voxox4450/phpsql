<?php
session_start();
session_destroy();
header("Location:/phpsql/index.php");
exit;
?>
