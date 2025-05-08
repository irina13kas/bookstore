document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([48.5, 2.2], 5); // Пример — Франция
  
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
  
    fetch('../includes/fetch_map_data.php')
  .then(res => res.json())
  .then(data => {
    console.log(data); // Log the response to check its structure

    if (Array.isArray(data)) {
      data.forEach(point => {
        const marker = L.marker([point.lat, point.lon]).addTo(map);
        marker.bindPopup(`<b>${point.book_title}</b><br>${point.city_name}, ${point.address}`);
      });
    } else {
      console.error('Expected data to be an array, but received:', data);
    }
  })
  .catch(error => console.error('Error fetching data:', error));

  });
  