// Geri sayım fonksiyonu
const countdown = () => {
    const countDate = new Date("Nov 27, 2024 00:00:00").getTime();
    const now = new Date().getTime();
    const gap = countDate - now;

    // Zaman hesaplamaları
    const second = 1000;
    const minute = second * 60;
    const hour = minute * 60;
    const day = hour * 24;

    // Kalan gün, saat, dakika ve saniyeler
    const textDay = Math.floor(gap / day);
    const textHour = Math.floor((gap % day) / hour);
    const textMinute = Math.floor((gap % hour) / minute);
    const textSecond = Math.floor((gap % minute) / second);

    // Değerleri güncelleme
    document.getElementById('days').innerText = textDay;
    document.getElementById('hours').innerText = textHour;
    document.getElementById('minutes').innerText = textMinute;
    document.getElementById('seconds').innerText = textSecond;
};

// Her saniye güncelle
setInterval(countdown, 1000);

// Katılım formu açma ve kapama işlemleri
const modal = document.getElementById("formModal");
const openBtns = document.querySelectorAll(".katilim-btn"); // Tüm katılım butonlarını seçiyoruz
const closeBtns = document.querySelectorAll(".close-btn"); // Tüm kapatma butonlarını seçiyoruz

// Katılım butonuna tıklayınca formu aç
openBtns.forEach(openBtn => {
    openBtn.addEventListener("click", function(e) {
        e.preventDefault(); // Sayfanın yeniden yüklenmesini engeller
        modal.style.display = "flex"; // Modalı göster
    });
});

// Kapat butonuna tıklayınca formu kapat
closeBtns.forEach(closeBtn => {
    closeBtn.addEventListener("click", function() {
        modal.style.display = "none"; // Modalı gizle
    });
});

// Modal dışında bir yere tıklayınca formu kapat
window.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});


// Konuşmacı slider'ını seçiyoruz
const slider = document.getElementById('content-section');

// Orijinal slide'ları alıyoruz
const slides = slider.innerHTML;

// 100 kez tekrar ettireceğiz
for (let i = 0; i < 100; i++) {
    slider.innerHTML += slides; // Her döngüde orijinal slide'ları ekliyoruz
}
