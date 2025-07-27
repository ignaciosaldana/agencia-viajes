<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

// Control inactividad (10 min)
$timeout = 600; 
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout) {
    session_unset();
    session_destroy();
    header('Location: index.php?timeout=1');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();
?>
