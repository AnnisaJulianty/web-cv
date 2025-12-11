<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$institution = "";
$major = "";
$year = "";
$description = "";
$education_id = null;
$is_editing = false;
$error = "";
$success = "";

// Proses form (tambah/edit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_education'])) {
    $institution = trim($_POST['institution']);
    $major = trim($_POST['major']);
    $year = trim($_POST['year']);
    $description = trim($_POST['description']);
    $education_id = $_POST['id'] ?? null;

    if (empty($institution) || empty($year)) {
        $error = "Institusi dan tahun tidak boleh kosong.";
    } else {
        if ($education_id) { // Update
            $sql = "UPDATE education SET institution = :institution, major = :major, year = :year, description = :description WHERE id = :id";
        } else { // Insert
            $sql = "INSERT INTO education (institution, major, year, description) VALUES (:institution, :major, :year, :description)";
        }

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':institution', $institution, PDO::PARAM_STR);
            $stmt->bindParam(':major', $major, PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            if ($education_id) {
                $stmt->bindParam(':id', $education_id, PDO::PARAM_INT);
            }
            if ($stmt->execute()) {
                $success = "Riwayat pendidikan berhasil disimpan.";
                // Reset form
                $institution = "";
                $major = "";
                $year = "";
                $description = "";
                $education_id = null;
                $is_editing = false;
            } else {
                $error = "Gagal menyimpan riwayat pendidikan.";
            }
        }
    }
}

// Cek untuk mode edit
if (isset($_GET['edit'])) {
    $is_editing = true;
    $education_id = $_GET['edit'];
    $sql = "SELECT * FROM education WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $education_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $institution = $row['institution'];
            $major = $row['major'];
            $year = $row['year'];
            $description = $row['description'];
        }
    }
}

// Cek untuk hapus
if (isset($_GET['delete'])) {
    $education_id_to_delete = $_GET['delete'];
    $sql = "DELETE FROM education WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $education_id_to_delete, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("location: manage_education.php?deleted=true");
            exit;
        }
    }
}

if(isset($_GET['deleted'])) {
    $success = "Riwayat pendidikan berhasil dihapus.";
}

// Mengambil semua riwayat pendidikan
$education_entries = $pdo->query("SELECT * FROM education ORDER BY year DESC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Riwayat Pendidikan</title>
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
                    <li class="nav-item"><a class="nav-link" href="manage_social_media.php">Media Sosial</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_pengalaman.php">Pengalaman</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Manajemen Riwayat Pendidikan</h2>
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
                            <h5 class="card-title"><?= $is_editing ? 'Edit Riwayat Pendidikan' : 'Tambah Riwayat Pendidikan Baru' ?></h5>
                            <form action="manage_education.php" method="post">
                                <input type="hidden" name="id" value="<?= $education_id ?>">
                                <div class="mb-3">
                                    <label for="institution" class="form-label">Institusi</label>
                                    <input type="text" name="institution" id="institution" class="form-control" value="<?= htmlspecialchars($institution) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="major" class="form-label">Jurusan (Opsional)</label>
                                    <input type="text" name="major" id="major" class="form-control" value="<?= htmlspecialchars($major) ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="year" class="form-label">Tahun</label>
                                    <input type="text" name="year" id="year" class="form-control" value="<?= htmlspecialchars($year) ?>" placeholder="Contoh: 2020-2024" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea name="description" id="description" class="form-control" rows="3"><?= htmlspecialchars($description) ?></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="save_education" class="btn btn-custom">Simpan</button>
                                    <?php if ($is_editing): ?>
                                        <a href="manage_education.php" class="btn btn-secondary">Batal</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Riwayat Pendidikan -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Institusi</th>
                                            <th>Jurusan</th>
                                            <th>Tahun</th>
                                            <th>Deskripsi</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($education_entries) > 0): ?>
                                            <?php foreach ($education_entries as $entry): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($entry['institution']); ?></td>
                                                <td><?= htmlspecialchars($entry['major']); ?></td>
                                                <td><?= htmlspecialchars($entry['year']); ?></td>
                                                <td><?= htmlspecialchars(substr($entry['description'], 0, 50)); ?><?php echo (strlen($entry['description']) > 50) ? '...' : ''; ?></td>
                                                <td class="text-end">
                                                    <a href="manage_education.php?edit=<?= $entry['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="manage_education.php?delete=<?= $entry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat pendidikan ini?');"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada riwayat pendidikan.</td>
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
