//fungsi unutk waktu server
function updateServerTime() {
    var serverTimeElement = document.getElementById('server-time');
    var currentDate = new Date();
    var hours = currentDate.getHours().toString().padStart(2, '0');
    var minutes = currentDate.getMinutes().toString().padStart(2, '0');
    var seconds = currentDate.getSeconds().toString().padStart(2, '0');

    // Format waktu tanpa kata "pukul"
    var formattedTime = hours + ':' + minutes + ':' + seconds;

    var formattedDate = currentDate.toLocaleString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
    var finalFormattedDate = formattedDate + ' ' + formattedTime;

    serverTimeElement.textContent = finalFormattedDate;
}

// Panggil fungsi untuk memperbarui waktu server setiap detik
setInterval(updateServerTime, 1000);