<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$description = "";
$sort_order = "";
$timeline_position = "";
$experience_id = null;
$is_editing = false;
$error = "";
$success = "";

// Proses form (tambah/edit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_experience'])) {
    $description = trim($_POST['description']);
    $sort_order = trim($_POST['sort_order']);
    $timeline_position = trim($_POST['timeline_position']);
    $experience_id = $_POST['id'] ?? null;

    if (empty($description) || empty($sort_order) || empty($timeline_position)) {
        $error = "Deskripsi, urutan, dan posisi timeline tidak boleh kosong.";
    } else {
        if ($experience_id) { // Update
            $sql = "UPDATE experience SET description = :description, sort_order = :sort_order, timeline_position = :timeline_position WHERE id = :id";
        } else { // Insert
            $sql = "INSERT INTO experience (description, sort_order, timeline_position) VALUES (:description, :sort_order, :timeline_position)";
        }

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':sort_order', $sort_order, PDO::PARAM_INT);
            $stmt->bindParam(':timeline_position', $timeline_position, PDO::PARAM_STR);
            if ($experience_id) {
                $stmt->bindParam(':id', $experience_id, PDO::PARAM_INT);
            }
            if ($stmt->execute()) {
                $success = "Riwayat pengalaman berhasil disimpan.";
                // Reset form
                $description = "";
                $sort_order = "";
                $timeline_position = "";
                $experience_id = null;
                $is_editing = false;
            } else {
                $error = "Gagal menyimpan riwayat pengalaman.";
            }
        }
    }
}

// Cek untuk mode edit
if (isset($_GET['edit'])) {
    $is_editing = true;
    $experience_id = $_GET['edit'];
    $sql = "SELECT * FROM experience WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $experience_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $description = $row['description'];
            $sort_order = $row['sort_order'];
            $timeline_position = $row['timeline_position'];
        }
    }
}

// Cek untuk hapus
if (isset($_GET['delete'])) {
    $experience_id_to_delete = $_GET['delete'];
    $sql = "DELETE FROM experience WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $experience_id_to_delete, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("location: manage_pengalaman.php?deleted=true");
            exit;
        }
    }
}

if(isset($_GET['deleted'])) {
    $success = "Riwayat pengalaman berhasil dihapus.";
}

// Mengambil semua riwayat pengalaman
$experience_entries = $pdo->query("SELECT * FROM experience ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Riwayat Pengalaman</title>
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
                    <li class="nav-item"><a class="nav-link" href="manage_pengalaman.php">Pengalaman</a></li>
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
            <h2 class="section-title">Manajemen Riwayat Pengalaman</h2>
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
                            <h5 class="card-title"><?= $is_editing ? 'Edit Riwayat Pengalaman' : 'Tambah Riwayat Pengalaman Baru' ?></h5>
                            <form action="manage_pengalaman.php" method="post">
                                <input type="hidden" name="id" value="<?= $experience_id ?>">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" required><?= htmlspecialchars($description) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Urutan (Angka)</label>
                                    <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?= htmlspecialchars($sort_order) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="timeline_position" class="form-label">Posisi Timeline</label>
                                    <select name="timeline_position" id="timeline_position" class="form-select" required>
                                        <option value="left" <?= ($timeline_position == 'left') ? 'selected' : ''; ?>>Kiri</option>
                                        <option value="right" <?= ($timeline_position == 'right') ? 'selected' : ''; ?>>Kanan</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="save_experience" class="btn btn-custom">Simpan</button>
                                    <?php if ($is_editing): ?>
                                        <a href="manage_pengalaman.php" class="btn btn-secondary">Batal</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Riwayat Pengalaman -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <th>Urutan</th>
                                            <th>Posisi</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($experience_entries) > 0): ?>
                                            <?php foreach ($experience_entries as $entry): ?>
                                            <tr>
                                                <td><?= htmlspecialchars(substr($entry['description'], 0, 100)); ?><?php echo (strlen($entry['description']) > 100) ? '...' : ''; ?></td>
                                                <td><?= htmlspecialchars($entry['sort_order']); ?></td>
                                                <td><?= htmlspecialchars($entry['timeline_position']); ?></td>
                                                <td class="text-end">
                                                    <a href="manage_pengalaman.php?edit=<?= $entry['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="manage_pengalaman.php?delete=<?= $entry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat pengalaman ini?');"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada riwayat pengalaman.</td>
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
