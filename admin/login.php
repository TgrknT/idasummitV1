<?php
session_start();
require '../config.php'; // Veritabanı bağlantısını çağır

$error_message = ''; // Hata mesajı için boş bir değişken

// Eğer giriş denemesi yapıldıysa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // SQL sorgusu hazırlayıp veritabanından kullanıcıyı al
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Kullanıcı varsa ve şifre doğruysa
    if ($user && $user['password'] === $password) {
        // Oturumu başlat
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Başarıyla giriş yaptınız!";
        // Kullanıcıyı admin panele yönlendirebiliriz.
        header("Location: adminpanel.php");
        exit;
    } else {
        $error_message = "Geçersiz kullanıcı adı veya şifre!";
    }

    $stmt->close(); // Sorguyu kapat
}
?>




<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>İda Summit Admin Paneline Giriş Yap</h2>

            <!-- Hata Mesajı -->
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="username">Kullanıcı Adı</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Şifre</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="login-btn">Giriş Yap</button>
            </form>
        </div>
    </div>
</body>
</html>
