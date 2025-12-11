<?php
require_once 'config/database.php';

$education_entries = [];
$social_medias = [];

try {
    $education_entries = $pdo->query("SELECT * FROM education ORDER BY year DESC")->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Pendidikan - Annisa Julianty</title>
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
                    <li class="nav-item"><a class="nav-link active" href="pendidikan.php">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="pengalaman.php">Pengalaman</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="skill.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content: Pendidikan -->
    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Riwayat Pendidikan</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php if (count($education_entries) > 0): ?>
                        <div class="accordion" id="educationAccordion">
                            <?php foreach ($education_entries as $index => $entry): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
                                            <i class="fa-solid fa-graduation-cap me-2"></i> <?= htmlspecialchars($entry['institution']); ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $index ?>" data-bs-parent="#educationAccordion">
                                        <div class="accordion-body">
                                            <p class="period"><strong>Tahun:</strong> <?= htmlspecialchars($entry['year']); ?></p>
                                            <p class="major"><strong>Jurusan:</strong> <?= htmlspecialchars($entry['major']); ?></p>
                                            <?php if (!empty($entry['description'])): ?>
                                                <hr>
                                                <p class="description">
                                                    <?= nl2br(htmlspecialchars($entry['description'])); ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center">Belum ada riwayat pendidikan yang ditambahkan.</p>
                    <?php endif; ?>
                </div>
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