
<?php
require_once 'config/database.php';

$home_data = [];
try {
    $stmt = $pdo->query("SELECT `key`, `value` FROM home_info");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $home_data[$row['key']] = $row['value'];
    }
} catch (PDOException $e) {
    // Log error or handle gracefully
    // For now, we'll just let it be empty if there's an error
}

// Fetch social media data
$social_medias = [];
try {
    $stmt = $pdo->query("SELECT * FROM social_media ORDER BY display_order ASC, id ASC");
    $social_medias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error or handle gracefully
    // For now, we'll just let it be empty if there's an error
}

// Default values if not found in DB
$home_data['main_title'] = $home_data['main_title'] ?? 'Annisa Julianty';
$home_data['subtitle'] = $home_data['subtitle'] ?? 'Pelajar | Pengembang Perangkat Lunak & Gim';
$home_data['about_me'] = $home_data['about_me'] ?? 'Saya seorang mahasiswi sistem informasi semester 6 di Universitas Muhammadiyah Purwokerto. Saya memiliki minat besar dalam pengembangan web dan desain UI/UX. Saya selalu bersemangat untuk mempelajari hal-hal baru dan berkolaborasi dalam proyek-proyek yang menantang.';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Annisa Julianty</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div id="particles-js"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Annisa Julianty</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Tentang saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="pendidikan.php">Pendidikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="pengalaman.php">Pengalaman</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeri.php">Project</a></li>
                    <li class="nav-item"><a class="nav-link" href="skill.php">Skill</a></li>
                    <li class="nav-item"><a class="nav-link" href="artikel.php">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content: About Me -->
    <section class="content-section hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img src="annisa.jpg" alt="Foto Profil Annisa Julianty" class="profile-pic">
                    <div class="social-icons mt-4">
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
                <div class="col-md-8 text-start">
                    <h1 class="animate__animated animate__fadeInDown"><?php echo htmlspecialchars($home_data['main_title']); ?></h1>
                    <p class="lead animate__animated animate__fadeInUp"><?php echo htmlspecialchars($home_data['subtitle']); ?></p>
                    <div class="about-details mt-4">
                        <div class="detail-item"><strong>Umur:</strong> <?php echo htmlspecialchars($home_data['umur'] ?? '20'); ?></div>
                        <div class="detail-item"><strong>Lahir:</strong> 10 Juli 2009</div>
                        <div class="detail-item"><strong>Status:</strong> Pelajar</div>
                        <div class="detail-item"><strong>Hobi:</strong> <?php echo htmlspecialchars($home_data['hobby'] ?? 'Membaca, Menulis, dan Mendengarkan Musik'); ?></div>
                    </div>
                    <p class="mt-4">
                        <?php echo nl2br(htmlspecialchars($home_data['about_me'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

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
                        <p><i class="fas fa-envelope"></i> email@example.com</p>
                        <p><i class="fas fa-phone"></i> +62 123 4567 890</p>
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
            <p>&copy; 2025 Annisa Julianty. Dibuat dengan <i class="fa-solid fa-heart" style="color: var(--primary-color);"></i></p>
            <!-- Opsional: Tambahkan link sosial media di sini -->
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
          "particles": {
            "number": {
              "value": 80,
              "density": {
                "enable": true,
                "value_area": 800
              }
            },
            "color": {
              "value": "#ffffff"
            },
            "shape": {
              "type": "circle",
              "stroke": {
                "width": 0,
                "color": "#000000"
              },
              "polygon": {
                "nb_sides": 5
              }
            },
            "opacity": {
              "value": 0.5,
              "random": false,
              "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
              }
            },
            "size": {
              "value": 3,
              "random": true,
              "anim": {
                "enable": false,
                "speed": 40,
                "size_min": 0.1,
                "sync": false
              }
            },
            "line_linked": {
              "enable": true,
              "distance": 150,
              "color": "#ffffff",
              "opacity": 0.4,
              "width": 1
            },
            "move": {
              "enable": true,
              "speed": 6,
              "direction": "none",
              "random": false,
              "straight": false,
              "out_mode": "out",
              "bounce": false,
              "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
              }
            }
          },
          "interactivity": {
            "detect_on": "canvas",
            "events": {
              "onhover": {
                "enable": true,
                "mode": "repulse"
              },
              "onclick": {
                "enable": true,
                "mode": "push"
              },
              "resize": true
            },
            "modes": {
              "grab": {
                "distance": 400,
                "line_linked": {
                  "opacity": 1
                }
              },
              "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
              },
              "repulse": {
                "distance": 200,
                "duration": 0.4
              },
              "push": {
                "particles_nb": 4
              },
              "remove": {
                "particles_nb": 2
              }
            }
          },
          "retina_detect": true
        });
    </script>
</body>
</html>
