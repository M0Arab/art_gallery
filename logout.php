<?php
session_start();
unset($_SESSION["ID"]);
unset($_SESSION["name"]);
unset($_SESSION["isArtist"]);

header('Refresh: 2; URL = index.php');
?>