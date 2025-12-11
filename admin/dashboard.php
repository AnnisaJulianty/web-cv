<?php
require_once 'auth_check.php';
require_once '../config/database.php';

// Mengambil semua artikel dari database
$sql = "SELECT * FROM articles ORDER BY created_at DESC";
$articles = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kategori.php">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_home.php">Info Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_skills.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_education.php">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_pengalaman.php">Pengalaman</a></li>
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

    <!-- Content -->
    <section class="content-section content-section-padded">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title" style="margin-bottom: 0;">Manajemen Artikel</h2>
                <a href="manage_article.php" class="btn btn-custom"><i class="fa-solid fa-plus me-2"></i>Tambah Artikel</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($articles) > 0): ?>
                                    <?php foreach ($articles as $index => $article): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                                        <td><?php echo date('d M Y', strtotime($article['created_at'])); ?></td>
                                        <td>
                                            <a href="manage_article.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                                            <a href="delete_article.php?id=<?php echo $article['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada artikel.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>