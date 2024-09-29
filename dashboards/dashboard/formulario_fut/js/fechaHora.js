function updateDateTime() {
    const now = new Date();
    
    // Formato de fecha (dd-mm-yyyy)
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    const currentDate = `${day}/${month}/${year}`;
    document.getElementById('current-date').textContent = currentDate;
    
    // Formato de hora (hh-mm-ss)
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const currentTime = `${hours}:${minutes}:${seconds}`;
    document.getElementById('current-time').textContent = currentTime;
}

setInterval(updateDateTime, 1000);

updateDateTime();