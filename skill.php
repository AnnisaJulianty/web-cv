
<?php
require_once 'config/database.php';

$skills = [];
$social_medias = [];

try {
    $skills = $pdo->query("SELECT * FROM skills ORDER BY category ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Skill - Annisa Julianty</title>
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
                    <li class="nav-item"><a class="nav-link" href="galeri.php">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link active" href="skill.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content: Skill -->
    <section class="content-section content-section-padded">
        <div class="container">
            <h2 class="section-title">Keahlian Saya</h2>
            <div class="row g-4"> <!-- Main row for skill categories -->
                <?php if (count($skills) > 0): ?>
                    <?php
                    $grouped_skills = [];
                    foreach ($skills as $skill) {
                        $grouped_skills[$skill['category']][] = $skill;
                    }

                    foreach ($grouped_skills as $category_name => $category_skills): ?>
                        <div class="col-md-6"> <!-- Each category box takes half width on medium screens -->
                            <div class="skill-category-box mb-4">
                                <h3 class="category-title mb-4"><?= htmlspecialchars($category_name); ?></h3>
                                <div class="row g-3"> <!-- Row for individual skill items within the box -->
                                    <?php foreach ($category_skills as $skill): ?>
                                        <div class="col-sm-6"> <!-- Each skill item takes half width on small screens -->
                                            <div class="skill-item-simple">
                                                <h4><?= htmlspecialchars($skill['name']); ?></h4>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">Belum ada skill yang ditambahkan.</p>
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
            <p class="text-center">&copy; 2025 Annisa Julianty. Dibuat dengan <i class="fa-solid fa-heart" style="color: var(--primary-color);"></i></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
