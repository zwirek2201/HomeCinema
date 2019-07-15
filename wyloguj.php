<?php
ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
session_destroy();
header('Location: index.php');
?>
<?php
ob_end_flush();
?>