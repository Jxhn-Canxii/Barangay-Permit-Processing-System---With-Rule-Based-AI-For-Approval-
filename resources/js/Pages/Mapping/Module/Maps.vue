<template>
  <div id="map" class="map-container"></div>
</template>

<script setup>
import { onMounted } from 'vue';
import L from 'leaflet';

onMounted(() => {
  // Initialize map centered on Brgy. San Agustin, Novaliches
  const map = L.map('map').setView([14.7253, 121.0379], 16); // Adjust zoom level

  // Base Map Layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Barangay San Agustin Marker
  const barangayMarker = L.marker([14.7253, 121.0379]).bindPopup("<strong>Brgy. San Agustin, Novaliches</strong><br>Population: Approx. 50,000").addTo(map);

  // Industrial Zone Polygon (Sample Coordinates)
  const industrialArea = L.polygon([
    [14.7265, 121.0345],
    [14.7278, 121.0367],
    [14.7289, 121.0392],
    [14.7269, 121.0411],
    [14.7253, 121.0388]
  ], {
    color: "red",
    fillColor: "#ff4d4d",
    fillOpacity: 0.5
  }).bindPopup("<strong>Industrial Zone</strong>").addTo(map);

  // Residential Zone Polygon (Sample Coordinates)
  const residentialArea = L.polygon([
    [14.7235, 121.0330],
    [14.7248, 121.0352],
    [14.7259, 121.0377],
    [14.7239, 121.0396],
    [14.7223, 121.0373]
  ], {
    color: "blue",
    fillColor: "#4d79ff",
    fillOpacity: 0.5
  }).bindPopup("<strong>Residential Zone</strong>").addTo(map);

  // Add Legend
  const legend = L.control({ position: "bottomright" });

  legend.onAdd = function () {
    const div = L.DomUtil.create("div", "legend");
    div.innerHTML = `
      <h4>Land Use Legend</h4>
      <div><i style="background: #ff4d4d"></i> Industrial Area</div>
      <div><i style="background: #4d79ff"></i> Residential Area</div>
    `;
    return div;
  };
  legend.addTo(map);
});
</script>

<style scoped>
#map {
  height: 100vh; /* Make sure the map takes up the full viewport height */
}

.map-container {
  width: 100%;
  height: 100%;
}

.legend {
  padding: 10px;
  background: white;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  font-size: 14px;
  line-height: 18px;
}

.legend i {
  width: 18px;
  height: 18px;
  display: inline-block;
  margin-right: 8px;
}
</style>
