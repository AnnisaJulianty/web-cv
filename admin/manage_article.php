<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$title = $content = "";
$category_id = null;
$image_path = null;
$article_id = null;
$page_title = "Tambah Artikel";
$error = "";

// Ambil semua kategori untuk dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Cek apakah ini mode edit
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $article_id = $_GET['id'];
    $page_title = "Edit Artikel";

    $sql = "SELECT * FROM articles WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $article_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $article = $stmt->fetch(PDO::FETCH_ASSOC);
                $title = $article['title'];
                $content = $article['content'];
                $category_id = $article['category_id'];
                $image_path = $article['image_path'];
            } else {
                header("location: dashboard.php");
                exit();
            }
        } else {
            $error = "Gagal mengambil data artikel.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = !empty($_POST['category_id']) ? trim($_POST['category_id']) : null;
    $article_id = $_POST['id'] ?? null;

    if (empty($title) || empty($content)) {
        $error = "Judul dan konten tidak boleh kosong.";
    } else {
        // Proses upload gambar
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . uniqid() . '-' . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = 'uploads/' . basename($target_file);
            } else {
                $error = "Gagal mengupload gambar.";
            }
        }

        if (empty($error)) {
            if ($article_id) { // Mode Edit
                $sql = "UPDATE articles SET title = :title, content = :content, category_id = :category_id" . ($image_path ? ", image_path = :image_path" : "") . " WHERE id = :id";
            } else { // Mode Tambah
                $sql = "INSERT INTO articles (title, content, category_id, image_path) VALUES (:title, :content, :category_id, :image_path)";
            }

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":title", $title, PDO::PARAM_STR);
                $stmt->bindParam(":content", $content, PDO::PARAM_STR);
                $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
                
                if ($article_id) {
                    $stmt->bindParam(":id", $article_id, PDO::PARAM_INT);
                } else {
                    // Bind image_path hanya saat insert, atau saat update jika ada gambar baru
                    $stmt->bindParam(":image_path", $image_path, PDO::PARAM_STR);
                }
                
                if ($image_path && $article_id) {
                     $stmt->bindParam(":image_path", $image_path, PDO::PARAM_STR);
                }

                if ($stmt->execute()) {
                    header("location: dashboard.php");
                    exit();
                } else {
                    $error = "Gagal menyimpan artikel.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .form-label {
            color: #f8f9fa; /* Light color for labels */
        }
        .card {
            /* Making card background dark to ensure contrast */
            background-color: #282c34; 
        }
        /* Ensure text inside card is light */
        .card-body, .card-body .form-label, .card-body .form-text {
            color: #f8f9fa;
        }
        .form-control, .form-select {
            background-color: #3a3f48;
            color: #f8f9fa;
            border-color: #495057;
        }
        .form-control:focus, .form-select:focus {
            background-color: #3a3f48;
            color: #f8f9fa;
            border-color: #80bdff;
        }
        p.mt-2 {
            color: #f8f9fa;
        }
    </style>
    <!-- Script TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/lvnmc0djsxd3oalnw0o6i46qaxr6qarmwjdstisrhfu1k217/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        </div>
    </nav>

    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title"><?php echo $page_title; ?></h2>
            <div class="text-center mb-4">
                <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
            </div>
            <?php if(!empty($error)):
            ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form action="manage_article.php<?php echo $article_id ? '?id='.$article_id : ''; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $article_id; ?>">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Artikel</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <div class="input-group">
                                <select name="category_id" id="category_id" class="form-select">
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $category_id) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea name="content" id="content" class="form-control" rows="10"><?php echo htmlspecialchars($content); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Unggulan</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <?php if ($image_path): ?>
                                <p class="mt-2">Gambar saat ini: <img src="../<?php echo $image_path; ?>" alt="Gambar Unggulan" style="max-width: 200px; margin-top: 10px;"></p>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="dashboard.php" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-custom">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addCategoryForm">
              <div class="mb-3">
                <label for="new_category_name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="new_category_name" required>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" id="saveCategoryBtn">Simpan</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#content',
            plugins: 'lists link image media table code help wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | help'
        });

        $(document).ready(function() {
            $('#saveCategoryBtn').on('click', function() {
                var categoryName = $('#new_category_name').val();
                if (categoryName.trim() === '') {
                    alert('Nama kategori tidak boleh kosong.');
                    return;
                }

                $.ajax({
                    url: 'ajax_add_category.php',
                    type: 'POST',
                    data: { name: categoryName },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var newOption = new Option(response.category.name, response.category.id, true, true);
                            $('#category_id').append(newOption).trigger('change');
                            var addCategoryModal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal'));
                            addCategoryModal.hide();
                            $('#new_category_name').val('');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Gagal menambahkan kategori. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>
</html>