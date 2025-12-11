<?php
session_start();
unset($_SESSION['admin_logged_in']); // Explicitly unset to force re-login

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("location: dashboard.php");
    exit;
}

// --- LOGIN TANPA DATABASE (TIDAK AMAN) ---
// Tanam username dan password langsung di kode
const ADMIN_USERNAME = 'admin';
const ADMIN_PASSWORD = 'password123';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        // Jika username dan password cocok, buat session dan redirect
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_username"] = $username;
        header("location: dashboard.php");
        exit;
    } else {
        // Jika tidak cocok, tampilkan error
        $error = "Username atau password yang Anda masukkan salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CV Annisa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
        }
        .form-label, .form-check-label {
            color: #ffffff; /* White color for labels */
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="card login-card">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Admin Login</h3>
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="showPassword">
                    <label class="form-check-label" for="showPassword">Tampilkan Password</label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-custom">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        const showPasswordCheckbox = document.getElementById('showPassword');
        const passwordInput = document.getElementById('password');

        showPasswordCheckbox.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });

        particlesJS("particles-js", {
          "particles": {
            "number": {"value": 80,"density": {"enable": true,"value_area": 800}},
            "color": {"value": "#ffffff"},
            "shape": {"type": "circle"},
            "opacity": {"value": 0.5,"random": false},
            "size": {"value": 3,"random": true},
            "line_linked": {"enable": true,"distance": 150,"color": "#ffffff","opacity": 0.4,"width": 1},
            "move": {"enable": true,"speed": 6,"direction": "none","random": false,"straight": false,"out_mode": "out"}
          },
          "interactivity": {
            "detect_on": "canvas",
            "events": {"onhover": {"enable": true,"mode": "repulse"},"onclick": {"enable": true,"mode": "push"}},
            "modes": {"repulse": {"distance": 100}}
          },
          "retina_detect": true
        });
    </script>
</body>
</html>