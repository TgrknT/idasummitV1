<?php
session_start();
require '../../config.php'; // Veritabanı bağlantısını dahil et

// Mevcut verileri çek
$query = "SELECT * FROM home_content WHERE id = 1";
$result = $conn->query($query);
$content = $result->fetch_assoc();

// Form gönderimi ile verileri güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $header_text = trim($_POST['header_text']);
    $subheader_text = trim($_POST['subheader_text']);
    $event_date = $_POST['event_date'];

    // Veritabanını güncelle
    $stmt = $conn->prepare("UPDATE home_content SET header_text = ?, subheader_text = ?, event_date = ? WHERE id = 1");
    $stmt->bind_param("sss", $header_text, $subheader_text, $event_date);
    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('Başlık ve tarih başarıyla güncellendi!'); window.location.href='homeup.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="style.css"> <!-- Yukarıdaki CSS dosyasını bağlayın -->
    <script>
        // Alt menülerin açılıp kapanmasını sağlamak için JavaScript
        function toggleMenu(menu) {
            menu.classList.toggle('open');
        }
    </script>
</head>
<body>

    <!-- Yan Menü -->
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
            <li class="menu">
                <a href="#" class="toggle" onclick="toggleMenu(this.parentNode)">Ana Sayfa</a>
                <ul class="submenu">
                    <li><a href="./homedesign/homeup.php">Üst Başlık</a></li>
                    <li><a href="./homedesign/homevideo.php">Video Düzenleme</a></li>
                </ul>
            </li>
            <li><a href="#">Kullanıcı Yönetimi</a></li>
            <li><a href="#">İçerik Düzenleme</a></li>
            <li><a href="#">Ayarlar</a></li>
        </ul>
    </div>

    <!-- Düzenleme Alanı -->
    <div class="content">
        <h1>Üst Başlık, Alt Başlık ve Tarih Düzenleme</h1>

        <form action="homeup.php" method="POST">
            <!-- Üst Başlık Düzenleme -->
            <div class="input-group">
                <label for="header_text">Üst Başlık:</label>
                <input type="text" id="header_text" name="header_text" value="<?php echo $content['header_text']; ?>" required>
            </div>

            <!-- Alt Başlık Düzenleme -->
            <div class="input-group">
                <label for="subheader_text">Alt Başlık:</label>
                <input type="text" id="subheader_text" name="subheader_text" value="<?php echo $content['subheader_text']; ?>" required>
            </div>

            <!-- Tarih Düzenleme -->
            <div class="input-group">
                <label for="event_date">Etkinlik Tarihi:</label>
                <input type="datetime-local" id="event_date" name="event_date" value="<?php echo date('Y-m-d\TH:i', strtotime($content['event_date'])); ?>" required>
            </div>

            <!-- Güncelleme Butonu -->
            <button type="submit" class="login-btn">Güncelle</button>
        </form>
    </div>
</body>
</html>