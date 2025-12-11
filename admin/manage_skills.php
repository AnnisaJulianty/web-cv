<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$name = "";
$category = "";
$skill_id = null;
$is_editing = false;
$error = "";
$success = "";

// Proses form (tambah/edit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_skill'])) {
    $name = trim($_POST['name']);
$category = trim($_POST['category']);
    $skill_id = $_POST['id'] ?? null;

    if (empty($name) || empty($category)) {
        $error = "Nama dan kategori tidak boleh kosong.";
    } else {
        if ($skill_id) { // Update
            $sql = "UPDATE skills SET name = :name, category = :category WHERE id = :id";
        } else { // Insert
            $sql = "INSERT INTO skills (name, category) VALUES (:name, :category)";
        }

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            if ($skill_id) {
                $stmt->bindParam(':id', $skill_id, PDO::PARAM_INT);
            }
            if ($stmt->execute()) {
                $success = "Skill berhasil disimpan.";
                // Reset form
                $name = "";
                $category = "";
                $skill_id = null;
                $is_editing = false;
            } else {
                $error = "Gagal menyimpan skill.";
            }
        }
    }
}

// Cek untuk mode edit
if (isset($_GET['edit'])) {
    $is_editing = true;
    $skill_id = $_GET['edit'];
    $sql = "SELECT * FROM skills WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $skill_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($row = $stmt->fetch()) {
            $name = $row['name'];
            $category = $row['category'];
        }
    }
}

// Cek untuk hapus
if (isset($_GET['delete'])) {
    $skill_id_to_delete = $_GET['delete'];
    $sql = "DELETE FROM skills WHERE id = :id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(':id', $skill_id_to_delete, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("location: manage_skills.php?deleted=true");
            exit;
        }
    }
}

if(isset($_GET['deleted'])) {
    $success = "Skill berhasil dihapus.";
}

// Mengambil semua skill
$skills = $pdo->query("SELECT * FROM skills ORDER BY category ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Skill</title>
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
            <h2 class="section-title">Manajemen Skill</h2>
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
                            <h5 class="card-title"><?= $is_editing ? 'Edit Skill' : 'Tambah Skill Baru' ?></h5>
                            <form action="manage_skills.php" method="post">
                                <input type="hidden" name="id" value="<?= $skill_id ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Skill</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <input type="text" name="category" id="category" class="form-control" value="<?= htmlspecialchars($category) ?>" required>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="save_skill" class="btn btn-custom">Simpan</button>
                                    <?php if ($is_editing): ?>
                                        <a href="manage_skills.php" class="btn btn-secondary">Batal</a>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabel Skill -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Skill</th>
                                            <th>Kategori</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($skills) > 0): ?>
                                            <?php foreach ($skills as $skill): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($skill['name']); ?></td>
                                                <td><?= htmlspecialchars($skill['category']); ?></td>
                                                <td class="text-end">
                                                    <a href="manage_skills.php?edit=<?= $skill['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                                    <a href="manage_skills.php?delete=<?= $skill['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus skill ini?');"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Belum ada skill.</td>
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
