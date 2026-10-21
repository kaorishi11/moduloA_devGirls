<div class="page-head"><h1>Mapa de rastreamento</h1></div>
<div class="card map-wrap">
  <?php if ($googleKey): ?>
    <div id="map" style="height:520px;border-radius:12px"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= htmlspecialchars($googleKey) ?>&callback=initMap" async defer></script>
    <script>
    function initMap(){
      const map = new google.maps.Map(document.getElementById('map'), {zoom:12, center:{lat:-23.5505,lng:-46.6333}});
      fetch('<?= APP_URL ?>/map/api').then(r=>r.json()).then(data=>{
        data.deliveries.forEach(d=>{
          new google.maps.Marker({position:{lat:+d.lat,lng:+d.lng}, map, title:d.code+' — '+d.recipient});
        });
      });
    }
    </script>
  <?php else: ?>
    <div class="map-placeholder">
      <i data-lucide="map"></i>
      <h3>Google Maps não configurado</h3>
      <p>Defina <code>GOOGLE_MAPS_API_KEY</code> no <code>.env</code> para exibir o mapa real.</p>
      <p class="muted">Exibindo demonstração estática com <?= 0 ?> veículos monitorados.</p>
    </div>
  <?php endif; ?>
</div>