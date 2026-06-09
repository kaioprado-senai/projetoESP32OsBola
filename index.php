<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>


<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0
  }

  body {
    background: #06060e;
    font-family: 'Courier New', monospace;
    overflow: hidden
  }

  #root {
    width: 100%;
    background: #06060e;
    position: relative
  }

  #scene {
    width: 100%;
    height: 310px;
    position: relative;
    overflow: hidden
  }

  canvas#bg-canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block
  }

  canvas#road-canvas {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 44%;
    display: block
  }

  canvas#confetti-canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    display: none
  }

  #hud {
    position: absolute;
    inset: 0;
    pointer-events: none;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 10px 13px 8px
  }

  .htop {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 8px
  }

  .hbot {
    display: flex;
    justify-content: space-between;
    align-items: flex-end
  }

  .glass {
    background: rgba(4, 4, 14, .82);
    border: 1px solid rgba(255, 255, 255, .07);
    border-radius: 6px;
    backdrop-filter: blur(0px)
  }

  .team-badge {
    background: rgba(160, 0, 0, .88);
    border: 1px solid rgba(255, 60, 60, .3);
    border-radius: 5px;
    padding: 4px 11px;
    font-size: 9px;
    letter-spacing: 3px;
    color: #fff;
    font-weight: bold
  }

  .race-info-lbl {
    font-size: 8px;
    letter-spacing: 2px;
    color: #383850;
    text-transform: uppercase;
    margin-top: 3px
  }

  .pos-tower {
    overflow: hidden;
    border-radius: 5px;
    border: 1px solid rgba(255, 255, 255, .06);
    background: rgba(3, 3, 12, .88)
  }

  .pos-row {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 2px 8px;
    font-size: 9px;
    border-bottom: 1px solid rgba(255, 255, 255, .04);
    transition: background .4s
  }

  .pos-row:last-child {
    border-bottom: none
  }

  .pos-row.us {
    background: rgba(180, 0, 0, .22)
  }

  .pn {
    color: #2a2a40;
    width: 11px;
    font-size: 8px
  }

  .pfl {
    width: 9px;
    height: 6px;
    border-radius: 1px;
    flex-shrink: 0
  }

  .pab {
    color: #c8c8d8;
    font-weight: bold;
    letter-spacing: 1px;
    width: 27px;
    font-size: 8px
  }

  .pgp {
    color: #2a2a40;
    font-size: 7px;
    flex: 1;
    text-align: right
  }

  .lap-block {
    padding: 5px 10px;
    border-radius: 5px
  }

  .llbl {
    font-size: 7px;
    color: #252538;
    letter-spacing: 2px;
    text-transform: uppercase
  }

  .lval {
    font-size: 14px;
    color: #d02000;
    font-weight: bold;
    font-family: 'Courier New', monospace;
    letter-spacing: .5px;
    line-height: 1.2
  }

  .lbest {
    font-size: 10px;
    color: #8800bb;
    font-family: 'Courier New', monospace
  }

  .timer-block {
    padding: 5px 9px;
    border-radius: 5px;
    min-width: 128px
  }

  .tbl {
    font-size: 7px;
    letter-spacing: 2px;
    color: #252538;
    text-transform: uppercase;
    display: flex;
    justify-content: space-between;
    align-items: center
  }

  .tval {
    font-size: 13px;
    color: #cc1800;
    font-weight: bold;
    font-family: 'Courier New', monospace
  }

  .ttrack {
    width: 100%;
    height: 4px;
    background: #0e0e1c;
    border-radius: 2px;
    margin-top: 4px;
    overflow: hidden
  }

  .tfill {
    height: 100%;
    border-radius: 2px;
    transition: width .25s linear, background .5s
  }

  .drs {
    padding: 2px 7px;
    border-radius: 3px;
    font-size: 8px;
    font-weight: bold;
    letter-spacing: 2px;
    transition: all .3s
  }

  .don {
    background: #00cc44;
    color: #001800;
    box-shadow: 0 0 8px rgba(0, 204, 68, .4)
  }

  .doff {
    background: #0c0c18;
    color: #222;
    border: 1px solid #1a1a28
  }

  .hbot-pill {
    padding: 4px 10px;
    border-radius: 5px
  }

  .hbplbl {
    font-size: 7px;
    color: #1e1e30;
    letter-spacing: 2px;
    text-transform: uppercase
  }

  .hbpval {
    font-size: 12px;
    color: #991800;
    font-weight: bold;
    line-height: 1.3
  }

  #mute-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 50;
    background: rgba(0, 0, 0, .55);
    border: 1px solid #2a2a3a;
    border-radius: 4px;
    color: #444;
    font-size: 9px;
    padding: 3px 8px;
    cursor: pointer;
    pointer-events: auto;
    letter-spacing: 1px;
    transition: color .2s, border-color .2s
  }

  #mute-btn:hover {
    color: #aaa;
    border-color: #555
  }

  #ov-wrap {
    position: absolute;
    inset: 0;
    pointer-events: none;
    display: flex;
    align-items: center;
    justify-content: center
  }

  #ov-msg {
    opacity: 0;
    text-align: center;
    transform: translateY(-6px);
    transition: opacity .25s, transform .25s
  }

  .ovt {
    font-size: 19px;
    font-weight: bold;
    color: #ffd700;
    letter-spacing: 5px;
    font-family: 'Courier New', monospace
  }

  .ovs {
    font-size: 9px;
    color: #ff9900;
    letter-spacing: 3px;
    margin-top: 3px
  }

  #gauges {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 7px 16px 0;
    background: #06060e
  }

  .gw {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px
  }

  .glbl {
    font-size: 7px;
    letter-spacing: 3px;
    color: #18182a;
    text-transform: uppercase
  }

  .gval {
    font-size: 15px;
    font-weight: bold;
    color: #991800;
    min-width: 62px;
    text-align: center;
    line-height: 1;
    transition: color .3s
  }

  .gunit {
    font-size: 7px;
    color: #141428
  }

  .gcenter .gval {
    font-size: 24px;
    color: #bb2000
  }

  #botbar {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 5px 14px 5px;
    border-top: 1px solid #0e0e18;
    background: #050510
  }

  .ipill {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1px
  }

  .ipill label {
    font-size: 7px;
    color: #141428;
    letter-spacing: 2px;
    text-transform: uppercase
  }

  .ipill span {
    font-size: 11px;
    color: #881400;
    font-weight: bold
  }

  .tyrewrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px
  }

  .tyrerow {
    display: flex;
    gap: 5px
  }

  .tyre {
    width: 13px;
    height: 17px;
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 6px;
    font-weight: bold;
    color: #000;
    transition: background .6s
  }

  #demoarea {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 4px 14px 5px;
    background: #050510
  }

  #demoarea label {
    font-size: 8px;
    color: #141428;
    letter-spacing: 1px;
    white-space: nowrap
  }

  #speedSlider {
    flex: 1;
    accent-color: #991800
  }

  #speedlabel {
    font-size: 9px;
    color: #2a2a40;
    min-width: 48px;
    text-align: right
  }

  #victory {
    position: absolute;
    inset: 0;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 99;
    text-align: center;
    gap: 8px;
    background: rgba(2, 2, 10, .94)
  }

  .vflag {
    font-size: 44px;
    animation: fw .6s ease-in-out infinite alternate
  }

  @keyframes fw {
    0% {
      transform: rotate(-4deg) scale(1)
    }

    100% {
      transform: rotate(4deg) scale(1.06)
    }
  }

  .vtitle {
    font-size: 26px;
    font-weight: bold;
    color: #ffd700;
    letter-spacing: 6px;
    font-family: 'Courier New', monospace
  }

  .vname {
    font-size: 17px;
    color: #e8e8e8;
    letter-spacing: 4px;
    margin-top: 2px
  }

  .vsub {
    font-size: 9px;
    color: #555;
    letter-spacing: 3px
  }

  .vtime {
    font-size: 19px;
    color: #ff2200;
    font-weight: bold;
    font-family: 'Courier New', monospace;
    margin-top: 6px
  }

  .brstrip {
    display: flex;
    width: 180px;
    height: 5px;
    border-radius: 3px;
    overflow: hidden;
    margin-top: 8px
  }

  .anthem-note {
    font-size: 9px;
    color: #ffd700;
    letter-spacing: 2px;
    margin-top: 6px
  }

  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0)
  }
