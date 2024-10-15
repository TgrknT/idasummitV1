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
