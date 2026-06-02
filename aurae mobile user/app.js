// ─── DATA ───────────────────────────────────────────────────────────
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
  'Lingayen':   { aqi: 87,  status: 'Moderate',  pm25: 24.3, pm10: 41.2, co: 0.8,  no2: 18.4 },
  'Dagupan':    { aqi: 112, status: 'Sensitive',  pm25: 38.1, pm10: 62.5, co: 1.2,  no2: 27.3 },
  'San Carlos': { aqi: 54,  status: 'Good',       pm25: 12.4, pm10: 22.1, co: 0.4,  no2: 9.2  },
  'Urdaneta':   { aqi: 147, status: 'Unhealthy',  pm25: 51.2, pm10: 88.4, co: 2.1,  no2: 42.8 },
  'Alaminos':   { aqi: 42,  status: 'Good',       pm25: 8.6,  pm10: 17.3, co: 0.3,  no2: 7.1  },
  'Mangatarem': { aqi: 98,  status: 'Moderate',   pm25: 29.8, pm10: 51.4, co: 0.9,  no2: 21.6 },
};

// ─── AQI COLOR ────────────────────────────────────────────────────────
function aqiColor(val) {
  if (val <= 50)  return '#4caf7d';
  if (val <= 100) return '#f9c74f';
  if (val <= 150) return '#f77f00';
  if (val <= 200) return '#d62828';
  return '#7b2d8b';
}

// ─── SCREEN NAVIGATION ───────────────────────────────────────────────
function goTo(screenId) {
  document.querySelectorAll('.screen').forEach(s => s.classList.remove('active'));
  document.getElementById(screenId).classList.add('active');
  // Hide status bar for auth screens, show for app screens
  const isApp = ['screen-home','screen-map','screen-settings'].includes(screenId);
  document.getElementById('status-bar').style.display = '';
}

function goToApp() {
  switchTab('home');
}

function switchTab(tab) {
  const map = { home: 'screen-home', map: 'screen-map', settings: 'screen-settings' };
  goTo(map[tab] || 'screen-home');
}

// ─── POPULATE POLLUTANTS GRID ─────────────────────────────────────────
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
      </div>
    `;
  }).join('');
}

// ─── POPULATE HOURLY TREND ────────────────────────────────────────────
function renderTrend() {
  const scroll = document.getElementById('trend-scroll');
  if (!scroll) return;
  scroll.innerHTML = hourlyData.map(h => `
    <div class="trend-item ${h.now ? 'now' : ''}">
      <div class="trend-time">${h.time}</div>
      <div class="trend-aqi-val">${h.aqi}</div>
      <div class="trend-dot" style="background:${h.now ? 'rgba(255,255,255,0.6)' : aqiColor(h.aqi)}"></div>
    </div>
  `).join('');
}

// ─── MAP STATION SELECT ───────────────────────────────────────────────
function selectStation(name) {
  const s = stations[name];
  if (!s) return;
  document.getElementById('station-name').textContent = name + ' Station';
  document.getElementById('station-loc').textContent = name + ', Pangsinan · just now';
  document.getElementById('station-aqi-val').textContent = s.aqi;

  const sheet = document.querySelector('.map-bottom-sheet');
  sheet.querySelectorAll('.mini-stat').forEach((el, i) => {
    const vals = [s.pm25, s.pm10, s.co, s.no2];
    el.querySelector('.val').textContent = vals[i];
  });

  // Animate
  sheet.style.transform = 'translateY(8px)';
  setTimeout(() => sheet.style.transform = '', 200);
}

// ─── FORM VALIDATION ─────────────────────────────────────────────────

function showError(inputEl, msg) {
  clearError(inputEl);
  inputEl.style.borderColor = '#e05252';
  inputEl.style.background = '#fff5f5';
  const err = document.createElement('div');
  err.className = 'field-error';
  err.textContent = msg;
  inputEl.closest('.form-group').appendChild(err);
}

function clearError(inputEl) {
  inputEl.style.borderColor = '';
  inputEl.style.background = '';
  const existing = inputEl.closest('.form-group').querySelector('.field-error');
  if (existing) existing.remove();
}

function clearAllErrors(screenId) {
  const screen = document.getElementById(screenId);
  screen.querySelectorAll('.field-error').forEach(e => e.remove());
  screen.querySelectorAll('.form-input').forEach(el => {
    el.style.borderColor = '';
    el.style.background = '';
  });
}

function isValidEmail(val) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
}

function handleLogin() {
  clearAllErrors('screen-login');
  const usernameEl = document.querySelector('#screen-login input[type="text"]');
  const passwordEl = document.getElementById('login-pass');
  let valid = true;

  if (!usernameEl.value.trim()) {
    showError(usernameEl, 'Username or email is required.');
    valid = false;
  } else if (!isValidEmail(usernameEl.value.trim())) {
    showError(usernameEl, 'Please enter a valid email address.');
    valid = false;
  }

  if (!passwordEl.value.trim()) {
    showError(passwordEl, 'Password is required.');
    valid = false;
  } else if (passwordEl.value.length < 6) {
    showError(passwordEl, 'Password must be at least 6 characters.');
    valid = false;
  }

  if (valid) goToApp();
}

function handleSignup() {
  clearAllErrors('screen-signup');
  const inputs = document.querySelectorAll('#screen-signup .form-input');
  const fullNameEl = inputs[0];
  const emailEl = inputs[1];
  const passwordEl = document.getElementById('signup-pass');
  let valid = true;

  if (!fullNameEl.value.trim()) {
    showError(fullNameEl, 'Full name is required.');
    valid = false;
  } else if (fullNameEl.value.trim().length < 2) {
    showError(fullNameEl, 'Please enter your full name.');
    valid = false;
  }

  if (!emailEl.value.trim()) {
    showError(emailEl, 'Email is required.');
    valid = false;
  } else if (!isValidEmail(emailEl.value.trim())) {
    showError(emailEl, 'Please enter a valid email address.');
    valid = false;
  }

  if (!passwordEl.value.trim()) {
    showError(passwordEl, 'Password is required.');
    valid = false;
  } else if (passwordEl.value.length < 6) {
    showError(passwordEl, 'Password must be at least 6 characters.');
    valid = false;
  }

  if (valid) goToApp();
}

// ─── PASSWORD TOGGLE ──────────────────────────────────────────────────
function togglePass(id) {
  const input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
}

// ─── CLOCK ────────────────────────────────────────────────────────────
function updateClock() {
  const now = new Date();
  const h = now.getHours().toString().padStart(2,'0');
  const m = now.getMinutes().toString().padStart(2,'0');
  const el = document.querySelector('.status-bar .time');
  if (el) el.textContent = `${h}:${m}`;
}

// ─── INIT ─────────────────────────────────────────────────────────────
renderPollutants();
renderTrend();
updateClock();
setInterval(updateClock, 30000);