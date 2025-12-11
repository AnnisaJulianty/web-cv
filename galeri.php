<?php
require_once 'config/database.php';

$projects = [];
$social_medias = [];

try {
    $projects = $pdo->query("SELECT * FROM projects ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error or handle gracefully
}

try {
    $stmt = $pdo->query("SELECT * FROM social_media ORDER BY display_order ASC, id ASC");
    $social_medias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error or handle gracefully
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri - Annisa Julianty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Annisa Julianty</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">About Me</a></li>
                    <li class="nav-item"><a class="nav-link" href="pendidikan.php">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="pengalaman.php">Pengalaman</a></li>
                    <li class="nav-item"><a class="nav-link active" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="skill.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content: Galeri -->
    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Galeri Projek</h2>
            <div class="row g-4">
                <?php if (count($projects) > 0): ?>
                    <?php foreach ($projects as $project): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <?php if ($project['image_path']): ?>
                                <a href="<?= htmlspecialchars($project['image_path']); ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?= htmlspecialchars($project['image_path']); ?>" class="card-img-top" alt="<?= htmlspecialchars($project['title']); ?>">
                                </a>
                            <?php else: ?>
                                <a href="https://via.placeholder.com/400x250/00ddff/0d021a?text=No Image" target="_blank" rel="noopener noreferrer">
                                <img src="https://via.placeholder.com/400x250/00ddff/0d021a?text=No Image" class="card-img-top" alt="No Image">
                                </a>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($project['title']); ?></h5>
                                <p class="card-text"><?= nl2br(htmlspecialchars($project['description'])); ?>
                                    <?php if ($project['link']): ?>
                                        Bisa juga <a href="<?= htmlspecialchars($project['link']); ?>" target="_blank">klik disini</a>.
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">Belum ada proyek yang ditambahkan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="social-icons text-center mb-3">
                <?php if (count($social_medias) > 0): ?>
                    <?php foreach ($social_medias as $social): ?>
                        <a href="<?= htmlspecialchars($social['url']); ?>" target="_blank" class="social-icon"><i class="<?= htmlspecialchars($social['icon_class']); ?>"></i></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback: hardcoded Instagram link as before -->
                    <a href="https://www.instagram.com/_annisajlnty" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
            </div>
            <p class="text-center">&copy; 2025 Annisa Julianty. Dibuat dengan <i class="fa-solid fa-heart"></i></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>