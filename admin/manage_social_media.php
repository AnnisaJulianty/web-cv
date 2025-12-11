<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$error = "";
$success = "";

// Handle form submission for adding/editing social media
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_social']) || isset($_POST['edit_social'])) {
        $name = trim($_POST['name'] ?? '');
        $url = trim($_POST['url'] ?? '');
        $icon_class = trim($_POST['icon_class'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($name) || empty($url) || empty($icon_class)) {
            $error = "Nama, URL, dan Ikon tidak boleh kosong.";
        } else {
            if (isset($_POST['edit_id']) && $_POST['edit_id']) {
                // Editing existing record
                $edit_id = $_POST['edit_id'];
                $sql = "UPDATE social_media SET name=:name, url=:url, icon_class=:icon_class, display_order=:display_order WHERE id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':url', $url, PDO::PARAM_STR);
                $stmt->bindParam(':icon_class', $icon_class, PDO::PARAM_STR);
                $stmt->bindParam(':display_order', $display_order, PDO::PARAM_INT);
                $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $success = "Media sosial berhasil diperbarui.";
                } else {
                    $error = "Gagal memperbarui media sosial.";
                }
            } else {
                // Adding new record
                $sql = "INSERT INTO social_media (name, url, icon_class, display_order) VALUES (:name, :url, :icon_class, :display_order)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':url', $url, PDO::PARAM_STR);
                $stmt->bindParam(':icon_class', $icon_class, PDO::PARAM_STR);
                $stmt->bindParam(':display_order', $display_order, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $success = "Media sosial berhasil ditambahkan.";
                } else {
                    $error = "Gagal menambahkan media sosial.";
                }
            }
        }
    } elseif (isset($_POST['delete_id'])) {
        // Deleting record
        $delete_id = $_POST['delete_id'];
        $sql = "DELETE FROM social_media WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success = "Media sosial berhasil dihapus.";
        } else {
            $error = "Gagal menghapus media sosial.";
        }
    }
}

// Fetch all social media entries
$social_medias = $pdo->query("SELECT * FROM social_media ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);

// Check if we're editing an existing record
$editing_social = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM social_media WHERE id = :id");
    $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
    $stmt->execute();
    $editing_social = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$editing_social) {
        $error = "Media sosial tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Media Sosial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="admin-page">

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kategori.php">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_home.php">Info Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="manage_social_media.php">Media Sosial</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Manajemen Media Sosial</h2>
            <div class="text-center mb-4">
                <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <!-- Form for adding/editing social media -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?php echo isset($editing_social) ? 'Edit Media Sosial' : 'Tambah Media Sosial'; ?></h5>
                    <form method="post" action="">
                        <?php if (isset($editing_social)): ?>
                            <input type="hidden" name="edit_id" value="<?= $editing_social['id'] ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Media Sosial</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($editing_social['name'] ?? '') ?>" required>
                            <div class="form-text">Contoh: Instagram, GitHub, LinkedIn, dll.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="url" name="url" value="<?= htmlspecialchars($editing_social['url'] ?? '') ?>" required>
                            <div class="form-text">Contoh: https://www.instagram.com/username/</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="icon_class" class="form-label">Kelas Ikon (Font Awesome)</label>
                            <input type="text" class="form-control" id="icon_class" name="icon_class" value="<?= htmlspecialchars($editing_social['icon_class'] ?? '') ?>" required>
                            <div class="form-text">Contoh: fab fa-instagram, fab fa-github, fab fa-linkedin, fas fa-envelope</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="display_order" class="form-label">Urutan Tampil</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="<?= $editing_social['display_order'] ?? 0 ?>" min="0">
                            <div class="form-text">Angka lebih kecil akan muncul lebih awal</div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <?php if (isset($editing_social)): ?>
                                <button type="submit" name="edit_social" class="btn btn-primary">Update Media Sosial</button>
                                <a href="manage_social_media.php" class="btn btn-secondary">Batal</a>
                            <?php else: ?>
                                <button type="submit" name="add_social" class="btn btn-success">Tambah Media Sosial</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List of social media accounts -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Media Sosial</h5>
                    <?php if (count($social_medias) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>URL</th>
                                        <th>Ikon</th>
                                        <th>Urutan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($social_medias as $index => $social): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= htmlspecialchars($social['name']) ?></td>
                                        <td><a href="<?= htmlspecialchars($social['url']) ?>" target="_blank" class="text-light"><?= htmlspecialchars($social['url']) ?></a></td>
                                        <td><i class="<?= htmlspecialchars($social['icon_class']) ?>"></i> <?= htmlspecialchars($social['icon_class']) ?></td>
                                        <td><?= $social['display_order'] ?></td>
                                        <td>
                                            <a href="?edit_id=<?= $social['id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <form method="post" action="" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus media sosial ini?');">
                                                <input type="hidden" name="delete_id" value="<?= $social['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center">Belum ada media sosial yang ditambahkan.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>