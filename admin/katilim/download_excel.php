<?php
require '../../config.php'; // Veritabanı bağlantısını dahil et

// Katılımcı verilerini veritabanından çek
$query = "SELECT * FROM katilim_formu";
$result = $conn->query($query);

// Excel başlıkları
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename="Katilimci_Listesi.xls"');

// UTF-8 BOM ekle (Excel'de Türkçe karakterlerin düzgün görünmesi için)
echo "\xEF\xBB\xBF";

// Başlıkları yaz
echo '<table border="1" style="border-collapse: collapse;">';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Ad Soyad</th>';
echo '<th>Okul</th>';
echo '<th>Bölüm</th>';
echo '<th>Sınıf</th>';
echo '<th>Telefon</th>';
echo '<th>E-mail</th>';
echo '</tr>';

// Verileri yaz
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['ad_soyad']) . '</td>';
        echo '<td>' . htmlspecialchars($row['okul']) . '</td>';
        echo '<td>' . htmlspecialchars($row['bolum']) . '</td>';
        echo '<td>' . htmlspecialchars($row['sinif']) . '</td>';
        echo '<td>' . htmlspecialchars($row['cep_tel']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7">Katılımcı bulunamadı.</td></tr>';
}

echo '</table>';
exit;
?>