</style>

<body>
  

<div id="root">
  <h2 class="sr-only">Simulador F1 Monaco com corrida de 5 minutos, confetes e hino brasileiro</h2>

  <div id="scene">
    <canvas id="bg-canvas"></canvas>
    <canvas id="road-canvas"></canvas>
    <canvas id="confetti-canvas"></canvas>

    <div id="hud">
      <div class="htop">
        <div style="display:flex;flex-direction:column;gap:4px">
          <div class="team-badge">Scuderia Ferrari</div>
          <div class="race-info-lbl">Monaco GP · Volta <span id="lapnum">42</span>/78</div>
          <div style="height:2px"></div>
          <div class="pos-tower" id="postower"></div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:flex-end;gap:5px">
          <div style="display:flex;gap:5px;align-items:center">
            <div class="drs doff" id="drsbadge">DRS</div>
          </div>
          <div class="lap-block glass">
            <div class="llbl">Tempo de volta</div>
            <div class="lval" id="laptime">1:13.421</div>
            <div class="lbest" id="besttime">Melhor 1:12.884</div>
          </div>
          <div class="timer-block glass">
            <div class="tbl"><span>Corrida</span><span class="tval" id="timerval">5:00</span></div>
            <div class="ttrack">
              <div class="tfill" id="timerfill" style="width:100%;background:#cc1800"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="hbot">
        <div class="hbot-pill glass">
          <div class="hbplbl">Posição</div>
          <div class="hbpval" id="hpos" style="font-size:18px">P3</div>
        </div>
        <div class="hbot-pill glass">
          <div class="hbplbl">Gap à frente</div>
          <div class="hbpval" id="hgapf">+1.2s</div>
        </div>
        <div class="hbot-pill glass">
          <div class="hbplbl">Gap atrás</div>
          <div class="hbpval" id="hgapb">-0.8s</div>
        </div>
      </div>
    </div>

    <div id="ov-wrap">
      <div id="ov-msg">
        <div class="ovt">ULTRAPASSAGEM!</div>
        <div class="ovs" id="ovsub"></div>
      </div>
    </div>

    <div id="victory">
      <div class="vflag">&#127](</div>
      <div class="vtitle">VENCEDOR</div>
      <div class="vname">CHARLES LECLERC</div>
      <div class="vsub">GRAND PRIX DE MONACO 2025</div>
      <div class="vtime" id="vtime">00:00.000</div>
      <div class="brstrip">
        <div style="flex:3;background:#009c3b"></div>
        <div style="flex:2;background:#ffdf00"></div>
        <div style="flex:2;background:#002776"></div>
        <div style="flex:1;background:#fff"></div>
        <div style="flex:2;background:#002776"></div>
        <div style="flex:2;background:#ffdf00"></div>
        <div style="flex:3;background:#009c3b"></div>
      </div>
      <div class="anthem-note">&#9835; Hino Nacional Brasileiro &#9835;</div>
    </div>

    <button id="mute-btn">SOM ON</button>
  </div>

  <div id="gauges">
    <div class="gw">
      <span class="glbl">RPM</span>
      <svg width="108" height="108" viewBox="0 0 108 108">
        <defs>
          <filter id="glow-r">
            <feGaussianBlur stdDeviation="2.5" result="b" />
            <feMerge>
              <feMergeNode in="b" />
              <feMergeNode in="SourceGraphic" />
            </feMerge>
          </filter>
        </defs>
        <circle cx="54" cy="54" r="46" fill="#07070f" stroke="#111120" stroke-width="1" />
        <circle cx="54" cy="54" r="38" fill="none" stroke="#0c0c1a" stroke-width="8.5" stroke-dasharray="192 240"
          stroke-dashoffset="-24" stroke-linecap="round" />
        <circle id="rpm-arc" cx="54" cy="54" r="38" fill="none" stroke="#991800" stroke-width="8.5"
          stroke-dasharray="0 240" stroke-dashoffset="-24" stroke-linecap="round"
          style="transform-origin:54px 54px;transform:rotate(-90deg) scaleX(-1);transition:stroke-dasharray .15s,stroke .2s"
          filter="url(#glow-r)" />
        <line id="rpm-needle" x1="54" y1="54" x2="54" y2="20" stroke="#dd2000" stroke-width="1.8" stroke-linecap="round"
          style="transform-origin:54px 54px;transform:rotate(-120deg);transition:transform .15s" />
        <circle cx="54" cy="54" r="5" fill="#991800" />
        <circle cx="54" cy="54" r="2.5" fill="#07070f" />
      </svg>
      <div class="gval" id="rpmval">0.0</div>
      <div class="gunit">×1000 RPM</div>
    </div>

    <div class="gw gcenter">
      <span class="glbl" style="font-size:8px;letter-spacing:2px">Velocidade</span>
      <svg width="148" height="148" viewBox="0 0 148 148">
        <defs>
          <filter id="glow-k">
            <feGaussianBlur stdDeviation="3" result="b" />
            <feMerge>
              <feMergeNode in="b" />
              <feMergeNode in="SourceGraphic" />
            </feMerge>
          </filter>
        </defs>
        <circle cx="74" cy="74" r="64" fill="#06060e" stroke="#101020" stroke-width="1.5" />
        <circle cx="74" cy="74" r="54" fill="none" stroke="#0c0c1a" stroke-width="10" stroke-dasharray="272 339"
          stroke-dashoffset="-33" stroke-linecap="round" />
        <circle id="kph-arc" cx="74" cy="74" r="54" fill="none" stroke="#991800" stroke-width="10"
          stroke-dasharray="0 339" stroke-dashoffset="-33" stroke-linecap="round"
          style="transform-origin:74px 74px;transform:rotate(-90deg) scaleX(-1);transition:stroke-dasharray .15s,stroke .2s"
          filter="url(#glow-k)" />
        <line id="kph-needle" x1="74" y1="74" x2="74" y2="22" stroke="#dd2000" stroke-width="2.2" stroke-linecap="round"
          style="transform-origin:74px 74px;transform:rotate(-120deg);transition:transform .15s" />
        <circle cx="74" cy="74" r="8" fill="#991800" />
        <circle cx="74" cy="74" r="4" fill="#06060e" />
        <text x="74" y="97" text-anchor="middle" font-size="7" fill="#141428" font-family="Courier New"
          letter-spacing="1.5">km/h</text>
      </svg>
      <div class="gval" id="kphval" style="font-size:24px;color:#bb2000;transition:color .3s">0</div>
    </div>

    <div class="gw">
      <span class="glbl">Marcha</span>
      <svg width="108" height="108" viewBox="0 0 108 108">
        <circle cx="54" cy="54" r="46" fill="#07070f" stroke="#111120" stroke-width="1" />
        <text id="geartext" x="54" y="67" text-anchor="middle" font-size="40" font-weight="bold" fill="#991800"
          font-family="Courier New" style="transition:fill .2s">N</text>
      </svg>
      <div class="gval" id="tempval" style="font-size:11px;transition:color .5s">80°C</div>
      <div class="gunit">motor</div>
    </div>
  </div>

  <div id="botbar">
    <div class="ipill"><label>Odômetro</label><span id="odoval">00000 km</span></div>
    <div class="tyrewrap">
      <label style="font-size:7px;color:#141428;letter-spacing:2px;text-transform:uppercase">Pneus</label>
      <div class="tyrerow">
        <div class="tyre" id="tfl" style="background:#d8d0b8">D</div>
        <div class="tyre" id="tfr" style="background:#d8d0b8">D</div>
      </div>
      <div class="tyrerow">
        <div class="tyre" id="trl" style="background:#d8d0b8">D</div>
        <div class="tyre" id="trr" style="background:#d8d0b8">D</div>
      </div>
    </div>
    <div class="ipill"><label>Combustível</label><span id="fuelval" style="font-size:9px">████████</span></div>
    <div class="ipill"><label>Tempo</label><span id="timeval">00:00</span></div>
    <div class="ipill"><label>Volta</label><span id="lapcnt">42/78</span></div>
  </div>

  <div id="demoarea">
    <label>ACELERADOR:</label>
    <input type="range" id="speedSlider" min="0" max="340" value="0" step="1">
    <span id="speedlabel">0 km/h</span>
  </div>
