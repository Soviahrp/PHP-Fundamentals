<?php

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Please login first');
              document.location.href = 'login.php';
          </script>";

    exit;
}

$title = "Categories";
require "layout/header.php";

$categories = query("SELECT * FROM categories ORDER BY created_at DESC");

// print_r($categories);
?>


<!--main-->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-list-stars"></i>
                        <?= $title;  ?>
                    </div>

                    <div class="card-body shadow-sm">

                        <div class="table-responsive">
                            <a href="categories-create.php" class="btn btn-primary"><i class="bi bi-plus"></i>Create</a>

                            <a href="categories-download.php" class="btn btn-info text-white"><i class="bi bi-download"></i>Download</a>

                            <table id="datatable" class="table table-bordered table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
                                        <th>Created</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($categories as $category) :  ?>
                                        <tr>
                                            <td><?= $no++;  ?></td>
                                            <td><?= $category['title']; ?></td>
                                            <td><?= $category['slug'];  ?></td>
                                            <td><?= $category['created_at'];  ?></td>
                                            <td class="text-center">
                                                <a href="categories-edit.php?id=<?php echo $category['id_category']; ?>"
                                                    class="btn btn-sm btn-success mb-1"
                                                    title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>


                                                <a href="categories-delete.php?id=<?php echo $category['id_category']; ?>"
                                                    onclick="return confirm('Yakin ingin menghapus data?')"
                                                    class="btn btn-sm btn-danger mb-1"
                                                    title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require "layout/footer.php";
?>