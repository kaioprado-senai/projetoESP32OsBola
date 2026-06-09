<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { background: #0a0a0a; }
  #dash {
    width: 100%; min-height: 520px;
    background: #0d0d0f;
    display: flex; flex-direction: column; align-items: center;
    position: relative; overflow: hidden;
    border-radius: 12px;
    font-family: 'Courier New', monospace;
  }

  /* Street animation */
  #street-wrap {
    width: 100%; height: 200px;
    position: relative; overflow: hidden;
    background: #1a1a2e;
    flex-shrink: 0;
  }
  .sky {
    position: absolute; top: 0; left: 0; width: 100%; height: 60%;
    background: linear-gradient(180deg, #0a0a1a 0%, #1a1520 100%);
  }
  /* Road */
  .road {
    position: absolute; bottom: 0; left: 0; width: 100%; height: 55%;
    background: #1c1c1c;
  }
  .road-line {
    position: absolute; top: 30%; height: 8px; width: 80px;
    background: #f5c518; border-radius: 2px;
    animation: roadMove linear infinite;
  }
  .road-edge-left {
    position: absolute; top: 0; left: 0; width: 6px; height: 100%;
    background: #e8e8e8;
  }
  .road-edge-right {
    position: absolute; top: 0; right: 0; width: 6px; height: 100%;
    background: #e8e8e8;
  }
  /* Buildings silhouette */
  .buildings {
    position: absolute; bottom: 55%; left: 0; width: 100%;
    display: flex; align-items: flex-end; gap: 2px;
    animation: buildingMove linear infinite;
  }
  .bld {
    background: #0e0e1a;
    flex-shrink: 0;
  }
  /* Lamp posts */
  .lamp {
    position: absolute; bottom: 55%;
    width: 4px; background: #555;
    animation: lampMove linear infinite;
  }
  .lamp::after {
    content: '';
    position: absolute; top: -6px; right: -8px;
    width: 12px; height: 4px;
    background: #ffd700; border-radius: 2px;
    box-shadow: 0 0 6px #ffd700aa;
  }

  @keyframes roadMove {
    from { transform: translateX(0); }
    to   { transform: translateX(200px); }
  }
  @keyframes buildingMove {
    from { transform: translateX(0); }
    to   { transform: translateX(-300px); }
  }
  @keyframes lampMove {
    from { transform: translateX(0); }
    to   { transform: translateX(800px); }
  }

  /* Horizon fade */
  .horizon-fade {
    position: absolute; bottom: 54%; left: 0; width: 100%; height: 30px;
    background: linear-gradient(180deg, transparent 0%, #1c1c1c 100%);
  }

  /* Gauges area */
  #gauges {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;
    padding: 12px 20px 16px;
    flex-wrap: wrap;
  }

  /* Gauge circle */
  .gauge-wrap {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
  }
  .gauge-svg {
    filter: drop-shadow(0 0 8px rgba(255,80,0,0.3));
  }
  .gauge-label {
    font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
    color: #888;
  }
  .gauge-value {
    font-size: 22px; font-weight: bold; color: #ff6a00;
    text-shadow: 0 0 10px #ff6a0088;
    min-width: 80px; text-align: center;
  }
  .gauge-unit {
    font-size: 11px; color: #666; margin-top: -4px;
  }

  /* Center speedometer */
  .gauge-center .gauge-svg {
    filter: drop-shadow(0 0 12px rgba(255,80,0,0.5));
  }
  .gauge-center .gauge-value {
    font-size: 34px;
  }

  /* Bottom bar */
  #bottom-bar {
    width: 100%;
    display: flex; justify-content: space-around; align-items: center;
    padding: 8px 16px 12px;
    border-top: 1px solid #222;
  }
  .info-pill {
    display: flex; flex-direction: column; align-items: center; gap: 2px;
  }
  .info-pill-label { font-size: 10px; color: #555; letter-spacing: 2px; text-transform: uppercase; }
  .info-pill-val { font-size: 15px; color: #cc4400; font-weight: bold; }

  /* Speed input */
  #demo-area {
    width: 100%; padding: 8px 20px 10px;
    display: flex; align-items: center; gap: 12px;
  }
  #demo-area label { font-size: 11px; color: #555; letter-spacing: 1px; white-space: nowrap; }
  #speedSlider { flex: 1; accent-color: #ff6a00; }
  #speedLabel { font-size: 12px; color: #888; min-width: 50px; }
</style>
<body>
  

<div id="dash">
  <h2 class="sr-only">Painel de velocidade estilo moto com velocímetro, RPM e efeito de rua em movimento</h2>

  <div id="street-wrap">
    <div class="sky"></div>
    <div class="road">
      <div class="road-edge-left"></div>
      <div class="road-edge-right"></div>
    </div>
    <div class="horizon-fade"></div>
    <div class="buildings" id="buildings"></div>
    <div id="lamps"></div>
  </div>

  <div id="gauges">
    <!-- RPM gauge -->
    <div class="gauge-wrap">
      <span class="gauge-label">RPM</span>
      <svg class="gauge-svg" width="140" height="140" viewBox="0 0 140 140">
        <circle cx="70" cy="70" r="58" fill="#111" stroke="#222" stroke-width="2"/>
        <circle cx="70" cy="70" r="50" fill="none" stroke="#1a1a1a" stroke-width="10" stroke-dasharray="251 314" stroke-dashoffset="-31" stroke-linecap="round"/>
        <circle id="rpm-arc" cx="70" cy="70" r="50" fill="none" stroke="#ff6a00" stroke-width="10"
          stroke-dasharray="0 314" stroke-dashoffset="-31" stroke-linecap="round"
          style="transition: stroke-dasharray 0.3s ease; transform-origin:70px 70px; transform:rotate(-90deg) scaleX(-1)"/>
        <text id="rpm-ticks" x="0" y="0"></text>
        <!-- needle -->
        <line id="rpm-needle" x1="70" y1="70" x2="70" y2="28" stroke="#ff4400" stroke-width="2" stroke-linecap="round"
          style="transform-origin:70px 70px; transform:rotate(-130deg); transition:transform 0.3s ease;"/>
        <circle cx="70" cy="70" r="6" fill="#ff6a00"/>
        <circle cx="70" cy="70" r="3" fill="#222"/>
      </svg>
      <div class="gauge-value" id="rpm-val">0</div>
      <div class="gauge-unit">x1000 rpm</div>
    </div>

    <!-- Speedometer (center, bigger) -->
    <div class="gauge-wrap gauge-center">
      <span class="gauge-label">Velocidade</span>
      <svg class="gauge-svg" width="180" height="180" viewBox="0 0 180 180">
        <circle cx="90" cy="90" r="78" fill="#0e0e0e" stroke="#1e1e1e" stroke-width="2.5"/>
        <circle cx="90" cy="90" r="66" fill="none" stroke="#1a1a1a" stroke-width="13"
          stroke-dasharray="330 414" stroke-dashoffset="-40" stroke-linecap="round"/>
        <circle id="kph-arc" cx="90" cy="90" r="66" fill="none" stroke="#ff6a00" stroke-width="13"
          stroke-dasharray="0 414" stroke-dashoffset="-40" stroke-linecap="round"
          style="transition: stroke-dasharray 0.3s ease; transform-origin:90px 90px; transform:rotate(-90deg) scaleX(-1)"/>
        <!-- tick marks -->
        <g id="kph-ticks"></g>
        <!-- needle -->
        <line id="kph-needle" x1="90" y1="90" x2="90" y2="34" stroke="#ff4400" stroke-width="2.5" stroke-linecap="round"
          style="transform-origin:90px 90px; transform:rotate(-130deg); transition:transform 0.3s ease;"/>
        <circle cx="90" cy="90" r="9" fill="#ff6a00"/>
        <circle cx="90" cy="90" r="4" fill="#1a1a1a"/>
      </svg>
      <div class="gauge-value" id="kph-val">0</div>
      <div class="gauge-unit">km/h</div>
    </div>

    <!-- Gear / temp indicators -->
    <div class="gauge-wrap">
      <span class="gauge-label">Marcha</span>
      <svg class="gauge-svg" width="140" height="140" viewBox="0 0 140 140">
        <circle cx="70" cy="70" r="58" fill="#111" stroke="#222" stroke-width="2"/>
        <text id="gear-text" x="70" y="80" text-anchor="middle" font-size="52" font-weight="bold"
          fill="#ff6a00" font-family="'Courier New', monospace" style="text-shadow: 0 0 12px #ff6a00;">N</text>
      </svg>
      <div class="gauge-value" id="temp-val" style="font-size:16px;">80°C</div>
      <div class="gauge-unit">temperatura</div>
    </div>
  </div>

  <div id="bottom-bar">
    <div class="info-pill">
      <span class="info-pill-label">Odômetro</span>
      <span class="info-pill-val" id="odo-val">00000 km</span>
    </div>
    <div class="info-pill">
      <span class="info-pill-label">Tempo</span>
      <span class="info-pill-val" id="time-val">00:00</span>
    </div>
    <div class="info-pill">
      <span class="info-pill-label">Combustível</span>
      <span class="info-pill-val" id="fuel-val">████░</span>
    </div>
  </div>

  <div id="demo-area">
    <label>KM/H:</label>
    <input type="range" id="speedSlider" min="0" max="220" value="0" step="1">
    <span id="speedLabel">0 km/h</span>
  </div>
</div>
</body>

<script>
const slider = document.getElementById('speedSlider');
const speedLabel = document.getElementById('speedLabel');
const kphVal = document.getElementById('kph-val');
const rpmVal = document.getElementById('rpm-val');
const kphArc = document.getElementById('kph-arc');
const rpmArc = document.getElementById('rpm-arc');
const kphNeedle = document.getElementById('kph-needle');
const rpmNeedle = document.getElementById('rpm-needle');
const gearText = document.getElementById('gear-text');
const tempVal = document.getElementById('temp-val');
const fuelVal = document.getElementById('fuel-val');
const odoVal = document.getElementById('odo-val');
const timeVal = document.getElementById('time-val');

let odo = 0;
let startTime = Date.now();

// Build road lines
const streetWrap = document.getElementById('street-wrap');
for (let i = 0; i < 8; i++) {
  const line = document.createElement('div');
  line.className = 'road-line';
  const leftPercent = (i * 14) - 10;
  line.style.left = leftPercent + '%';
  line.style.bottom = '14px';
  streetWrap.querySelector('.road').appendChild(line);
}

// Build buildings
const buildingsEl = document.getElementById('buildings');
const bldData = [
  {w:30,h:60},{w:50,h:90},{w:20,h:45},{w:40,h:110},{w:35,h:75},
  {w:25,h:55},{w:60,h:130},{w:30,h:60},{w:45,h:85},{w:20,h:40},
  {w:55,h:100},{w:35,h:70},{w:25,h:50},{w:40,h:95},{w:60,h:120},
];
bldData.concat(bldData).forEach(b => {
  const d = document.createElement('div');
  d.className = 'bld';
  d.style.width = b.w + 'px';
  d.style.height = b.h + 'px';
  buildingsEl.appendChild(d);
});

// Build lamp posts
const lampsEl = document.getElementById('lamps');
for (let i = 0; i < 5; i++) {
  const lp = document.createElement('div');
  lp.className = 'lamp';
  lp.style.height = '52px';
  lp.style.left = (i * 200 - 100) + 'px';
  lp.style.animationDelay = (i * -0.5) + 's';
  lampsEl.appendChild(lp);
}

function updateSpeed(kph) {
  kph = Math.min(220, Math.max(0, kph));
  speedLabel.textContent = kph + ' km/h';
  kphVal.textContent = kph;

  // KPH arc: max 220 → 330px
  const kphPct = kph / 220;
  const kphArcLen = kphPct * 330;
  kphArc.setAttribute('stroke-dasharray', kphArcLen + ' 414');

  // KPH needle: -130deg to +130deg
  const kphDeg = -130 + kphPct * 260;
  kphNeedle.style.transform = `rotate(${kphDeg}deg)`;

  // RPM: simulate based on speed + gear
  const gear = kph < 20 ? 1 : kph < 50 ? 2 : kph < 90 ? 3 : kph < 130 ? 4 : kph < 170 ? 5 : 6;
  const gearLabels = ['N','1','2','3','4','5','6'];
  const baseRpm = [0, 0.3, 0.25, 0.25, 0.25, 0.28, 0.30];
  const gearIdx = kph === 0 ? 0 : gear;
  gearText.textContent = kph === 0 ? 'N' : gear;

  let rpmRaw = kph === 0 ? 0 : (kphPct / (gear * 0.18)) * 0.85;
  rpmRaw = Math.min(1, rpmRaw);
  const rpm = Math.round(rpmRaw * 12000);
  rpmVal.textContent = (rpm / 1000).toFixed(1);

  const rpmArcLen = rpmRaw * 251;
  rpmArc.setAttribute('stroke-dasharray', rpmArcLen + ' 314');
  const rpmDeg = -130 + rpmRaw * 260;
  rpmNeedle.style.transform = `rotate(${rpmDeg}deg)`;

  // Arc color based on RPM
  const arcColor = rpmRaw > 0.8 ? '#ff2200' : rpmRaw > 0.6 ? '#ff6a00' : '#ff9500';
  rpmArc.setAttribute('stroke', arcColor);
  kphArc.setAttribute('stroke', kph > 180 ? '#ff2200' : kph > 120 ? '#ff6a00' : '#ff9500');

  // Temperature
  const temp = 80 + Math.round(kph * 0.15);
  tempVal.textContent = temp + '°C';

  // Fuel decreases over time (demo)
  const fuelBars = Math.max(0, 5 - Math.floor(kph / 55));
  fuelVal.textContent = '█'.repeat(fuelBars) + '░'.repeat(5 - fuelBars);

  // Street animation speed
  const speed = kph === 0 ? 0 : Math.max(0.3, 10 - kph / 25);
  document.querySelectorAll('.road-line').forEach(l => {
    if (kph === 0) { l.style.animationDuration = '0s'; l.style.animationPlayState = 'paused'; }
    else { l.style.animationDuration = speed + 's'; l.style.animationPlayState = 'running'; }
  });
  const bldSpeed = kph === 0 ? 0 : Math.max(1, 30 - kph / 10);
  buildingsEl.style.animationDuration = bldSpeed + 's';
  buildingsEl.style.animationPlayState = kph === 0 ? 'paused' : 'running';

  const lampSpeed = kph === 0 ? 0 : Math.max(0.5, 15 - kph / 20);
  document.querySelectorAll('.lamp').forEach(l => {
    if (kph === 0) { l.style.animationPlayState = 'paused'; }
    else { l.style.animationDuration = lampSpeed + 's'; l.style.animationPlayState = 'running'; }
  });
}

// Odometer and clock
setInterval(() => {
  const kph = parseInt(slider.value);
  odo += kph / 3600 / 4;
  odoVal.textContent = Math.floor(odo).toString().padStart(5, '0') + ' km';
  const elapsed = Math.floor((Date.now() - startTime) / 1000);
  const m = Math.floor(elapsed / 60).toString().padStart(2, '0');
  const s = (elapsed % 60).toString().padStart(2, '0');
  timeVal.textContent = m + ':' + s;
}, 250);

// Auto fetch from PHP
async function fetchData() {
  try {
    const r = await fetch('buscar_ultimo.php');
    if (!r.ok) throw new Error();
    const d = await r.json();
    if (d.kph !== undefined) {
      slider.value = Math.round(d.kph);
      updateSpeed(Math.round(d.kph));
    }
  } catch(e) {
    updateSpeed(parseInt(slider.value));
  }
}

slider.addEventListener('input', () => updateSpeed(parseInt(slider.value)));
updateSpeed(0);
setInterval(fetchData, 250);
</script>
</html>