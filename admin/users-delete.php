<?php

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Please login first');
              document.location.href = 'login.php';
          </script>";
  
    exit;
  }

require "config/app.php";

$id_user = (int)$_GET['id'];

if($_SESSION['role'] !== 'admin'){
    echo "<script>
    alert('you do not have permission to delete user');
    document.location.href = 'users.php';
    </script>";

    exit;
}

if (delete_user($id_user) > 0) {
    echo "<script>
     alert('user has been deleted');
     document.location.href = 'users.php';
     </script>";
} else {
    echo "<script>
    alert('user has not been deleted');
     document.location.href = 'users.php';
    </script>";
}
