<?php
session_start();
require '../../config.php'; // Veritabanı bağlantısı

// Eğer giriş yapılmamışsa kullanıcıyı login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Mevcut verileri çek
$query = "SELECT * FROM section_content";
$result = $conn->query($query);

// Verileri bir diziye al
$sections = [];
while ($row = $result->fetch_assoc()) {
    $sections[$row['section_name']] = $row;
}

// Form gönderimi ile verileri güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section_name = $_POST['section_name'];
    $content_text = trim($_POST['content_text']);
    $image_file = $_FILES['image_file'];

    // Resim dosyası yüklendiyse
    if (!empty($image_file['name'])) {
        $file_info = pathinfo($image_file['name']);
        $image_name = $file_info['filename'] . '.' . $file_info['extension']; // Dosya adı ve uzantısı
        $image_path = "../../home/images/" . $image_name;

        // Mevcut resmi sil
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Yeni resmi yükle
        if (move_uploaded_file($image_file['tmp_name'], $image_path)) {
            // Veritabanını güncelle (resim adı ve içerik)
            $stmt = $conn->prepare("UPDATE section_content SET content_text = ?, image_url = ? WHERE section_name = ?");
            $stmt->bind_param("sss", $content_text, $image_name, $section_name);
        } else {
            echo "<script>alert('Resim yükleme başarısız!');</script>";
        }
    } else {
        // Sadece metni güncelle
        $stmt = $conn->prepare("UPDATE section_content SET content_text = ? WHERE section_name = ?");
        $stmt->bind_param("ss", $content_text, $section_name);
    }

    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('İçerik başarıyla güncellendi!'); window.location.href='textdesign.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İçerik Düzenleme Paneli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Yan Menü -->
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
            <li><a href="../homedesign/homeup.php">Ana Sayfa</a></li>
            <li><a href="./textdesign.php">Hakkında-Motivasyon</a></li>
            <li><a href="../speakers/speakers.php">Konuşmacılar</a></li>
            <li><a href="../partners/partners.php">Sponsorlar</a></li>
            <li><a href="../katilim/katilim.php">Katılımcılar</a></li>
        </ul>
    </div>

    <!-- Düzenleme Alanı -->
    <div class="content">
        <h1>İçerik Düzenleme</h1>

        <!-- Hakkında Bölümü -->
        <?php if (isset($sections['hakkinda'])): ?>
            <form action="textdesign.php" method="POST" enctype="multipart/form-data">
                <h2>Hakkında Bölümü</h2>

                <!-- İçerik Metni -->
                <div class="input-group">
                    <label for="content_text_hakkinda">İçerik Metni:</label>
                    <textarea id="content_text_hakkinda" name="content_text" rows="5" required><?php echo $sections['hakkinda']['content_text']; ?></textarea>
                </div>

                <!-- Mevcut Resim -->
                <div class="input-group">
                    <label>Mevcut Resim:</label>
                    <img src="../../home/content/<?php echo $sections['hakkinda']['image_url']; ?>" alt="Hakkında Resmi" width="200">
                </div>

                <!-- Resim Yükleme -->
                <div class="input-group">
                    <label for="image_file_hakkinda">Resim Yükle:</label>
                    <input type="file" id="image_file_hakkinda" name="image_file" accept="image/*">
                </div>

                <!-- Gönderim Butonu -->
                <input type="hidden" name="section_name" value="hakkinda">
                <button type="submit" class="login-btn">Hakkında Bölümünü Güncelle</button>
            </form>
        <?php endif; ?>

        <!-- Motivasyon Bölümü -->
        <?php if (isset($sections['motivasyon'])): ?>
            <form action="textdesign.php" method="POST" enctype="multipart/form-data">
                <h2>Motivasyon Bölümü</h2>

                <!-- İçerik Metni -->
                <div class="input-group">
                    <label for="content_text_motivasyon">İçerik Metni:</label>
                    <textarea id="content_text_motivasyon" name="content_text" rows="5" required><?php echo $sections['motivasyon']['content_text']; ?></textarea>
                </div>

                <!-- Mevcut Resim -->
                <div class="input-group">
                    <label>Mevcut Resim:</label>
                    <img src="../../home/content/<?php echo $sections['motivasyon']['image_url']; ?>" alt="Motivasyon Resmi" width="200">
                </div>

                <!-- Resim Yükleme -->
                <div class="input-group">
                    <label for="image_file_motivasyon">Resim Yükle:</label>
                    <input type="file" id="image_file_motivasyon" name="image_file" accept="image/*">
                </div>

                <!-- Gönderim Butonu -->
                <input type="hidden" name="section_name" value="motivasyon">
                <button type="submit" class="login-btn">Motivasyon Bölümünü Güncelle</button>
            </form>
        <?php endif; ?>

    </div>
</body>
</html>
