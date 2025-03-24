<template>
  <div id="map" class="map-container"></div>
</template>

<script setup>
import { onMounted } from 'vue';
import L from 'leaflet';
import axios from 'axios';
import { convertWebMercatorToLatLng } from "@/Utility/Formatter.js";
// Custom Icon for Landmarks
const landmarkIcon = L.icon({
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png', // Ensure this URL is accessible
  iconSize: [25, 41], 
  iconAnchor: [12, 41], 
  popupAnchor: [1, -34], 
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  shadowSize: [41, 41]
});


onMounted(async () => {

  const brgySanAgustin = {
    "type": "Feature",
    "properties": {
      "name": "San Agustin, Quezon City"
    },
    "geometry": {
      "type": "MultiPolygon",
      "coordinates": [
        [
          [
            [121.06915, 14.68450], [121.06917, 14.68431], [121.06984, 14.68426],
            [121.07007, 14.68462], [121.07165, 14.68372], [121.07176, 14.68371],
            [121.07242, 14.68372], [121.07256, 14.68366], [121.07268, 14.68357],
            [121.07277, 14.68328], [121.07279, 14.68265], [121.07274, 14.68247],
            [121.07272, 14.68226], [121.07280, 14.68215], [121.07298, 14.68227],
            [121.07306, 14.68233], [121.07339, 14.68258], [121.07362, 14.68298],
            [121.07398, 14.68296], [121.07419, 14.68290], [121.07436, 14.68276],
            [121.07446, 14.68251], [121.07450, 14.68242], [121.07512, 14.68243],
            [121.07503, 14.68387], [121.07507, 14.68392], [121.07530, 14.68430],
            [121.07545, 14.68449], [121.07564, 14.68482], [121.07673, 14.68492],
            [121.07690, 14.68461], [121.07700, 14.68446], [121.07728, 14.68453],
            [121.07750, 14.68459], [121.07776, 14.68494], [121.07822, 14.68501],
            [121.07855, 14.68512], [121.07868, 14.68504], [121.07915, 14.68529],
            [121.07947, 14.68566], [121.07932, 14.68581], [121.07896, 14.68578],
            [121.07897, 14.68598], [121.07896, 14.68641], [121.07891, 14.68655],
            [121.07884, 14.68668], [121.07859, 14.68757], [121.07835, 14.68752],
            [121.07816, 14.68750], [121.07835, 14.68815], [121.07843, 14.68827],
            [121.07862, 14.68830], [121.07865, 14.68852], [121.07856, 14.68908],
            [121.07852, 14.68913], [121.07798, 14.68983], [121.07785, 14.68999],
            [121.07670, 14.69054], [121.07784, 14.69112], [121.07874, 14.69212],
            [121.07845, 14.69262], [121.07836, 14.69340], [121.07751, 14.69376],
            [121.07726, 14.69400], [121.07701, 14.69403], [121.07705, 14.69421],
            [121.07712, 14.69426], [121.07741, 14.69460], [121.07778, 14.69461],
            [121.07755, 14.69487], [121.07807, 14.69499], [121.07802, 14.69608],
            [121.07902, 14.69607], [121.07903, 14.69830], [121.07902, 14.70053],
            [121.07880, 14.70054], [121.07845, 14.70082], [121.07801, 14.70121],
            [121.07551, 14.69861], [121.07061, 14.69063], [121.07075, 14.69027],
            [121.07045, 14.68968], [121.07030, 14.68947], [121.07126, 14.68945],
            [121.07196, 14.68918], [121.07184, 14.68870], [121.07131, 14.68841],
            [121.07155, 14.68823], [121.07188, 14.68798], [121.07201, 14.68753],
            [121.07188, 14.68710], [121.07180, 14.68672], [121.07169, 14.68578],
            [121.07134, 14.68538], [121.07049, 14.68486], [121.07066, 14.68457],
            [121.07069, 14.68366], [121.06915, 14.68450]
          ]
        ]
      ]
    }
  };

  // Initialize the map (Ensure map is properly initialized)
  const map = L.map('map').setView([121.07357, 14.68908], 16); // Center map on an initial point

  // Add tile layer (required for map background)
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Extract the correct polygon coordinates (first set in MultiPolygon)
  const brgyCoordinates = brgySanAgustin.geometry.coordinates[0][0].map(coord => [coord[1], coord[0]]);

  // Create polygon
  const brgyArea = L.polygon(brgyCoordinates, {
      color: "red",
      fillColor: "#ff4d4d",
      fillOpacity: 0.5
  }).bindPopup("<strong>San Agustin, 5th District, Quezon City, Eastern Manila District, Metro Manila, 1117, Philippines</strong>").addTo(map);

  // Adjust map to fit bounds of polygon
  map.fitBounds(brgyArea.getBounds());

  // Fetch landmarks from API
  try {
    const response = await axios.get(route('landmarks.list.all'));
    const landmarks = response.data.landmarks;
    // console.log("Fetched landmarks:", landmarks);

    landmarks.forEach(landmark => {
      if (landmark.latitude && landmark.longitude) {
        const mercatorPoints = convertWebMercatorToLatLng(landmark.latitude, landmark.longitude);

        // console.log(mercatorPoints);
        L.marker(mercatorPoints, { icon: landmarkIcon }) // Use custom icon
        //L.marker(mercatorPoints) // Use defualt icon
          .addTo(map)
          .bindPopup(`<strong>${landmark.name}</strong><br>${landmark.building_type ?? 'Not available'}<br><br>${landmark.description ?? 'No description'}`);
      }
    });

  } catch (error) {
    console.error("Error fetching landmarks:", error);
  }

  window.addEventListener('resize', () => {
    setTimeout(() => {
      map.invalidateSize();
    }, 400);
  });

});
</script>

<style scoped>
#map {
  height: 100vh;
  width: 100%;
}
</style>
