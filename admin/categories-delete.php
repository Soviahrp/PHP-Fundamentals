<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
    alert('Hanya admin yang diperbolehkan mengakses');
    document.location.href = 'login.php';
    </script>";

    exit;
}


require "config/app.php";

$id_category = (int)$_GET['id'];

if (delete_category($id_category) > 0) {
    echo "<script>
     alert('Category has been deleted');
     document.location.href = 'categories.php';
     </script>";
} else {
    echo "<script>
    alert('Category has not been deleted');
     document.location.href = 'categories.php';
    </script>";
}
