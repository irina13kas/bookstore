document.addEventListener('DOMContentLoaded', function () {
  const map = L.map('map').setView([51.5074, -0.1278], 5);
  
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);


  fetch('../includes/fetch_map_data.php')
.then(res => res.json())
.then(data => {
  console.log(data);

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



// document.addEventListener('DOMContentLoaded', function () {
  
//     // Инициализация карты в винтажном стиле
//     const map = L.map('map').setView([51.8, 0.6], 5);

//     const gl = L.maplibreGL({
//       style: 'https://www.openhistoricalmap.org/map-styles/main/main.json',
//       attribution: '<a href="https://www.openhistoricalmap.org/">OpenHistoricalMap</a>'
//     }).addTo(map);

//     const maplibreMap = gl.getMaplibreMap();

//     maplibreMap.once('styledata', function () {
//       maplibreMap.filterByDate('1920-04-14');
//     });

//     f
//   });
  