</div>
</body>


<script>
  const $ = id => document.getElementById(id);
  const slider = $('speedSlider');
  const RACE_MS = 300000;
  const raceStart = Date.now();
  let raceOver = false, isMuted = false;
  let odo = 0, bestLap = 72.884, lapTick = 0;
  let audioCtx = null;
  let confPieces = [], confRunning = false;
  let ovCool = false;

  $('mute-btn').onclick = () => { isMuted = !isMuted; $('mute-btn').textContent = isMuted ? 'SOM OFF' : 'SOM ON' };

  function AC() { if (!audioCtx) audioCtx = new (window.AudioContext || window.webkitAudioContext)(); return audioCtx; }

  function beep(freq, type, gain, dur, t0) {
    try {
      const c = AC(), o = c.createOscillator(), g = c.createGain(); o.connect(g); g.connect(c.destination);
      o.frequency.value = freq; o.type = type; const t = t0 || c.currentTime;
      g.gain.setValueAtTime(0, t); g.gain.linearRampToValueAtTime(gain, t + .03);
      g.gain.setValueAtTime(gain, t + dur - .04); g.gain.linearRampToValueAtTime(0, t + dur);
      o.start(t); o.stop(t + dur + .01);
    } catch (e) { }
  }

  let lastEngT = 0;
  function enginePulse(kph, rpm) {
    if (isMuted || raceOver || kph < 5) return;
    const now = AC().currentTime;
    if (now - lastEngT < .09) return;
    lastEngT = now;
    beep(35 + rpm * .0025, 'sawtooth', .032, .1);
  }

  function playOvertake() {
    if (isMuted) return;
    [550, 750, 1000, 1300].forEach((f, i) => beep(f, 'sine', .12, .18, AC().currentTime + i * .08));
  }

  function playAnthem() {
    if (isMuted) return;
    const notes = [
      [392, .38], [392, .19], [392, .19], [392, .38], [349, .38], [392, .38], [440, .38], [392, .76],
      [330, .38], [330, .19], [330, .19], [330, .38], [294, .38], [330, .38], [370, .38], [330, .76],
      [392, .38], [392, .19], [392, .19], [392, .38], [440, .38], [494, .38], [523, .38], [494, .76],
      [440, .38], [440, .19], [440, .19], [440, .38], [494, .38], [440, .38], [415, .38], [392, 1.1],
      [523, .38], [523, .19], [523, .19], [523, .38], [494, .38], [466, .38], [440, .38], [415, .76],
      [392, .38], [370, .38], [392, .38], [440, .56], [392, .56], [349, .38], [330, 1.1]
    ];
    let t = AC().currentTime + .6;
    notes.forEach(([f, d]) => { beep(f, 'triangle', .16, d, t); t += d; });
  }

  const STAR_COUNT = 90;
  const stars = Array.from({ length: STAR_COUNT }, () => ({
    x: Math.random(), y: Math.random() * .52,
    r: .6 + Math.random() * 1.4,
    base: .15 + Math.random() * .7,
    phase: Math.random() * Math.PI * 2,
    speed: .4 + Math.random() * 1.2
  }));

  const MOON = { x: .83, y: .12, r: 16 };

  const BUILDING_DATA = (() => {
    const arr = [];
    const pal = ['#0b0b19', '#0d0d1d', '#090916', '#0f0f1e', '#0c0c1a'];
    const sizes = [
      [38, 58], [22, 82], [55, 118], [28, 68], [18, 46], [62, 148], [32, 94],
      [48, 128], [24, 62], [42, 102], [30, 78], [57, 138], [20, 52], [44, 108], [36, 72],
      [52, 120], [26, 58], [40, 90], [28, 68], [50, 130], [20, 48]
    ];
    sizes.concat(sizes).forEach(([w, h], i) => {
      const wins = [];
      const wC = Math.floor(w / 10), wR = Math.floor(h / 14);
      for (let r = 0; r < wR; r++)for (let c = 0; c < wC; c++) {
        if (Math.random() > .45) wins.push({ x: c * 10 + 3, y: h - r * 14 - 10, lit: Math.random() > .2, col: Math.random() > .4 ? '#ffd580' : '#ffaa40', op: .3 + Math.random() * .55 });
      }
      arr.push({ w, h, col: pal[i % 5], wins });
    });
    return arr;
  })();

  const RIVAL_DATA = [
    { abbr: 'VER', col: '#1a3aff', x: .20, y: 22, spd: .95 },
    { abbr: 'HAM', col: '#00c8a0', x: .74, y: 16, spd: .92 },
    { abbr: 'SAI', col: '#cc0000', x: .80, y: 26, spd: .88 },
    { abbr: 'NOR', col: '#ff6400', x: .58, y: 30, spd: .82 },
    { abbr: 'RUS', col: '#00c8a0', x: .34, y: 32, spd: .78 },
  ];
  const rivals = RIVAL_DATA.map(r => ({ ...r, xf: r.x }));

  function buildTower() {
    const rows = [
      { p: 1, a: 'VER', f: '#1a3aff', g: '+3.4s' }, { p: 2, a: 'HAM', f: '#00c8a0', g: '+1.2s' },
      { p: 3, a: 'LEC', f: '#cc0000', g: '——', us: true }, { p: 4, a: 'SAI', f: '#cc0000', g: '-0.8s' },
      { p: 5, a: 'NOR', f: '#ff6400', g: '-2.1s' }, { p: 6, a: 'RUS', f: '#00c8a0', g: '-4.7s' }
    ];
    $('postower').innerHTML = rows.map(r => `<div class="pos-row${r.us ? ' us' : ''}"><span class="pn">${r.p}</span><div class="pfl" style="background:${r.f}"></div><span class="pab">${r.a}</span><span class="pgp">${r.g}</span></div>`).join('');
  }
  buildTower();

  const bgCanvas = $('bg-canvas');
  const bgCtx = bgCanvas.getContext('2d');
  const rdCanvas = $('road-canvas');
  const rdCtx = rdCanvas.getContext('2d');

  function resizeCanvases() {
    bgCanvas.width = bgCanvas.offsetWidth;
    bgCanvas.height = bgCanvas.offsetHeight;
    rdCanvas.width = rdCanvas.offsetWidth;
    rdCanvas.height = rdCanvas.offsetHeight;
    const cc = $('confetti-canvas');
    cc.width = cc.offsetWidth;
    cc.height = cc.offsetHeight;
  }
  resizeCanvases();
  window.addEventListener('resize', resizeCanvases);

  let bldOffset = 0, dashOffset = 0;
  let time = 0;

  function drawBg(kph) {
    const W = bgCanvas.width, H = bgCanvas.height;
    bgCtx.clearRect(0, 0, W, H);

    const skyH = H * .56;
    const grad = bgCtx.createLinearGradient(0, 0, 0, skyH);
    grad.addColorStop(0, '#020210');
    grad.addColorStop(.5, '#080820');
    grad.addColorStop(1, '#12102a');
    bgCtx.fillStyle = grad;
    bgCtx.fillRect(0, 0, W, skyH);

    const mx = W * MOON.x, my = H * MOON.y;
    const mGrad = bgCtx.createRadialGradient(mx, my, 0, mx, my, MOON.r * 2.5);
    mGrad.addColorStop(0, 'rgba(212,200,138,.15)');
    mGrad.addColorStop(1, 'rgba(0,0,0,0)');
    bgCtx.fillStyle = mGrad;
    bgCtx.fillRect(0, 0, W, skyH);
    bgCtx.beginPath();
    bgCtx.arc(mx, my, MOON.r, 0, Math.PI * 2);
    bgCtx.fillStyle = '#cfc38a';
    bgCtx.fill();
    [[5, 5, 4], [14, 5, 3], [8, 14, 3.5]].forEach(([cx, cy, cr]) => {
      bgCtx.beginPath();
      bgCtx.arc(mx - MOON.r * .5 + cx, my - MOON.r * .5 + cy, cr, 0, Math.PI * 2);
      bgCtx.fillStyle = '#b8ac78';
      bgCtx.fill();
    });

    stars.forEach(s => {
      const bri = s.base + Math.sin(time * s.speed + s.phase) * (1 - s.base) * .7;
      bgCtx.beginPath();
      bgCtx.arc(s.x * W, s.y * H, s.r, 0, Math.PI * 2);
      bgCtx.fillStyle = `rgba(255,255,255,${bri})`;
      bgCtx.fill();
    });

    const seaY = H * .44, seaH = H * .07;
    const seaGrad = bgCtx.createLinearGradient(0, seaY, 0, seaY + seaH);
    seaGrad.addColorStop(0, '#03101e');
    seaGrad.addColorStop(1, '#060e1c');
    bgCtx.fillStyle = seaGrad;
    bgCtx.fillRect(0, seaY, W, seaH);

    const shimCount = 14;
    for (let i = 0; i < shimCount; i++) {
      const sx = ((i / (shimCount - 1)) * W * 1.4 + dashOffset * .3) % W;
      const sw = 15 + Math.sin(i * 1.7 + time) * 8;
      const sa = .05 + Math.sin(i * 2.3 + time * .7) * .04;
      bgCtx.beginPath();
      bgCtx.moveTo(sx, seaY + seaH * .3);
      bgCtx.lineTo(sx + sw, seaY + seaH * .3);
      bgCtx.strokeStyle = `rgba(120,190,255,${sa})`;
      bgCtx.lineWidth = 1.5;
      bgCtx.stroke();
    }

    const totalBldW = BUILDING_DATA.reduce((a, b) => a + b.w + 1, 0) / 2;
    const bOff = (bldOffset % totalBldW);
    let bx = -bOff;
    const bldBase = H * .44;
    BUILDING_DATA.forEach(b => {
      if (bx + b.w > 0 && bx < W) {
        bgCtx.fillStyle = b.col;
        bgCtx.fillRect(bx, bldBase - b.h, b.w, b.h);
        b.wins.forEach(w => {
          bgCtx.fillStyle = w.col;
          bgCtx.globalAlpha = w.op * (w.lit ? 1 : .2);
          bgCtx.fillRect(bx + w.x, bldBase - b.h + w.y, 4, 5);
          bgCtx.globalAlpha = 1;
        });
      }
      bx += b.w + 1;
      if (bx > W) { bx -= totalBldW; }
    });

    const hGrad = bgCtx.createLinearGradient(0, H * .42, 0, H * .46);
    hGrad.addColorStop(0, 'rgba(6,6,14,0)');
    hGrad.addColorStop(1, 'rgba(6,6,14,1)');
    bgCtx.fillStyle = hGrad;
    bgCtx.fillRect(0, H * .42, W, H * .06);
  }

  function drawRoad(kph) {
    const W = rdCanvas.width, H = rdCanvas.height;
    rdCtx.clearRect(0, 0, W, H);

    rdCtx.fillStyle = '#131316';
    rdCtx.fillRect(0, 0, W, H);

    for (let i = 0; i < W; i += 4) {
      rdCtx.fillStyle = `rgba(255,255,255,${Math.random() * .006})`;
      rdCtx.fillRect(i, 0, 2, H);
    }

    const kerbH = 7;
    const segs = Math.ceil(W / kerbH);
    for (let i = 0; i < segs; i++) {
      rdCtx.fillStyle = i % 2 === 0 ? '#cc0000' : '#f0f0f0';
      rdCtx.fillRect(i * kerbH, 0, kerbH, kerbH);
      rdCtx.fillRect(i * kerbH, H - kerbH, kerbH, kerbH);
    }
    rdCtx.fillStyle = '#cc0000';
    rdCtx.fillRect(0, kerbH, 3, H - kerbH * 2);
    rdCtx.fillRect(W - 3, kerbH, 3, H - kerbH * 2);

    const dw = 55, gap = 120, y = H * .48;
    const total = dw + gap;
    const startX = -(dashOffset % total);
    for (let x = startX; x < W + dw; x += total) {
      rdCtx.fillStyle = 'rgba(255,255,255,.42)';
      rdCtx.beginPath();
      rdCtx.roundRect(x, y - 2, dw, 4, 2);
      rdCtx.fill();
    }

    rdCtx.fillStyle = 'rgba(255,255,255,.18)';
    rdCtx.fillRect(W * .14, kerbH, 2.5, H - kerbH * 2);
    rdCtx.fillRect(W * .86, kerbH, 2.5, H - kerbH * 2);

    const refY = H * .88;
    rdCtx.fillStyle = 'rgba(255,255,255,.04)';
    rdCtx.fillRect(0, refY, W, H - refY);

    const rPerspH = H * .55;
    const rCenterX = W * .5;
    rivals.forEach(r => {
      const rx = r.xf * W - 30;
      const ry = H - r.y - 20;
      if (rx < -80 || rx > W + 20) return;

      rdCtx.save();
      rdCtx.globalAlpha = .18;
      rdCtx.fillStyle = r.col;
      rdCtx.beginPath();
      rdCtx.ellipse(rx + 30, ry + 18, 28, 6, 0, 0, Math.PI * 2);
      rdCtx.fill();
      rdCtx.globalAlpha = 1;

      rdCtx.fillStyle = r.col;
      rdCtx.beginPath();
      rdCtx.roundRect(rx + 8, ry + 4, 44, 8, 2);
      rdCtx.fill();
      rdCtx.beginPath();
      rdCtx.moveTo(rx + 10, ry + 4);
      rdCtx.lineTo(rx + 50, ry + 4);
      rdCtx.lineTo(rx + 45, ry - 4);
      rdCtx.lineTo(rx + 15, ry - 4);
      rdCtx.closePath();
      rdCtx.fill();
      rdCtx.fillStyle = 'rgba(0,0,0,.6)';
      rdCtx.beginPath();
      rdCtx.roundRect(rx + 22, ry - 3, 16, 5, 1);
      rdCtx.fill();
      rdCtx.fillStyle = '#1a1a1a';
      rdCtx.beginPath(); rdCtx.ellipse(rx + 16, ry + 12, 6, 5, 0, 0, Math.PI * 2); rdCtx.fill();
      rdCtx.beginPath(); rdCtx.ellipse(rx + 44, ry + 12, 6, 5, 0, 0, Math.PI * 2); rdCtx.fill();

      rdCtx.fillStyle = r.col;
      rdCtx.font = 'bold 7px Courier New';
      rdCtx.textAlign = 'center';
      rdCtx.fillText(r.abbr, rx + 30, ry - 7);
      rdCtx.restore();
    });

    const cx = W * .5 - 40, cy = H - 10;
    rdCtx.save();
    rdCtx.globalAlpha = .22; rdCtx.fillStyle = '#cc0000';
    rdCtx.beginPath(); rdCtx.ellipse(cx + 41, cy + 8, 38, 7, 0, 0, Math.PI * 2); rdCtx.fill();
    rdCtx.globalAlpha = 1;

    rdCtx.fillStyle = '#cc0000';
    rdCtx.beginPath(); rdCtx.roundRect(cx + 7, cy - 10, 68, 9, 2.5); rdCtx.fill();
    rdCtx.beginPath();
    rdCtx.moveTo(cx + 11, cy - 10); rdCtx.lineTo(cx + 72, cy - 10);
    rdCtx.lineTo(cx + 63, cy - 20); rdCtx.lineTo(cx + 20, cy - 20); rdCtx.closePath(); rdCtx.fill();
    rdCtx.fillStyle = 'rgba(0,0,0,.65)';
    rdCtx.beginPath(); rdCtx.roundRect(cx + 24, cy - 19, 34, 8, 1); rdCtx.fill();
    rdCtx.fillStyle = '#ffd700'; rdCtx.beginPath(); rdCtx.roundRect(cx + 38, cy - 21, 5, 11, 1); rdCtx.fill();
    rdCtx.fillStyle = '#1a1a1a';
    rdCtx.beginPath(); rdCtx.ellipse(cx + 19, cy, 8, 6, 0, 0, Math.PI * 2); rdCtx.fill();
    rdCtx.beginPath(); rdCtx.ellipse(cx + 62, cy, 8, 6, 0, 0, Math.PI * 2); rdCtx.fill();
    rdCtx.fillStyle = '#ff4400';
    rdCtx.beginPath(); rdCtx.arc(cx + 65, cy - 14, 2, 0, Math.PI * 2); rdCtx.fill();
    rdCtx.save();
    rdCtx.fillStyle = 'rgba(255,80,0,';
    rdCtx.globalAlpha = .6 + Math.sin(time * 25) * .4;
    rdCtx.beginPath(); rdCtx.ellipse(cx + 73, cy - 5, 3 + Math.sin(time * 30) * 2, 2, 0, 0, Math.PI * 2); rdCtx.fill();
    rdCtx.restore();
    rdCtx.restore();
  }

  const confCtx = $('confetti-canvas').getContext('2d');
  const BR_COLS = ['#009c3b', '#ffdf00', '#002776', '#ffffff', '#cc0000', '#ff8800', '#ffffff', '#009c3b'];

  function launchConfetti() {
    const cc = $('confetti-canvas');
    cc.style.display = 'block';
    cc.width = cc.offsetWidth || 660; cc.height = cc.offsetHeight || 310;
    confPieces = Array.from({ length: 200 }, () => ({
      x: Math.random() * cc.width, y: -20 - Math.random() * 300,
      w: 5 + Math.random() * 9, h: 3 + Math.random() * 5,
      rot: Math.random() * 360, rV: (Math.random() - .5) * 7,
      vx: (Math.random() - .5) * 2.5, vy: 1.2 + Math.random() * 3.2,
      col: BR_COLS[Math.floor(Math.random() * BR_COLS.length)],
      amp: 20 + Math.random() * 30, freq: .3 + Math.random() * .8, phase: Math.random() * Math.PI * 2, t: 0
    }));
    confRunning = true;
  }

  function drawConfetti() {
    if (!confRunning) return;
    const cc = $('confetti-canvas');
    confCtx.clearRect(0, 0, cc.width, cc.height);
    confPieces.forEach(p => {
      p.t += .016; p.y += p.vy; p.rot += p.rV;
      p.x += p.vx + Math.sin(p.t * p.freq + p.phase) * 1.2;
      if (p.y > cc.height + 20) p.y = -15;
      confCtx.save();
      confCtx.translate(p.x, p.y);
      confCtx.rotate(p.rot * Math.PI / 180);
      confCtx.fillStyle = p.col;
      confCtx.globalAlpha = .88;
      confCtx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
      confCtx.restore();
    });
  }

  let lastOvX = rivals.map(r => r.xf);

  function checkOvertakes(kph) {
    if (ovCool || kph < 80) return;
    rivals.forEach((r, i) => {
      const prev = lastOvX[i], curr = r.xf;
      if (prev > .44 && curr < .44 && prev < .88) {
        ovCool = true;
        playOvertake();
        const el = $('ov-msg');
        $('ovsub').textContent = 'ULTRAPASSOU ' + r.abbr + '!';
        el.style.opacity = '1'; el.style.transform = 'translateY(0)';
        setTimeout(() => { el.style.opacity = '0'; el.style.transform = 'translateY(-6px)'; setTimeout(() => { ovCool = false; }, 800); }, 2200);
      }
      lastOvX[i] = curr;
    });
  }

  function triggerVictory() {
    raceOver = true;
    const elapsed = (Date.now() - raceStart);
    const em = Math.floor(elapsed / 60000), es = ((elapsed % 60000) / 1000).toFixed(3);
    $('vtime').textContent = `${em}:${parseFloat(es) < 10 ? '0' : ''}${es}`;
    $('vflag').textContent = '🏁';
    $('victory').style.display = 'flex';
    launchConfetti();
    setTimeout(playAnthem, 900);
  }

  let lapSecBase = 0;
  let raceElapsed = 0;

  setInterval(() => {
    if (raceOver) return;
    const kph = parseInt(slider.value);
    raceElapsed = Date.now() - raceStart;
    odo += kph / 3600 / 4;
    $('odoval').textContent = Math.floor(odo).toString().padStart(5, '0') + ' km';

    const es = Math.floor(raceElapsed / 1000);
    const em = Math.floor(es / 60), esec = es % 60;
    $('timeval').textContent = em.toString().padStart(2, '0') + ':' + esec.toString().padStart(2, '0');

    const rem = Math.max(0, RACE_MS - raceElapsed);
    const remS = Math.ceil(rem / 1000);
    const rm = Math.floor(remS / 60), rs = remS % 60;
    $('timerval').textContent = `${rm}:${rs.toString().padStart(2, '0')}`;
    $('timerfill').style.width = (rem / RACE_MS * 100) + '%';
    $('timerfill').style.background = rem < 30000 ? '#ff0000' : rem < 60000 ? '#ff6600' : '#cc1800';

    lapTick += .25;
    const lb = kph > 200 ? 71 : kph > 150 ? 73 : kph > 80 ? 76 : 82;
    const ln = lb + Math.sin(lapTick) * .35;
    const lm = Math.floor(ln / 60), ls = (ln % 60).toFixed(3);
    $('laptime').textContent = `${lm}:${parseFloat(ls) < 10 ? '0' : ''}${ls}`;
    if (ln < bestLap) { bestLap = ln; const bm = Math.floor(bestLap / 60), bs = (bestLap % 60).toFixed(3); $('besttime').textContent = `Melhor ${bm}:${parseFloat(bs) < 10 ? '0' : ''}${bs}`; }

    const lv = Math.min(78, 42 + Math.floor(es / 8));
    $('lapnum').textContent = lv; $('lapcnt').textContent = lv + '/78';

    const fp = Math.max(0, 1 - odo / 200), fb = Math.round(fp * 8);
    $('fuelval').textContent = '█'.repeat(fb) + '░'.repeat(8 - fb);
    const wc = Math.min(1, odo / 80);
    const tc = wc > .7 ? '#ee4400' : wc > .4 ? '#ff8800' : '#d8d0b8';
    ['tfl', 'tfr', 'trl', 'trr'].forEach(id => { $(id).style.background = tc; });

    if (rem <= 0) triggerVictory();
  }, 250);

  function updateGauges(kph, rpmReal = null) {
    const kp = kph / 340;
    $('kphval').textContent = kph;
    $('speedlabel').textContent = kph + ' km/h';
    kphArc.setAttribute('stroke-dasharray', (kp * 272) + ' 339');
    $('kph-needle').style.transform = `rotate(${-120 + kp * 240}deg)`;

    const gear = kph === 0 ? 0 : kph < 80 ? 1 : kph < 140 ? 2 : kph < 190 ? 3 : kph < 240 ? 4 : kph < 290 ? 5 : kph < 320 ? 6 : 7;
    $('geartext').textContent = ['N', '1', '2', '3', '4', '5', '6', '7'][gear];

    // Usa RPM real do sensor se disponível, senão simula pelo kph
    let rr;
    if (rpmReal !== null && rpmReal >= 0) {
      rr = Math.min(1, rpmReal / 18000);
    } else {
      rr = kph === 0 ? 0 : Math.min(1, (kp / (gear * 0.155)) * 0.92);
    }
    rr = Math.min(1, rr);
    const rpm = Math.round(rr * 18000);
    $('rpmval').textContent = (rpm / 1000).toFixed(1);
    $('rpm-arc').setAttribute('stroke-dasharray', (rr * 192) + ' 240');
    $('rpm-needle').style.transform = `rotate(${-120 + rr * 240}deg)`;

    const ac = rr > .88 ? '#ff0000' : rr > .72 ? '#ee2200' : '#991800';
    $('rpm-arc').setAttribute('stroke', ac);
    $('kph-arc').setAttribute('stroke', kph > 300 ? '#ff0000' : kph > 240 ? '#ee2200' : '#991800');
    $('geartext').setAttribute('fill', ac);

    const temp = Math.round(80 + kph * .28 + rr * 30);
    $('tempval').textContent = temp + '°C';
    $('tempval').style.color = temp > 180 ? '#ff2200' : temp > 140 ? '#ff6600' : '#771200';

    $('drsbadge').className = 'drs ' + (kph > 180 ? 'don' : 'doff');

    enginePulse(kph, rpm);
  }

  const kphArc = $('kph-arc');

  let animKph = 0, targetKph = 0;
  let lastRpm = null; // RPM real vindo do backend
  function lerp(a, b, t) { return a + (b - a) * t; }

  function mainLoop() {
    time += .016;
    const kph = parseInt(slider.value);
    targetKph = kph;
    animKph = lerp(animKph, targetKph, .18);
    const smoothKph = Math.round(animKph);

    const spd = smoothKph / 340;
    const bldSpd = smoothKph === 0 ? 0 : Math.max(.3, 22 - smoothKph / 18);
    if (smoothKph > 0) bldOffset += bldSpd * .3;

    const dashSpd = smoothKph === 0 ? 0 : Math.max(.5, 8 - smoothKph / 50);
    if (smoothKph > 0) dashOffset += dashSpd * 1.8;

    rivals.forEach(r => {
      const rel = spd - r.spd * .65;
      r.xf -= rel * .003;
      if (r.xf > 1.1) r.xf -= 1.2;
      if (r.xf < -.1) r.xf += 1.2;
    });

    checkOvertakes(smoothKph);
    updateGauges(smoothKph, lastRpm); // passa RPM real do sensor
    drawBg(smoothKph);
    drawRoad(smoothKph);
    if (confRunning) drawConfetti();

    requestAnimationFrame(mainLoop);
  }

  async function fetchData() {
    if (raceOver) return;
    try {
      const r = await fetch('buscar_ultimo.php');
      if (!r.ok) throw new Error();
      const d = await r.json();
      if (d.kph !== undefined) slider.value = Math.min(340, Math.max(0, Math.round(d.kph)));
      lastRpm = (d.rpm !== undefined) ? d.rpm : null; // armazena RPM real
    } catch (e) { }
  }
  setInterval(fetchData, 250);

  mainLoop();
</script>
</html>