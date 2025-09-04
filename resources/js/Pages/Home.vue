<template>
  <div class="map-container">
    <!-- Header con gradiente -->
    <div class="header">
      <div class="header-content">
        <h1 class="title">
          <span class="icon">🗺️</span>
          Mapa de Visitas
        </h1>
        <button @click="logout" class="logout-btn">
          <span class="logout-icon">🚪</span>
          Cerrar sesión
        </button>
      </div>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
      <!-- Estadísticas -->
      <div class="stats-card">
        <div class="stat-item">
          <div class="stat-number">{{ visitas?.length || 0 }}</div>
          <div class="stat-label">Visitas Totales</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
          <div class="stat-number">{{ activeMarkers }}</div>
          <div class="stat-label">Ubicaciones</div>
        </div>
      </div>

      <!-- Mapa mejorado -->
      <div class="map-wrapper">
        <div class="map-header">
          <h3 class="map-title">Ubicaciones de Visitantes</h3>
          <div class="map-controls">
            <button class="control-btn" @click="centerMap">
              📍 Centrar
            </button>
          </div>
        </div>
        <div id="map" class="map"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

function setupLeafletIcons() {
  delete L.Icon.Default.prototype._getIconUrl
  L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
  })
}
setupLeafletIcons()

const props = defineProps({
  datos: {
    type: Object, 
    default: () => ({ data: [] })
  }
})

let map = null
let markers = null

const visitas = computed(() => props.datos.data.filter(d => d.latitude && d.longitude))
const activeMarkers = computed(() => visitas.value.length)

onMounted(() => {  
  const token = localStorage.getItem("auth_token");
  if (!token) {    
    window.location.href = "/login";
    return;
  }

  map = L.map('map').setView([40.416775, -3.70379], 5)

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map)

  markers = L.featureGroup()

  visitas.value.forEach(d => {
    L.marker([+d.latitude, +d.longitude])
      .bindPopup(`
        <div class="custom-popup">
          <div class="popup-header">
            <strong>${d.name}</strong>
          </div>
          <div class="popup-content">
            📧 ${d.email}
          </div>
        </div>
      `)
      .addTo(markers)
  })

  if (visitas.value.length) {
    markers.addTo(map)
    map.fitBounds(markers.getBounds(), { padding: [50, 50] })
  }
})

function centerMap() {
  if (map && markers && visitas.value.length) {
    map.fitBounds(markers.getBounds(), { padding: [50, 50] })
  }
}

async function logout() {
  const token = localStorage.getItem("auth_token");

  if (!token) {
    alert("No hay sesión activa");
    return;
  }

  const response = await fetch("/api/auth/logout", {
    method: "POST",
    headers: {
      "Accept": "application/json",
      "Authorization": "Bearer " + localStorage.getItem("auth_token")
    }
  })

  const data = await response.json();

  if (response.ok) {
    localStorage.removeItem("auth_token");
    window.location.href = "/login";
  } else {
    alert("Error al cerrar sesión: " + JSON.stringify(data));
  }
}
</script>

<style scoped>
/* Contenedor principal */
.map-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* Header */
.header {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  padding: 1rem 2rem;
  position: sticky;
  top: 0;
  z-index: 1000;
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

.title {
  font-size: 2rem;
  font-weight: 800;
  color: #2d3748;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.icon {
  font-size: 2.5rem;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

/* Botón de logout */
.logout-btn {
  background: linear-gradient(45deg, #ff6b6b, #ee5a24);
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 50px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.logout-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
  background: linear-gradient(45deg, #ff5252, #d63031);
}

.logout-icon {
  font-size: 1.2rem;
}

/* Contenido principal */
.main-content {
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

/* Tarjeta de estadísticas */
.stats-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(15px);
  border-radius: 20px;
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.stat-item {
  text-align: center;
}

.stat-number {
  font-size: 3rem;
  font-weight: 800;
  background: linear-gradient(45deg, #667eea, #764ba2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 0.5rem;
}

.stat-label {
  font-size: 1rem;
  color: #64748b;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-divider {
  width: 2px;
  height: 60px;
  background: linear-gradient(to bottom, transparent, #e2e8f0, transparent);
}

/* Wrapper del mapa */
.map-wrapper {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(15px);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.map-header {
  background: linear-gradient(135deg, #4f46e5, #7c3aed);
  color: white;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.map-title {
  font-size: 1.5rem;
  font-weight: 700;
  margin: 0;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.map-controls {
  display: flex;
  gap: 1rem;
}

.control-btn {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
  padding: 8px 16px;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
  backdrop-filter: blur(10px);
}

.control-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-1px);
}

/* Mapa */
.map {
  height: 600px;
  width: 100%;
  border-radius: 0 0 20px 20px;
  position: relative;
}

/* Estilos para el popup del mapa */
:global(.leaflet-popup-content-wrapper) {
  background: white;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  border: none;
}

:global(.leaflet-popup-tip) {
  background: white;
}

:global(.custom-popup) {
  min-width: 200px;
}

:global(.popup-header) {
  font-size: 1.1rem;
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 8px;
  padding-bottom: 8px;
  border-bottom: 2px solid #e2e8f0;
}

:global(.popup-content) {
  color: #64748b;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Responsivo */
@media (max-width: 768px) {
  .header {
    padding: 1rem;
  }
  
  .header-content {
    flex-direction: column;
    gap: 1rem;
  }
  
  .title {
    font-size: 1.5rem;
  }
  
  .main-content {
    padding: 1rem;
  }
  
  .stats-card {
    flex-direction: column;
    gap: 1rem;
  }
  
  .stat-divider {
    width: 60px;
    height: 2px;
  }
  
  .map-header {
    flex-direction: column;
    gap: 1rem;
    text-align: center;
  }
  
  .map {
    height: 400px;
  }
}

/* Animaciones */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.stats-card, .map-wrapper {
  animation: fadeInUp 0.6s ease forwards;
}

.map-wrapper {
  animation-delay: 0.2s;
}
</style>