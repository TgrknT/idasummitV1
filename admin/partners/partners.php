<?php
session_start();
require '../../config.php'; // Veritabanı bağlantısı

// Eğer giriş yapılmamışsa kullanıcıyı login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Mevcut partner verilerini çek
$query = "SELECT * FROM partnerler";
$result = $conn->query($query);

// Verileri bir diziye al
$partners = [];
while ($row = $result->fetch_assoc()) {
    $partners[] = $row;
}

// Partneri silme işlemi
if (isset($_GET['delete_id'])) {
    $partner_id = $_GET['delete_id'];

    // Partnerin logo dosyasını sil
    $query = "SELECT logo_name FROM partnerler WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $partner_id);
    $stmt->execute();
    $stmt->bind_result($logo_name);
    $stmt->fetch();
    $stmt->close();

    if (!empty($logo_name) && file_exists("../../home/partnerler/" . $logo_name)) {
        unlink("../../home/partnerler/" . $logo_name);
    }

    // Partneri veritabanından sil
    $stmt = $conn->prepare("DELETE FROM partnerler WHERE id = ?");
    $stmt->bind_param("i", $partner_id);
    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('Partner başarıyla silindi!'); window.location.href='partners.php';</script>";
    exit;
}

// Partneri ekleme işlemi
if (isset($_POST['add_partner'])) {
    $partner_name = trim($_POST['partner_name']);
    $link = trim($_POST['link']);
    $logo_file = $_FILES['logo_file'];

    // Logo dosyası yüklendiyse
    if (!empty($logo_file['name'])) {
        $file_info = pathinfo($logo_file['name']);
        $logo_name = $file_info['filename'] . '.' . $file_info['extension']; // Dosya adı ve uzantısı
        $logo_path = "../../home/partnerler/" . $logo_name;

        // Yeni logoyu yükle
        if (move_uploaded_file($logo_file['tmp_name'], $logo_path)) {
            // Veritabanına yeni partneri ekle
            $stmt = $conn->prepare("INSERT INTO partnerler (partner_name, link, logo_name) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $partner_name, $link, $logo_name);
            $stmt->execute();
            $stmt->close();

            // Başarılı mesajı ve sayfayı yenileme
            echo "<script>alert('Partner başarıyla eklendi!'); window.location.href='partners.php';</script>";
            exit;
        } else {
            echo "<script>alert('Logo yükleme başarısız!');</script>";
        }
    } else {
        echo "<script>alert('Lütfen bir logo seçin.');</script>";
    }
}

// Form gönderimi ile partner verilerini güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['add_partner'])) {
    $partner_id = $_POST['partner_id'];
    $partner_name = trim($_POST['partner_name']);
    $link = trim($_POST['link']);
    $logo_file = $_FILES['logo_file'];

    // Logo dosyası yüklendiyse
    if (!empty($logo_file['name'])) {
        $file_info = pathinfo($logo_file['name']);
        $logo_name = $file_info['filename'] . '.' . $file_info['extension']; // Dosya adı ve uzantısı
        $logo_path = "../../home/partnerler/" . $logo_name;

        // Mevcut logoyu sil
        if (file_exists($logo_path)) {
            unlink($logo_path);
        }

        // Yeni logoyu yükle
        if (move_uploaded_file($logo_file['tmp_name'], $logo_path)) {
            // Veritabanını güncelle (logo adı, partner adı ve link)
            $stmt = $conn->prepare("UPDATE partnerler SET partner_name = ?, link = ?, logo_name = ? WHERE id = ?");
            $stmt->bind_param("sssi", $partner_name, $link, $logo_name, $partner_id);
        } else {
            echo "<script>alert('Logo yükleme başarısız!');</script>";
        }
    } else {
        // Sadece partner adı ve linki güncelle
        $stmt = $conn->prepare("UPDATE partnerler SET partner_name = ?, link = ? WHERE id = ?");
        $stmt->bind_param("ssi", $partner_name, $link, $partner_id);
    }

    $stmt->execute();
    $stmt->close();

    // Başarılı mesajı ve sayfayı yenileme
    echo "<script>alert('Partner bilgileri başarıyla güncellendi!'); window.location.href='partners.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Düzenleme Paneli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Yan Menü -->
    <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
            <li><a href="../homedesign/homeup.php">Ana Sayfa</a></li>
            <li><a href="../textdesign/textdesign.php">Hakkında-Motivasyon</a></li>
            <li><a href="../speakers/speakers.php">Konuşmacılar</a></li>
            <li><a href="./partners.php">Partnerler</a></li>
            <li><a href="../katilim/katilim.php">Katılımcılar</a></li>
        </ul>
    </div>

    <!-- Düzenleme Alanı -->
    <div class="content">
        <h1>Partner Düzenleme</h1>

        <!-- Yeni Partner Ekleme Formu -->
        <form action="partners.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 40px;">
            <h2>Yeni Partner Ekle</h2>

            <!-- Partner Adı Ekleme -->
            <div class="input-group">
                <label for="partner_name">Partner Adı:</label>
                <input type="text" id="partner_name" name="partner_name" placeholder="Partner Adı" required>
            </div>

            <!-- Link Ekleme -->
            <div class="input-group">
                <label for="link">Link:</label>
                <input type="url" id="link" name="link" placeholder="Partner Linki" required>
            </div>

            <!-- Logo Yükleme -->
            <div class="input-group">
                <label for="logo_file">Logo Yükle:</label>
                <input type="file" id="logo_file" name="logo_file" accept="image/*" required>
            </div>

            <!-- Gönderim Butonu -->
            <button type="submit" name="add_partner" class="login-btn">Partner Ekle</button>
        </form>

        <?php if (!empty($partners)): ?>
            <?php foreach ($partners as $partner): ?>
                <form action="partners.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 20px;">
                    <h2><?php echo $partner['partner_name']; ?></h2>

                    <!-- Partner Adı Düzenleme -->
                    <div class="input-group">
                        <label for="partner_name_<?php echo $partner['id']; ?>">Partner Adı:</label>
                        <input type="text" id="partner_name_<?php echo $partner['id']; ?>" name="partner_name" value="<?php echo $partner['partner_name']; ?>" required>
                    </div>

                    <!-- Link Düzenleme -->
                    <div class="input-group">
                        <label for="link_<?php echo $partner['id']; ?>">Link:</label>
                        <input type="url" id="link_<?php echo $partner['id']; ?>" name="link" value="<?php echo $partner['link']; ?>" required>
                    </div>

                    <!-- Mevcut Logo -->
                    <div class="input-group">
                        <label>Mevcut Logo:</label>
                        <img src="../../home/partnerler/<?php echo $partner['logo_name']; ?>" alt="<?php echo $partner['partner_name']; ?>" width="200">
                    </div>

                    <!-- Logo Yükleme -->
                    <div class="input-group">
                        <label for="logo_file_<?php echo $partner['id']; ?>">Logo Yükle:</label>
                        <input type="file" id="logo_file_<?php echo $partner['id']; ?>" name="logo_file" accept="image/*">
                    </div>

                    <!-- Gönderim ve Kaldırma Butonları -->
                    <input type="hidden" name="partner_id" value="<?php echo $partner['id']; ?>">
                    <button type="submit" class="login-btn">Partneri Güncelle</button>
                    <a href="partners.php?delete_id=<?php echo $partner['id']; ?>" class="delete-btn" onclick="return confirm('Bu partneri silmek istediğinizden emin misiniz?')">Partneri Kaldır</a>
                </form>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Henüz partner eklenmemiş.</p>
        <?php endif; ?>

    </div>
</body>
</html>
