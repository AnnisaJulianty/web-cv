<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$title = "";
$description = "";
$image_path = null;
$link = "";
$project_id = null;
$is_editing = false;
$error = "";
$success = "";

// Proses form (tambah/edit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_project'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $project_id = $_POST['id'] ?? null;

    if (empty($title) || empty($description)) {
        $error = "Judul dan deskripsi tidak boleh kosong.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $target_dir = "../uploads/";
                if (!is_dir($target_dir)) {
                    if (!mkdir($target_dir, 0777, true)) {
                        $error = "Gagal membuat direktori upload. Periksa izin folder.";
                    }
                }
                
                // Sanitize filename
                $original_filename = basename($_FILES["image"]["name"]);
                $safe_filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $original_filename);
                $target_file = $target_dir . uniqid() . '-' . $safe_filename;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_path = 'uploads/' . basename($target_file);
                } else {
                    $error = "Gagal memindahkan file yang di-upload. Periksa izin folder uploads.";
                }
            } else {
                switch ($_FILES['image']['error']) {
                    case UPLOAD_ERR_INI_SIZE:
                        $error = "File terlalu besar, melebihi batas (upload_max_filesize) di php.ini.";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $error = "File terlalu besar, melebihi batas yang ditentukan di form HTML.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error = "File hanya ter-upload sebagian.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $error = "Direktori sementara tidak ditemukan.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $error = "Gagal menulis file ke disk. Periksa izin folder.";
                        break;

                    case UPLOAD_ERR_EXTENSION:
                        $error = "Upload file dihentikan oleh ekstensi PHP.";
                        break;
                    default:
                        $error = "Terjadi kesalahan upload yang tidak diketahui.";
                        break;
                }
            }
        }

        if (empty($error)) {
            if ($project_id) { // Update
                $sql = "UPDATE projects SET title = :title, description = :description, link = :link" . ($image_path ? ", image_path = :image_path" : "") . " WHERE id = :id";
            } else { // Insert
                $sql = "INSERT INTO projects (title, description, image_path, link) VALUES (:title, :description, :image_path, :link)";
            }

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':description', $description, PDO::PARAM_STR);
                $stmt->bindParam(':link', $link, PDO::PARAM_STR);
                
                if ($image_path) {
                    $stmt->bindParam(':image_path', $image_path, PDO::PARAM_STR);
                } elseif (!$project_id) { // Only bind null if inserting and no image
                    $stmt->bindValue(':image_path', null, PDO::PARAM_NULL);
                }

                if ($project_id) {
                    $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
                }
                
                if ($stmt->execute()) {
                    $success = "Proyek berhasil disimpan.";
                    // Reset form
                    $title = "";
                    $description = "";
                    $image_path = null;
                    $link = "";
                    $project_id = null;
                    $is_editing = false;
                } else {
                    $error = "Gagal menyimpan proyek.";
                }
            }
        }
    }
}

// Cek untuk mode edit
if (isset($_GET['edit'])) {
    $is_editing = true;
    $project_id = $_GET['edit'];
    $sql = "SELECT * FROM projects WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $title = $row['title'];
            $description = $row['description'];
            $image_path = $row['image_path'];
            $link = $row['link'];
        }
    }
}

// Cek untuk hapus
if (isset($_GET['delete'])) {
    $project_id_to_delete = $_GET['delete'];
    // Optional: Delete image file from server
    $sql_select_image = "SELECT image_path FROM projects WHERE id = :id";
    if ($stmt_select_image = $pdo->prepare($sql_select_image)) {
        $stmt_select_image->bindParam(':id', $project_id_to_delete, PDO::PARAM_INT);
        $stmt_select_image->execute();
        if ($row = $stmt_select_image->fetch()) {
            if ($row['image_path'] && file_exists('../' . $row['image_path'])) {
                unlink('../' . $row['image_path']);
            }
        }
    }

    $sql = "DELETE FROM projects WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $project_id_to_delete, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("location: manage_projects.php?deleted=true");
            exit;
        }
    }
}

if(isset($_GET['deleted'])) {
    $success = "Proyek berhasil dihapus.";
}

// Mengambil semua proyek
$projects = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Proyek</title>
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
                    <li class="nav-item"><a class="nav-link" href="manage_skills.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_education.php">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_contact.php">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_projects.php">Proyek</a></li>
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
            <h2 class="section-title">Manajemen Proyek</h2>
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
                            <h5 class="card-title"><?= $is_editing ? 'Edit Proyek' : 'Tambah Proyek Baru' ?></h5>
                            <form action="manage_projects.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $project_id ?>">
                                <?php if ($image_path): ?>
                                    <input type="hidden" name="current_image_path" value="<?= htmlspecialchars($image_path) ?>">
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Proyek</label>
                                    <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="5" required><?= htmlspecialchars($description) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Proyek</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    <?php if ($image_path): ?>
                                        <p class="mt-2">Gambar saat ini: <img src="../<?= htmlspecialchars($image_path); ?>" alt="Gambar Proyek" style="max-width: 100px; margin-top: 10px;"></p>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="link" class="form-label">Link Proyek (Opsional)</label>
                                    <input type="url" name="link" id="link" class="form-control" value="<?= htmlspecialchars($link) ?>">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="save_project" class="btn btn-custom">Simpan</button>
                                    <?php if ($is_editing): ?>
                                        <a href="manage_projects.php" class="btn btn-secondary">Batal</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Proyek -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Link</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($projects) > 0): ?>
                                            <?php foreach ($projects as $project): ?>
                                            <tr>
                                                <td>
                                                    <?php if ($project['image_path']): ?>
                                                        <img src="../<?= htmlspecialchars($project['image_path']); ?>" alt="Gambar Proyek" style="width: 50px; height: auto;">
                                                    <?php else: ?>
                                                        Tidak ada gambar
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= htmlspecialchars($project['title']); ?></td>
                                                <td><?= htmlspecialchars(substr($project['description'], 0, 70)); ?><?php echo (strlen($project['description']) > 70) ? '...' : ''; ?></td>
                                                <td>
                                                    <?php if ($project['link']): ?>
                                                        <a href="<?= htmlspecialchars($project['link']); ?>" target="_blank">Lihat</a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <a href="manage_projects.php?edit=<?= $project['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="manage_projects.php?delete=<?= $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek ini?');"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada proyek.</td>
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
