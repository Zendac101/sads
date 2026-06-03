// ─── USER SESSION ─────────────────────────────────────────────────────
let currentUser = { name: '', email: '' };

// ─── DATA ─────────────────────────────────────────────────────────────
const pollutants = [
  { name: 'PM2.5', value: 24.3, unit: 'µg/m³', max: 75,  color: '#f9c74f' },
  { name: 'PM10',  value: 41.2, unit: 'µg/m³', max: 150, color: '#4caf7d' },
  { name: 'NO',    value: 8.1,  unit: 'µg/m³', max: 100, color: '#4caf7d' },
  { name: 'NO₂',   value: 18.4, unit: 'µg/m³', max: 100, color: '#f9c74f' },
  { name: 'NOx',   value: 26.5, unit: 'µg/m³', max: 150, color: '#4caf7d' },
  { name: 'CO',    value: 0.8,  unit: 'mg/m³', max: 10,  color: '#4caf7d' },
  { name: 'SO₂',   value: 12.3, unit: 'µg/m³', max: 75,  color: '#4caf7d' },
  { name: 'O₃',    value: 38.7, unit: 'µg/m³', max: 100, color: '#f77f00' },
  { name: 'AQI',   value: 87,   unit: 'index',  max: 200, color: '#f9c74f' },
];

const hourlyData = [
  { time: '6am',  aqi: 62 },
  { time: '7am',  aqi: 71 },
  { time: '8am',  aqi: 83 },
  { time: '9am',  aqi: 87, now: true },
  { time: '10am', aqi: 90 },
  { time: '11am', aqi: 95 },
  { time: '12pm', aqi: 101 },
  { time: '1pm',  aqi: 98 },
  { time: '2pm',  aqi: 88 },
];

const stations = {
  'Lingayen':   { aqi: 87,  pm25: 24.3, pm10: 41.2, co: 0.8,  no2: 18.4 },
  'Dagupan':    { aqi: 112, pm25: 38.1, pm10: 62.5, co: 1.2,  no2: 27.3 },
  'San Carlos': { aqi: 54,  pm25: 12.4, pm10: 22.1, co: 0.4,  no2: 9.2  },
  'Urdaneta':   { aqi: 147, pm25: 51.2, pm10: 88.4, co: 2.1,  no2: 42.8 },
  'Alaminos':   { aqi: 42,  pm25: 8.6,  pm10: 17.3, co: 0.3,  no2: 7.1  },
  'Mangatarem': { aqi: 98,  pm25: 29.8, pm10: 51.4, co: 0.9,  no2: 21.6 },
};

const trendsData = {
  hourly:  { labels: ['6am','7am','8am','9am','10am','11am','12pm','1pm','2pm'], values: [62,71,83,87,90,95,101,98,88], period: 'Today, Jun 2' },
  daily:   { labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], values: [72,65,88,101,95,58,87], period: 'This Week' },
  monthly: { labels: ['Jan','Feb','Mar','Apr','May','Jun'], values: [95,88,76,82,91,87], period: 'This Year' },
};

const dailySummary = [
  { day: 'Mon', aqi: 72  },
  { day: 'Tue', aqi: 65  },
  { day: 'Wed', aqi: 88  },
  { day: 'Thu', aqi: 101 },
  { day: 'Fri', aqi: 95  },
  { day: 'Sat', aqi: 58  },
  { day: 'Sun', aqi: 87  },
];

let currentPeriod = 'hourly';

// ─── AQI COLOR ────────────────────────────────────────────────────────
function aqiColor(val) {
  if (val <= 50)  return '#4caf7d';
  if (val <= 100) return '#f9c74f';
  if (val <= 150) return '#f77f00';
  if (val <= 200) return '#d62828';
  return '#7b2d8b';
}

function aqiLabel(val) {
  if (val <= 50)  return 'Good';
  if (val <= 100) return 'Moderate';
  if (val <= 150) return 'Sensitive';
  if (val <= 200) return 'Unhealthy';
  return 'Hazardous';
}

// ─── NAVIGATION ───────────────────────────────────────────────────────
function goTo(screenId) {
  document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
  document.getElementById(screenId).classList.add('active');
}

