// Gráficos do dashboard
document.addEventListener('DOMContentLoaded', () => {
  const d = window.__DATA__;
  if (d && document.getElementById('chartDay')) {
    const labels = d.byDay.map(x => x.d);
    const values = d.byDay.map(x => +x.c);
    new Chart(document.getElementById('chartDay'), {
      type: 'line',
      data: { labels, datasets: [{ label: 'Entregas', data: values, borderColor: '#6C3BCE', backgroundColor: 'rgba(108,59,206,.12)', fill: true, tension: .35 }] },
      options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
  }
  if (d && document.getElementById('chartStatus')) {
    const labels = d.byStatus.map(x => x.status.replace('_',' '));
    const values = d.byStatus.map(x => +x.c);
    new Chart(document.getElementById('chartStatus'), {
      type: 'doughnut',
      data: { labels, datasets: [{ data: values, backgroundColor: ['#A78BFA','#F59E0B','#16A34A','#DC2626','#94A3B8'] }] },
      options: { plugins: { legend: { position: 'bottom' } } }
    });
  }

  // Relatórios
  const r = window.__REPORT__;
  if (r && document.getElementById('rStatus')) {
    new Chart(document.getElementById('rStatus'), {
      type: 'bar',
      data: { labels: r.status.map(x=>x.status.replace('_',' ')), datasets: [{ data: r.status.map(x=>+x.c), backgroundColor: '#6C3BCE', borderRadius: 8 }] },
      options: { plugins: { legend: { display: false } } }
    });
  }
  if (r && document.getElementById('rRegion')) {
    new Chart(document.getElementById('rRegion'), {
      type: 'bar',
      data: { labels: r.region.map(x=>x.region), datasets: [{ data: r.region.map(x=>+x.c), backgroundColor: '#A78BFA', borderRadius: 8 }] },
      options: { indexAxis: 'y', plugins: { legend: { display: false } } }
    });
  }

  // Chat IA
  const form = document.getElementById('chatForm');
  if (form) {
    const box = document.getElementById('chatBox');
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const input = document.getElementById('chatInput');
      const q = input.value.trim();
      if (!q) return;
      addMsg(q, 'user'); input.value = '';
      const loading = addMsg('Analisando dados da operação...', 'bot');
      try {
        const res = await fetch(form.action || window.location.pathname.replace(/\/ai$/, '/ai/ask'), {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams(new FormData(form)).toString() + '&question=' + encodeURIComponent(q)
        });
        const data = await res.json();
        loading.textContent = (data.simulated ? '🤖 ' : '') + (data.answer || data.error || 'Sem resposta.');
      } catch { loading.textContent = 'Falha de conexão.'; }
    });
  }
  function addMsg(text, type) {
    const el = document.createElement('div');
    el.className = 'msg ' + type;
    el.textContent = text;
    box.appendChild(el);
    box.scrollTop = box.scrollHeight;
    return el;
  }
});