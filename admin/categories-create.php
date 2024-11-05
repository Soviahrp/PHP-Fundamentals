<?php

session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
    alert('Hanya admin yang diperbolehkan mengakses');
    document.location.href = 'login.php';
    </script>";

    exit;
}

$title = 'Create Category';
require "layout/header.php";

if (isset($_POST['submit'])) {
    if (store_category($_POST) > 0) {
        echo "<script>
         alert('Category has been created');
         document.location.href = 'categories.php';
         </script>";
    } else {
        echo "<script>
        alert('Category has been created');
         document.location.href = 'categories-create.php';
        </script>";
        echo mysqli_error($db);
    }
}
?>

<!--main-->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-plus"></i>
                        <?= $title;  ?>
                    </div>

                    <div class="card-body shadow-sm">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title"
                                    name="title" required>
                            </div>

                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" id="slug"
                                    name="slug" readonly>
                            </div>

                            <div class="float-end">
                                <button type="submit" class="btn btn-primary" name="submit"><i class="bi bi-upload"></i> Submit </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<script src="assets/js/helper.js"></script>

<script>
    $(document).ready(function() {
        $("#title").on("input", function() {
            $('#slug').val(slugify($(this).val()));
        })
    });
</script>

<?php require "layout/footer.php"; ?>