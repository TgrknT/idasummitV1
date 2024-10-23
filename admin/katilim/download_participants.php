<?php
require '../../config.php'; // Veritabanı bağlantısını dahil et

// Katılımcı verilerini veritabanından çek
$query = "SELECT * FROM katilim_formu";
$result = $conn->query($query);

// Word dosyası başlıkları
$word_content = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">';
$word_content .= '<head><meta charset="UTF-8"><title>Katılımcı Listesi</title></head>';
$word_content .= '<body>';
$word_content .= '<h1 style="text-align: center;">Katılımcı Listesi</h1>';
$word_content .= '<table border="1" style="width: 100%; border-collapse: collapse;">';
$word_content .= '<tr>';
$word_content .= '<th>ID</th>';
$word_content .= '<th>Ad Soyad</th>';
$word_content .= '<th>Okul</th>';
$word_content .= '<th>Bölüm</th>';
$word_content .= '<th>Sınıf</th>';
$word_content .= '<th>Telefon</th>';
$word_content .= '<th>E-mail</th>';
$word_content .= '</tr>';

// Verileri tabloya ekle
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $word_content .= '<tr>';
        $word_content .= '<td>' . $row['id'] . '</td>';
        $word_content .= '<td>' . $row['ad_soyad'] . '</td>';
        $word_content .= '<td>' . $row['okul'] . '</td>';
        $word_content .= '<td>' . $row['bolum'] . '</td>';
        $word_content .= '<td>' . $row['sinif'] . '</td>';
        $word_content .= '<td>' . $row['cep_tel'] . '</td>';
        $word_content .= '<td>' . $row['email'] . '</td>';
        $word_content .= '</tr>';
    }
} else {
    $word_content .= '<tr><td colspan="7">Katılımcı bulunamadı.</td></tr>';
}

$word_content .= '</table>';
$word_content .= '</body></html>';

// İndirme için Word dosyası başlıklarını ayarla
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Katilimci_Listesi.doc");

// Word dosyasını çıktı olarak gönder
echo $word_content;
exit;
?>
