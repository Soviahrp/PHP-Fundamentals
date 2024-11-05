<?php

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Please login first');
              document.location.href = 'login.php';
          </script>";

    exit;
}

session_start();

$_SESSION = [];

session_unset();
session_destroy();
header('Location: login.php');
