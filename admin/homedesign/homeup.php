<?php
session_start();
require '../../config.php'; // Veritabanı bağlantısını dahil et

// Mevcut verileri çek
$query = "SELECT * FROM home_content WHERE id = 1";
$result = $conn->query($query);
$content = $result->fetch_assoc();

$video_directory = "../../home/video/"; // Video klasörü

// Form gönderimi ile verileri güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $header_text = trim($_POST['header_text']);
    $subheader_text = trim($_POST['subheader_text']);
    $event_date = $_POST['event_date'];
    
    // Eğer video dosyası yüklendiyse
    if (!empty($_FILES['video_file']['name'])) {
        $video_file = $_FILES['video_file'];
        
        // Video adını sabit olarak tanımla
        $video_name = 'tanitim.mp4';
        $video_path = $video_directory . $video_name;

        // Mevcut video dosyasını sil
        if (file_exists($video_path)) {
            unlink($video_path);
        }

        // Yeni video dosyasını yükle
        if (move_uploaded_file($video_file['tmp_name'], $video_path)) {
            // Veritabanına sadece video adını kaydet
            $stmt = $conn->prepare("UPDATE home_content SET header_text = ?, subheader_text = ?, event_date = ?, video_url = ? WHERE id = 1");
            $video_name_db = 'tanitim'; // Veritabanına kaydedilecek ad
            $stmt->bind_param("ssss", $header_text, $subheader_text, $event_date, $video_name_db);
        } else {
            echo "<script>alert('Video yükleme başarısız!');</script>";
        }
    } else {
        // Sadece diğer alanları güncelle (video_url hariç)
        $stmt = $conn->prepare("UPDATE home_content SET header_text = ?, subheader_text = ?, event_date = ? WHERE id = 1");
        $stmt->bind_param("sss", $header_text, $subheader_text, $event_date);
    }

    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('Bilgiler başarıyla güncellendi!'); window.location.href='homeup.php';</script>";
    exit;
}

// Video dosyasını silme işlemi
if (isset($_GET['delete_video']) && $_GET['delete_video'] == '1') {
    $video_path = $video_directory . 'tanitim.mp4';
    if (file_exists($video_path)) {
        unlink($video_path);
        // Veritabanında video adını temizle
        $stmt = $conn->prepare("UPDATE home_content SET video_url = '' WHERE id = 1");
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Video başarıyla silindi!'); window.location.href='homeup.php';</script>";
    } else {
        echo "<script>alert('Silinecek video bulunamadı!'); window.location.href='homeup.php';</script>";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Yan Menü -->
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
            <li><a href="./homeup.php">Ana Sayfa</a></li>
            <li><a href="../textdesign/textdesign.php">Hakkında-Motivasyon</a></li>
            <li><a href="../speakers/speakers.php">Konuşmacılar</a></li>
            <li><a href="../partners/partners.php">Sponsorlar</a></li>
        </ul>
    </div>

    <!-- Düzenleme Alanı -->
    <div class="content">
        <h1>Başlık, Tarih ve Video Düzenleme</h1>

        <form action="homeup.php" method="POST" enctype="multipart/form-data">
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

            <!-- Mevcut Video -->
            <div class="input-group">
                <label>Mevcut Video:</label>
                <?php if (!empty($content['video_url']) && file_exists($video_directory . $content['video_url'] . '.mp4')): ?>
                    <video width="320" height="240" controls>
                        <source src="../../home/video/<?php echo $content['video_url']; ?>.mp4" type="video/mp4">
                        Tarayıcınız video etiketini desteklemiyor.
                    </video>
                    <a href="homeup.php?delete_video=1" onclick="return confirm('Videoyu silmek istediğinizden emin misiniz?')">Videoyu Sil</a>
                <?php else: ?>
                    <p>Mevcut video yok.</p>
                <?php endif; ?>
            </div>

            <!-- Video Yükleme -->
            <div class="input-group">
                <label for="video_file">Video Yükle:</label>
                <input type="file" id="video_file" name="video_file" accept="video/mp4">
            </div>

            <!-- Güncelleme Butonu -->
            <button type="submit" class="login-btn">Güncelle</button>
        </form>
    </div>
</body>
</html>
