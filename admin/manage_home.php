<?php
require_once 'auth_check.php';
require_once '../config/database.php';

$error = "";
$success = "";

// Fetch all home info items
$home_info_items = $pdo->query("SELECT * FROM home_info ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// Handle POST request for updating home info
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_home_info'])) {
    foreach ($home_info_items as $item) {
        $key = $item['key'];
        $new_value = trim($_POST['value_' . $item['id']] ?? '');

        if (empty($new_value)) {
            $error = "Semua bidang tidak boleh kosong.";
            break;
        }

        $sql = "UPDATE home_info SET value = :value WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':value', $new_value, PDO::PARAM_STR);
            $stmt->bindParam(':id', $item['id'], PDO::PARAM_INT);
            if (!$stmt->execute()) {
                $error = "Gagal memperbarui informasi untuk " . htmlspecialchars($key) . ".";
                break;
            }
        } else {
            $error = "Gagal menyiapkan statement untuk " . htmlspecialchars($key) . ".";
            break;
        }
    }

    if (empty($error)) {
        $success = "Informasi beranda berhasil diperbarui.";
        // Re-fetch items to display updated values
        $home_info_items = $pdo->query("SELECT * FROM home_info ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Info Beranda</title>
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
            <h2 class="section-title">Manajemen Info Beranda</h2>
            <div class="text-center mb-4">
                <a href="dashboard.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Dashboard</a>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Informasi Beranda</h5>
                    <form action="manage_home.php" method="post">
                        <?php foreach ($home_info_items as $item): ?>
                            <div class="mb-3">
                                <label for="value_<?= $item['id'] ?>" class="form-label"><?= ucwords(str_replace('_', ' ', htmlspecialchars($item['key']))) ?></label>
                                <?php if ($item['key'] == 'about_me' || $item['key'] == 'hobby'): ?>
                                    <textarea name="value_<?= $item['id'] ?>" id="value_<?= $item['id'] ?>" class="form-control" rows="5"><?= htmlspecialchars($item['value']) ?></textarea>
                                <?php else: ?>
                                    <input type="text" name="value_<?= $item['id'] ?>" id="value_<?= $item['id'] ?>" class="form-control" value="<?= htmlspecialchars($item['value']) ?>" required>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="save_home_info" class="btn btn-custom">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