function switchTab(tab) {
  const map = { home: 'screen-home', map: 'screen-map', trends: 'screen-trends', settings: 'screen-settings' };
  goTo(map[tab] || 'screen-home');
  if (tab === 'trends') setTimeout(() => renderTrendsScreen(), 60);
}

// ─── AUTH: SAVE USER & SHOW IN APP ────────────────────────────────────
function applyUserToApp() {
  // Settings profile
  const nameEl = document.getElementById('profile-name');
  const emailEl = document.getElementById('profile-email');
  const avatarEl = document.getElementById('profile-avatar');
  if (nameEl)   nameEl.textContent  = currentUser.name  || 'User';
  if (emailEl)  emailEl.textContent = currentUser.email || '';
  if (avatarEl) avatarEl.textContent = (currentUser.name || 'U').charAt(0).toUpperCase();

  // Home greeting
  const greetName = currentUser.name ? currentUser.name.split(' ')[0] : '';
  const homeGreet = document.querySelector('.home-greeting');
  if (homeGreet && greetName) {
    homeGreet.innerHTML = `Hi, ${greetName}! ☀️<strong id="home-location">Pangasinan, PH</strong>`;
  }
}

function handleLogin() {
  clearAllErrors('screen-login');
  const emailEl    = document.getElementById('login-email');
  const passwordEl = document.getElementById('login-pass');
  let valid = true;

  if (!emailEl.value.trim()) {
    showError(emailEl, 'Email is required.'); valid = false;
  } else if (!isValidEmail(emailEl.value.trim())) {
    showError(emailEl, 'Please enter a valid email address.'); valid = false;
  }
  if (!passwordEl.value.trim()) {
    showError(passwordEl, 'Password is required.'); valid = false;
  } else if (passwordEl.value.length < 6) {
    showError(passwordEl, 'Password must be at least 6 characters.'); valid = false;
  }

  if (valid) {
    // Use email prefix as name if no name stored
    const emailVal = emailEl.value.trim();
    currentUser.email = emailVal;
    if (!currentUser.name) currentUser.name = emailVal.split('@')[0];
    applyUserToApp();
    switchTab('home');
  }
}

function handleSignup() {
  clearAllErrors('screen-signup');
  const nameEl     = document.getElementById('signup-name');
  const emailEl    = document.getElementById('signup-email');
  const passwordEl = document.getElementById('signup-pass');
  let valid = true;

  if (!nameEl.value.trim() || nameEl.value.trim().length < 2) {
    showError(nameEl, 'Please enter your full name.'); valid = false;
  }
  if (!emailEl.value.trim()) {
    showError(emailEl, 'Email is required.'); valid = false;
  } else if (!isValidEmail(emailEl.value.trim())) {
    showError(emailEl, 'Please enter a valid email address.'); valid = false;
  }
  if (!passwordEl.value.trim()) {
    showError(passwordEl, 'Password is required.'); valid = false;
  } else if (passwordEl.value.length < 6) {
    showError(passwordEl, 'Password must be at least 6 characters.'); valid = false;
  }

  if (valid) {
    currentUser.name  = nameEl.value.trim();
    currentUser.email = emailEl.value.trim();
    applyUserToApp();
    switchTab('home');
  }
}

function handleLogout() {
  currentUser = { name: '', email: '' };
  // Clear login fields
  const loginEmail = document.getElementById('login-email');
  const loginPass  = document.getElementById('login-pass');
  if (loginEmail) loginEmail.value = '';
  if (loginPass)  loginPass.value  = '';
  goTo('screen-opening');
}

// ─── FORM VALIDATION HELPERS ──────────────────────────────────────────
function isValidEmail(val) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
}
function showError(inputEl, msg) {
  clearError(inputEl);
  inputEl.style.borderColor = '#e05252';
  inputEl.style.background  = '#fff5f5';
  const err = document.createElement('div');
  err.className   = 'field-error';
  err.textContent = msg;
  inputEl.closest('.form-group').appendChild(err);
}
function clearError(inputEl) {
  inputEl.style.borderColor = '';
  inputEl.style.background  = '';
  const ex = inputEl.closest('.form-group').querySelector('.field-error');
  if (ex) ex.remove();
}
function clearAllErrors(screenId) {
  const screen = document.getElementById(screenId);
  screen.querySelectorAll('.field-error').forEach(e => e.remove());
  screen.querySelectorAll('.form-input').forEach(el => {
    el.style.borderColor = '';
    el.style.background  = '';
  });
}
function togglePass(id) {
  const input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
}

