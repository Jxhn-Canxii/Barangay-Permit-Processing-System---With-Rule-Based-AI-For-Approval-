<template>
  <div id="map" class="map-container"></div>
</template>

<script setup>
import { onMounted } from 'vue';
import L from 'leaflet';

onMounted(() => {
  // Initialize the map
  const map = L.map('map');

  // Base Map Layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Barangay Border Coordinates
  const brgyBorder = [
    [14.7259071, 121.0305371], [14.7257488, 121.0305529], [14.7257024, 121.0311666], 
    [14.7260136, 121.0313704], [14.7251615, 121.03278], [14.7251584, 121.0328827], 
    [14.7251677, 121.0334697], [14.7251149, 121.0335915], [14.7250318, 121.0336986], 
    [14.7247737, 121.0337791], [14.7242198, 121.0337986], [14.7240648, 121.0337475], 
    [14.7238841, 121.0337262], [14.7237829, 121.0337991], [14.7238923, 121.0339548], 
    [14.7239494, 121.0340238], [14.7241666, 121.0343209], [14.7245091, 121.0345247], 
    [14.7244987, 121.0348466], [14.7244468, 121.0350397], [14.7243223, 121.0351899], 
    [14.7241053, 121.0352766], [14.7240297, 121.0353129], [14.7240308, 121.0358589], 
    [14.7252793, 121.0357821], [14.7253211, 121.0358157], [14.7256467, 121.0360202], 
    [14.7258101, 121.0361597], [14.7260979, 121.0363294], [14.7261798, 121.0373104], 
    [14.7259099, 121.0374644], [14.7257789, 121.0375542], [14.725845, 121.0378052], 
    [14.7258975, 121.0380048], [14.7262017, 121.0382155], [14.7262665, 121.0386285], 
    [14.7263639, 121.0389222], [14.7262977, 121.0390348], [14.7265209, 121.0394521], 
    [14.7268438, 121.0397334], [14.7269708, 121.039594], [14.7269442, 121.0392642], 
    [14.7271199, 121.0392783], [14.7259071, 121.0305371] // Closing the polygon
  ];

  // Create the polygon
  const brgyArea = L.polygon(brgyBorder, {
    color: "red",
    fillColor: "#ff4d4d",
    fillOpacity: 0.5
  }).bindPopup("<strong>San Agustin, 5th District, Quezon City, Eastern Manila District, Metro Manila, 1117, Philippines</strong>").addTo(map);

  // Auto-fit map to the polygon bounds
  map.fitBounds(brgyArea.getBounds());

  // Resize map when window resizes
  window.addEventListener('resize', () => {
    setTimeout(() => {
      map.invalidateSize();
    }, 400);
  });

});
</script>

<style scoped>
#map {
  height: 100vh; /* Full viewport height */
  width: 100%;
}

.map-container {
  width: 100%;
  height: 100%;
}
</style>
