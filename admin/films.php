<?php

session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Please login first');
              document.location.href = 'login.php';
          </script>";
  
    exit;
  }

$title = "Film";
require "layout/header.php";

// $films = query("SELECT * FROM films ORDER BY created_at DESC");

$films = query("SELECT f.id_film, f.title, f.studio, f.is_private, f.created_at, c.title AS category_title FROM films f JOIN categories c ON f.category_id = c.id_category ORDER BY f.created_at DESC");

// print_r($id_films);
?>


<!--main-->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-film"></i>
                        <?= $title;  ?>
                    </div>

                    <div class="card-body shadow-sm">

                        <div class="table-responsive">
                            <a href="films-create.php" class="btn btn-primary"><i class="bi bi-plus"></i>Create</a>

                            <a href="films-download.php" class="btn btn-info text-white"><i class="bi bi-download"></i>Download</a>
                            <table id="datatable" class="table table-bordered table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama</th>
                                        <th>Studio</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($films as $film) :  ?>
                                        <tr>
                                            <td><?= $no++;  ?></td>
                                            <td><?= $film['title']; ?></td>
                                            <td><?= $film['studio'];  ?></td>
                                            <td><?= $film['category_title'];  ?></td>
                                            <!-- jika is_private = 0 maka film public -->
                                            <td><?= $film['is_private'] ? 'private' : 'public'; ?></td>
                                            <td><?= $film['created_at'];  ?></td>
                                            <td class="text-center">
                                                <a href="films-detail.php?id=<?php echo $film['id_film']; ?>"
                                                    class="btn btn-sm btn-secondary mb-1"
                                                    title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="films-edit.php?id=<?php echo $film['id_film']; ?>"
                                                    class="btn btn-sm btn-success mb-1"
                                                    title="Edit">
                                                    <i class="bi bi-pen"></i>
                                                </a>

                                                <a href="films-delete.php?id=<?php echo $film['id_film']; ?>"
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