// ─── HOME: POLLUTANTS GRID ────────────────────────────────────────────
function renderPollutants() {
  const grid = document.getElementById('pollutants-grid');
  if (!grid) return;
  grid.innerHTML = pollutants.map(p => {
    const pct = Math.min(100, (p.value / p.max) * 100).toFixed(0);
    return `
      <div class="pollutant-card">
        <div class="pollutant-name">${p.name}</div>
        <div class="pollutant-value">${p.value}</div>
        <div class="pollutant-unit">${p.unit}</div>
        <div class="pollutant-bar">
          <div class="pollutant-fill" style="width:${pct}%;background:${p.color}"></div>
        </div>
      </div>`;
  }).join('');
}

// ─── HOME: HOURLY TREND STRIP ─────────────────────────────────────────
function renderTrend() {
  const scroll = document.getElementById('trend-scroll');
  if (!scroll) return;
  scroll.innerHTML = hourlyData.map(h => `
    <div class="trend-item ${h.now ? 'now' : ''}">
      <div class="trend-time">${h.time}</div>
      <div class="trend-aqi-val">${h.aqi}</div>
      <div class="trend-dot" style="background:${h.now ? 'rgba(255,255,255,0.6)' : aqiColor(h.aqi)}"></div>
    </div>`).join('');
}

// ─── MAP: STATION SELECT ──────────────────────────────────────────────
function selectStation(name) {
  const s = stations[name];
  if (!s) return;
  document.getElementById('station-name').textContent    = name + ' Station';
  document.getElementById('station-loc').textContent     = name + ', Pangasinan · just now';
  document.getElementById('station-aqi-val').textContent = s.aqi;
  const vals = [s.pm25, s.pm10, s.co, s.no2];
  document.querySelectorAll('.sheet-mini-grid .mini-stat').forEach((el, i) => {
    el.querySelector('.val').textContent = vals[i];
  });
  const sheet = document.querySelector('.map-bottom-sheet');
  sheet.style.transform = 'translateY(8px)';
  setTimeout(() => sheet.style.transform = '', 200);
}

// ─── TRENDS: CHART ────────────────────────────────────────────────────
function renderChart(period) {
  const canvas = document.getElementById('aqi-chart');
  if (!canvas) return;
  const ctx  = canvas.getContext('2d');
  const data = trendsData[period];
  const W    = canvas.offsetWidth || 310;
  const H    = 140;
  canvas.width  = W;
  canvas.height = H;

  const pad = { top: 10, right: 10, bottom: 10, left: 28 };
  const cW  = W - pad.left - pad.right;
  const cH  = H - pad.top  - pad.bottom;
  const max = Math.max(...data.values) * 1.15;
  const min = Math.min(...data.values) * 0.85;
  const rng = max - min;

  ctx.clearRect(0, 0, W, H);

  // Grid
  ctx.strokeStyle = '#e8ede9';
  ctx.lineWidth   = 1;
  [0, 0.25, 0.5, 0.75, 1].forEach(t => {
    const y = pad.top + cH * (1 - t);
    ctx.beginPath(); ctx.moveTo(pad.left, y); ctx.lineTo(pad.left + cW, y); ctx.stroke();
  });

  // Y labels
  ctx.fillStyle  = '#9aaba3';
  ctx.font       = '9px DM Sans, sans-serif';
  ctx.textAlign  = 'right';
  [0, 0.5, 1].forEach(t => {
    const val = Math.round(min + rng * t);
    const y   = pad.top + cH * (1 - t);
    ctx.fillText(val, pad.left - 4, y + 3);
  });

  // Points
  const pts = data.values.map((v, i) => ({
    x: pad.left + (i / (data.values.length - 1)) * cW,
    y: pad.top  + cH * (1 - (v - min) / rng)
  }));

  // Gradient fill
  const grad = ctx.createLinearGradient(0, pad.top, 0, pad.top + cH);
  grad.addColorStop(0, 'rgba(45,90,69,0.18)');
  grad.addColorStop(1, 'rgba(45,90,69,0)');
  ctx.beginPath();
  ctx.moveTo(pts[0].x, pad.top + cH);
  pts.forEach(p => ctx.lineTo(p.x, p.y));
  ctx.lineTo(pts[pts.length - 1].x, pad.top + cH);
  ctx.closePath();
  ctx.fillStyle = grad;
  ctx.fill();

  // Line
  ctx.beginPath();
  ctx.strokeStyle = '#2d5a45';
  ctx.lineWidth   = 2.5;
  ctx.lineJoin    = 'round';
  pts.forEach((p, i) => i === 0 ? ctx.moveTo(p.x, p.y) : ctx.lineTo(p.x, p.y));
  ctx.stroke();

  // Dots
  pts.forEach((p, i) => {
    ctx.beginPath();
    ctx.arc(p.x, p.y, i === 3 ? 5 : 3.5, 0, Math.PI * 2);
    ctx.fillStyle   = i === 3 ? '#1c3a2f' : '#3d7a5e';
    ctx.fill();
    ctx.strokeStyle = 'white';
    ctx.lineWidth   = 1.5;
    ctx.stroke();
  });

  // X labels
  const xWrap = document.getElementById('chart-x-labels');
  if (xWrap) xWrap.innerHTML = data.labels.map(l => `<span>${l}</span>`).join('');
}

