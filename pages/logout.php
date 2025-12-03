<?php
session_start();
session_destroy();
header("Location: SeeiMUBarangayDocumentRequestSystemLogin.php");
exit();
?>