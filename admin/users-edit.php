<?php

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Please login first');
              document.location.href = 'login.php';
          </script>";
    exit;
}

$title = 'Update Users';
require "layout/header.php";

// Ensure user ID is received from the URL
if (!isset($_GET['id'])) {
    echo "<script>
            alert('No user selected for update');
            document.location.href = 'users.php';
          </script>";
    exit;
}

$currentUserId = $_SESSION['id_user'];
$isAdmin = $_SESSION['role'] === 'admin';
$isUser = $_SESSION['role'] == 'user';
$id_user = (int)$_GET['id'];
$user = query("SELECT * FROM users WHERE id_user = $id_user")[0];



if (isset($_POST['submit'])) {
    if (update_user($_POST) > 0) {
        echo "<script>
                alert('User has been updated');
                document.location.href = 'users.php';
            </script>";
    } else {
        echo "<script>
                alert('User has not been updated');
                document.location.href = 'users-edit.php?id=$id_user';
            </script>";
    }
}

?>

<!-- main -->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-pencil"></i> <?= $title; ?>
                    </div>
                    <div class="card-body shadow-sm">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <input type="hidden" name="id_user" value="<?= $id_user; ?>"> 
                            <div class="float-end">
                                <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-upload"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require "layout/footer.php"; ?>.