function setPeriod(el, period) {
  currentPeriod = period;
  document.querySelectorAll('.period-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.getElementById('chart-period-label').textContent = trendsData[period].period;
  renderChart(period);
}

function renderPollutantTrends() {
  const wrap = document.getElementById('pollutant-trends');
  if (!wrap) return;
  const items = [
    { name: 'PM2.5', value: 24.3, max: 75,  unit: 'µg/m³', color: '#f9c74f' },
    { name: 'PM10',  value: 41.2, max: 150, unit: 'µg/m³', color: '#4caf7d' },
    { name: 'NO₂',   value: 18.4, max: 100, unit: 'µg/m³', color: '#f77f00' },
    { name: 'CO',    value: 0.8,  max: 10,  unit: 'mg/m³', color: '#4caf7d' },
    { name: 'SO₂',   value: 12.3, max: 75,  unit: 'µg/m³', color: '#4caf7d' },
    { name: 'O₃',    value: 38.7, max: 100, unit: 'µg/m³', color: '#f77f00' },
  ];
  wrap.innerHTML = items.map(p => {
    const pct = Math.min(100, (p.value / p.max) * 100).toFixed(0);
    return `
      <div class="pt-row">
        <div class="pt-name">${p.name}</div>
        <div class="pt-bar-wrap"><div class="pt-bar-fill" style="width:${pct}%;background:${p.color}"></div></div>
        <div class="pt-value">${p.value}</div>
        <div class="pt-unit">${p.unit}</div>
      </div>`;
  }).join('');
}

function renderDailySummary() {
  const wrap = document.getElementById('daily-summary');
  if (!wrap) return;
  const maxAqi = Math.max(...dailySummary.map(d => d.aqi));
  wrap.innerHTML = dailySummary.map(d => {
    const pct   = ((d.aqi / maxAqi) * 100).toFixed(0);
    const color = aqiColor(d.aqi);
    return `
      <div class="day-row">
        <div class="day-name">${d.day}</div>
        <div class="day-bar-wrap"><div class="day-bar-fill" style="width:${pct}%;background:${color}"></div></div>
        <div class="day-aqi" style="color:${color}">${d.aqi}</div>
        <div class="day-status">${aqiLabel(d.aqi)}</div>
      </div>`;
  }).join('');
}

function renderTrendsScreen() {
  renderChart(currentPeriod);
  renderPollutantTrends();
  renderDailySummary();
  document.querySelectorAll('.period-tab').forEach((t, i) => t.classList.toggle('active', i === 0));
  const label = document.getElementById('chart-period-label');
  if (label) label.textContent = trendsData['hourly'].period;
  currentPeriod = 'hourly';
}

// ─── CLOCK ────────────────────────────────────────────────────────────
function updateClock() {
  const now = new Date();
  const h   = now.getHours().toString().padStart(2, '0');
  const m   = now.getMinutes().toString().padStart(2, '0');
  const el  = document.querySelector('.status-bar .time');
  if (el) el.textContent = `${h}:${m}`;
}

// ─── INIT ─────────────────────────────────────────────────────────────
renderPollutants();
renderTrend();
updateClock();
setInterval(updateClock, 30000);