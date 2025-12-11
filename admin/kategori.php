<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$name = "";
$category_id = null;
$is_editing = false;
$error = "";
$success = "";

// Proses form (tambah/edit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_category'])) {
    $name = trim($_POST['name']);
    $category_id = $_POST['id'] ?? null;

    if (empty($name)) {
        $error = "Nama kategori tidak boleh kosong.";
    } else {
        // Cek apakah nama sudah ada (kecuali untuk kategori yang sedang diedit)
        $sql_check = "SELECT id FROM categories WHERE name = :name" . ($category_id ? " AND id != :id" : "");
        if ($stmt_check = $pdo->prepare($sql_check)) {
            $stmt_check->bindParam(':name', $name, PDO::PARAM_STR);
            if ($category_id) {
                $stmt_check->bindParam(':id', $category_id, PDO::PARAM_INT);
            }
            $stmt_check->execute();
            if ($stmt_check->rowCount() > 0) {
                $error = "Nama kategori sudah ada.";
            }
        }

        if (empty($error)) {
            if ($category_id) { // Update
                $sql = "UPDATE categories SET name = :name WHERE id = :id";
            } else { // Insert
                $sql = "INSERT INTO categories (name) VALUES (:name)";
            }

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                if ($category_id) {
                    $stmt->bindParam(':id', $category_id, PDO::PARAM_INT);
                }
                if ($stmt->execute()) {
                    $success = "Kategori berhasil disimpan.";
                    // Reset form
                    $name = "";
                    $category_id = null;
                    $is_editing = false;
                } else {
                    $error = "Gagal menyimpan kategori.";
                }
            }
        }
    }
}

// Cek untuk mode edit
if (isset($_GET['edit'])) {
    $is_editing = true;
    $category_id = $_GET['edit'];
    $sql = "SELECT name FROM categories WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $name = $row['name'];
        }
    }
}

// Cek untuk hapus
if (isset($_GET['delete'])) {
    $category_id_to_delete = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $category_id_to_delete, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("location: kategori.php?deleted=true");
            exit;
        }
    }
}

if(isset($_GET['deleted'])) {
    $success = "Kategori berhasil dihapus.";
}


// Mengambil semua kategori
$categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kategori.php">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_social_media.php">Media Sosial</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Manajemen Kategori</h2>
            <div class="text-center mb-4">
                <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="row">
                <!-- Form Tambah/Edit -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $is_editing ? 'Edit Kategori' : 'Tambah Kategori Baru' ?></h5>
                            <form action="kategori.php" method="post">
                                <input type="hidden" name="id" value="<?= $category_id ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Kategori</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="save_category" class="btn btn-custom">Simpan</button>
                                    <?php if ($is_editing): ?>
                                        <a href="kategori.php" class="btn btn-secondary">Batal</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Kategori -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Kategori</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($categories) > 0): ?>
                                            <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($category['name']); ?></td>
                                                <td class="text-end">
                                                    <a href="kategori.php?edit=<?= $category['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="kategori.php?delete=<?= $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Menghapus kategori akan mengatur artikel terkait menjadi tidak berkategori. Lanjutkan?');"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="2" class="text-center">Belum ada kategori.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
