<?php
session_start();
require '../config.php'; // Veritabanı bağlantısını çağır

$error_message = ''; // Hata mesajı için boş bir değişken
$success_message = ''; // Başarı mesajı için boş bir değişken

// Form gönderildiyse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = trim($_POST['ad_soyad']);
    $okul = trim($_POST['okul']);
    $bolum = trim($_POST['bolum']);
    $sinif = trim($_POST['sinif']);
    $cep_tel = trim($_POST['cep_tel']);
    $email = trim($_POST['email']);

    // Telefon ve e-posta kontrolü için sorgu
    $stmt = $conn->prepare("SELECT * FROM katilimcilar WHERE cep_tel = ? OR email = ?");
    $stmt->bind_param("ss", $cep_tel, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Eğer kayıt varsa hata mesajı göster
        $error_message = "Bu telefon numarası veya e-posta adresi zaten kayıtlı!";
    } else {
        // Kayıt yoksa veritabanına ekleyin
        $stmt = $conn->prepare("INSERT INTO katilimcilar (ad_soyad, okul, bolum, sinif, cep_tel, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $ad_soyad, $okul, $bolum, $sinif, $cep_tel, $email);

        // Veritabanına ekleme işlemi
        if ($stmt->execute()) {
            // Başarılıysa mesajı ayarla
            $success_message = "Form başarıyla gönderildi!";
        } else {
            // Hata varsa
            $error_message = "Kayıt sırasında bir hata oluştu: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();

    // Hata veya başarı durumuna göre yönlendirme yapma
    if ($error_message) {
        header("Location: form.php?error=" . urlencode($error_message));
        exit;
    } elseif ($success_message) {
        header("Location: form.php?success=" . urlencode($success_message));
        exit;
    }
}
?>
