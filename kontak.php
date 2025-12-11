
<?php
require_once 'config/database.php';

$contact_info = [];
$social_medias = [];

try {
    $stmt = $pdo->query("SELECT name, value FROM contact_info");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $contact_info[$row['name']] = $row['value'];
    }
} catch (PDOException $e) {
    // Log error or handle gracefully
}

try {
    $stmt = $pdo->query("SELECT * FROM social_media ORDER BY display_order ASC, id ASC");
    $social_medias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error or handle gracefully
}

// Default values if not found in DB
$contact_info['Alamat'] = $contact_info['Alamat'] ?? 'Purwokerto, Jawa Tengah';
$contact_info['Email'] = $contact_info['Email'] ?? 'email@example.com';
$contact_info['Telepon'] = $contact_info['Telepon'] ?? '+62 123 4567 890';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Annisa Julianty</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Custom CSS -->
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
                    <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="skill.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link active" href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content: Kontak -->
    <section class="content-section">
        <div class="container">
            <h2 class="text-center mb-5">Hubungi Saya</h2>
            <div class="row">
                <div class="col-md-6">
                    <form action="kirim_pesan.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="contact-info">
                        <h4>Info Kontak</h4>
                        <?php if (isset($contact_info['Email'])): ?>
                            <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($contact_info['Email']); ?></p>
                        <?php endif; ?>
                        <?php if (isset($contact_info['Telepon'])): ?>
                            <p><i class="fas fa-phone"></i> <?= htmlspecialchars($contact_info['Telepon']); ?></p>
                        <?php endif; ?>
                        <?php if (isset($contact_info['Alamat'])): ?>
                            <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($contact_info['Alamat']); ?></p>
                        <?php endif; ?>
                        <hr>
                        <h4>Sosial Media</h4>
                        <div class="social-icons">
                            <?php if (count($social_medias) > 0): ?>
                                <?php foreach ($social_medias as $social): ?>
                                    <a href="<?= htmlspecialchars($social['url']); ?>" target="_blank" class="social-icon"><i class="<?= htmlspecialchars($social['icon_class']); ?>"></i></a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback: hardcoded Instagram link as before -->
                                <a href="https://www.instagram.com/_annisajlnty" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
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
            <p class="text-center">&copy; 2025 Annisa Julianty. Dibuat dengan <i class="fa-solid fa-heart" style="color: var(--primary-color);"></i></p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
