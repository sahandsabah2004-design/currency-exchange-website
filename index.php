<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Market Rate</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; background: #f9f4f4; color: #1a1a2e; }
  .app { max-width: 680px; margin: 0 auto; padding: 1.5rem 1rem 2rem; }

  .header { display: flex; align-items: center; gap: 14px; margin-bottom: 2rem; }
  .logo-circle { width: 48px; height: 48px; border-radius: 14px; background: #185FA5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .header-text h1 { font-size: 20px; font-weight: 600; color: #1a1a2e; }
  .header-text p { font-size: 13px; color: #666; margin-top: 2px; }
  .live-badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; background: #e6f9f0; color: #0f6e56; border: 0.5px solid #9fe1cb; display: flex; align-items: center; gap: 5px; }
  .live-dot { width: 7px; height: 7px; border-radius: 50%; background: #1D9E75; display: inline-block; }
  .update-time { font-size: 11px; color: #999; margin-top: 3px; text-align: right; }

  .section-label { font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #888; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
  
  .rates-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 10px; margin-bottom: 1.75rem; }
  .rate-card { background: #e0e0e0; border: 0.5px solid #e0e0e0; border-radius: 12px; padding: 12px 14px; display: flex; flex-direction: column; gap: 4px; }
  .rate-card .rate-value { font-size: 17px; font-weight: 600; color: #1a1a2e; }

  .divider { height: 0.5px; background: #e0e0e0; margin: 1.5rem 0; }

  .converter { background: #fff; border: 0.5px solid #e0e0e0; border-radius: 12px; padding: 1.25rem 1.5rem; }
  .converter-row { display: flex; gap: 10px; align-items: flex-end; margin-bottom: 12px; flex-wrap: wrap; }
  .field { display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 80px; }
  .field input { height: 40px; border: 0.5px solid #ccc; border-radius: 8px; background: #f9f9f9; padding: 0 10px; width: 100%; }

  .custom-select { position: relative; }
  .custom-select-trigger { height: 40px; border: 0.5px solid #ccc; border-radius: 8px; background: #f9f9f9; padding: 0 30px 0 10px; cursor: pointer; display: flex; align-items: center; gap: 8px; }
  .custom-dropdown { position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: #fff; border-radius: 8px; display: none; z-index: 999; }
  .custom-dropdown.open { display: block; }
  .dropdown-option { display: flex; align-items: center; gap: 10px; padding: 9px 12px; cursor: pointer; }

  .swap-btn { height: 40px; width: 40px; border: 0.5px solid #ccc; border-radius: 8px; background: #f9f9f9; cursor: pointer; display: flex; align-items: center; justify-content: center; }
  .convert-btn { width: 100%; height: 42px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }

  .result-box { margin-top: 1rem; border-top: 0.5px solid #e0e0e0; padding-top: 1rem; display: none; }
  .result-box.show { display: block; }
  .result-main { font-size: 20px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

  .refresh-btn { font-size: 12px; color: #888; background: none; border: none; cursor: pointer; }

  .footer-badges { display: flex; gap: 6px; margin-top: 1.5rem; }
  .badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; background: #f0f0f0; color: #666; }
</style>
</head>
<body>
<div class="app">

  <div class="header">
    <div class="logo-circle">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
        <line x1="12" y1="2" x2="12" y2="22"/>
        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
      </svg>
    </div>
    <div class="header-text">
      <h1>Market Rate</h1>
      <p>Live currency exchange rates</p>
    </div>
    <div style="margin-left:auto; display:flex; flex-direction:column; align-items:flex-end;">
      <span class="live-badge"><span class="live-dot"></span> Live</span>
      <div class="update-time" id="updateTime"></div>
    </div>
  </div>

  <div class="section-label"><i class="ti ti-chart-bar"></i> 100 USD rates</div>
  <div class="refresh-row">
    <button class="refresh-btn" onclick="loadRates()"><i class="ti ti-refresh"></i> Refresh</button>
  </div>
  <div class="rates-grid" id="ratesGrid">
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/iq.png" alt="IQ"></div>
      <div class="currency-code">IQD</div>
      <div class="rate-value" id="init-IQD">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/tr.png" alt="TR"></div>
      <div class="currency-code">TRY</div>
      <div class="rate-value" id="init-TRY">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/ir.png" alt="IR"></div>
      <div class="currency-code">IRR</div>
      <div class="rate-value" id="init-IRR">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/eu.png" alt="EU"></div>
      <div class="currency-code">EUR</div>
      <div class="rate-value" id="init-EUR">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/gb.png" alt="GB"></div>
      <div class="currency-code">GBP</div>
      <div class="rate-value" id="init-GBP">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
  </div>

  <div class="divider"></div>

  <div class="section-label" style="margin-bottom:12px;"><i class="ti ti-arrows-exchange"></i> Convert</div>
  <div class="converter">
    <div class="converter-row">
      <div class="field">
        <label>Amount</label>
        <input type="number" id="amount" placeholder="0.00" min="0" step="any">
      </div>
      <div class="field" style="max-width:150px;">
        <label>From</label>
        <div class="custom-select" id="select-from"></div>
      </div>
      <button class="swap-btn" onclick="swapCurrencies()" title="Swap">
        <i class="ti ti-arrows-exchange-2"></i>
      </button>
      <div class="field" style="max-width:150px;">
        <label>To</label>
        <div class="custom-select" id="select-to"></div>
      </div>
    </div>
    <button class="convert-btn" onclick="convert()">
      <i class="ti ti-calculator"></i> Convert
    </button>
    <div class="result-box" id="resultBox">
      <div class="result-main" id="resultMain"></div>
      <div class="result-sub" id="resultSub"></div>
    </div>
  </div>

  <div class="footer-badges">
    <span class="badge"><i class="ti ti-map-pin"></i> Iraq</span>
    <span class="badge"><i class="ti ti-shield-check"></i> Market rates</span>
    <span class="badge"><i class="ti ti-clock"></i> Updated live</span>
  </div>

</div>

<script>
const CURRENCIES = [
  { code: 'USD', name: 'US Dollar',      flag: 'us' },
  { code: 'IQD', name: 'Iraqi Dinar',    flag: 'iq' },
  { code: 'TRY', name: 'Turkish Lira',   flag: 'tr' },
  { code: 'IRR', name: 'Iranian Rial',   flag: 'ir' },
  { code: 'EUR', name: 'Euro',           flag: 'eu' },
  { code: 'GBP', name: 'British Pound',  flag: 'gb' },
];

const RATE_CURRENCIES = ['IQD', 'TRY', 'IRR', 'EUR', 'GBP'];

function flagUrl(flagCode) {
  return `https://flagcdn.com/24x18/${flagCode}.png`;
}

function getCurrency(code) {
  return CURRENCIES.find(c => c.code === code);
}

const selectState = { from: 'USD', to: 'IQD' };

function buildSelect(containerId, selectedCode, onChange) {
  const container = document.getElementById(containerId);
  container.innerHTML = ''; 

  const cur = getCurrency(selectedCode);

  const trigger = document.createElement('div');
  trigger.className = 'custom-select-trigger';
  trigger.innerHTML = `
    <img src="${flagUrl(cur.flag)}" alt="${cur.code}">
    <span>${cur.code}</span>
    <span style="color:#aaa; font-weight:400; font-size:12px;">${cur.name}</span>
    <i class="ti ti-chevron-down arrow"></i>`;

  const dropdown = document.createElement('div');
  dropdown.className = 'custom-dropdown';

  CURRENCIES.forEach(c => {
    const opt = document.createElement('div');
    opt.className = 'dropdown-option' + (c.code === selectedCode ? ' selected' : '');
    opt.innerHTML = `
      <img src="${flagUrl(c.flag)}" alt="${c.code}">
      <span class="opt-code">${c.code}</span>
      <span class="opt-name">${c.name}</span>`;
    opt.addEventListener('click', () => {
      onChange(c.code);      
      dropdown.classList.remove('open');
      trigger.classList.remove('open');
    });
    dropdown.appendChild(opt);
  });

  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = dropdown.classList.contains('open');
    closeAllDropdowns();      
    if (!isOpen) {
      dropdown.classList.add('open');
      trigger.classList.add('open');
    }
  });

  container.appendChild(trigger);
  container.appendChild(dropdown);
}

function closeAllDropdowns() {
  document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
  document.querySelectorAll('.custom-select-trigger').forEach(t => t.classList.remove('open'));
}

document.addEventListener('click', closeAllDropdowns);

function buildFromSelect(code) {
  selectState.from = code || selectState.from;
  buildSelect('select-from', selectState.from, (c) => buildFromSelect(c));
}
function buildToSelect(code) {
  selectState.to = code || selectState.to;
  buildSelect('select-to', selectState.to, (c) => buildToSelect(c));
}

function formatRate(val) {
  const n = parseFloat(val);
  if (isNaN(n)) return '—';
  if (n > 10000) return n.toLocaleString(undefined, { maximumFractionDigits: 0 });
  if (n > 100)   return n.toLocaleString(undefined, { maximumFractionDigits: 2 });
  return n.toLocaleString(undefined, { maximumFractionDigits: 4 });
}

function updateTime() {
  document.getElementById('updateTime').textContent =
    new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function loadRates() {
  updateTime();
  RATE_CURRENCIES.forEach(c => {
    const el = document.getElementById('init-' + c);
    if (el) el.textContent = '…';  
    fetch(`convert.php?amount=100&from=USD&to=${c}`)
      .then(r => r.json())
      .then(d => {
        const el2 = document.getElementById('init-' + c);
        if (el2) el2.textContent = formatRate(d.result);
      })
      .catch(() => {
        const el2 = document.getElementById('init-' + c);
        if (el2) el2.textContent = '—';
      });
  });
}

function swapCurrencies() {
  const tmp = selectState.from;
  buildFromSelect(selectState.to);
  buildToSelect(tmp);
}

function convert() {
  const a    = document.getElementById('amount').value;   
  const f    = selectState.from;                                                    
  const t    = selectState.to;                                                      
  const box  = document.getElementById('resultBox');
  const main = document.getElementById('resultMain');
  const sub  = document.getElementById('resultSub');

  if (!a || isNaN(a) || parseFloat(a) <= 0) {
    main.innerHTML = 'Please enter a valid amount.';
    sub.textContent = '';
    box.classList.add('show');
    return;
  }

  main.innerHTML = 'Converting…';
  sub.textContent = '';
  box.classList.add('show');

  fetch(`convert.php?amount=${a}&from=${f}&to=${t}`)
    .then(r => r.json())
    .then(d => {
      const fc = getCurrency(f);
      const tc = getCurrency(t);
      main.innerHTML = `
        <img src="${flagUrl(fc.flag)}" alt="${f}"> ${parseFloat(a).toLocaleString()} ${f}
        &nbsp;=&nbsp;
        <img src="${flagUrl(tc.flag)}" alt="${t}"> ${formatRate(d.result)} ${t}`;
      sub.textContent = `1 ${f} = ${formatRate(d.result / a)} ${t}`;
    })
    .catch(() => {
      main.textContent = 'Error fetching rate. Please try again.';
    });
}

buildFromSelect();
buildToSelect();
loadRates();
</script>
</body>
</html>
