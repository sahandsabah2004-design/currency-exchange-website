<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Market Rate</title>
<!-- بارکردنی فۆنت و ئایکۆنەکانی تابڵەر -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
  /* ڕێکخستنی بنەڕەتی بۆ هەموو توخمەکان */
  * { box-sizing: border-box; margin: 0; padding: 0; }
  /* شێوازی پەڕەکە */
  body { font-family: Arial, sans-serif; background: #f9f4f4; color: #1a1a2e; }
  /* کانتەینەری سەرەکی، ماکسیمم پانی 680px و ناوەڕاست */
  .app { max-width: 680px; margin: 0 auto; padding: 1.5rem 1rem 2rem; }

  /* ستایلی هێدەر: لۆگۆ و ناونیشان */
  .header { display: flex; align-items: center; gap: 14px; margin-bottom: 2rem; }
  /* چوارگۆشەی شین بۆ لۆگۆ */
  .logo-circle { width: 48px; height: 48px; border-radius: 14px; background: #185FA5; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  /* ناونیشانی سەرەکی */
  .header-text h1 { font-size: 20px; font-weight: 600; color: #1a1a2e; }
  /* وەسفی ژێر ناونیشان */
  .header-text p { font-size: 13px; color: #666; margin-top: 2px; }
  /* بەیجی ڕاستەوخۆ (Live) */
  .live-badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; background: #e6f9f0; color: #0f6e56; border: 0.5px solid #9fe1cb; display: flex; align-items: center; gap: 5px; }
  /* خاڵی سەوزی ڕاستەوخۆ */
  .live-dot { width: 7px; height: 7px; border-radius: 50%; background: #1D9E75; display: inline-block; }
  /* کاتی نوێکردنەوە */
  .update-time { font-size: 11px; color: #999; margin-top: 3px; text-align: right; }

  /* ستایلی سەرنووسەکانی بەشەکان */
  .section-label { font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: #888; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
  
  /* گریدی کارتەکانی نرخ */
  .rates-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(110px, 1fr)); gap: 10px; margin-bottom: 1.75rem; }
  /* کارتی نرخ */
  .rate-card { background: #e0e0e0; border: 0.5px solid #e0e0e0; border-radius: 12px; padding: 12px 14px; display: flex; flex-direction: column; gap: 4px; }
  /* نرخی سەرەکی لەناو کارتەکەدا */
  .rate-card .rate-value { font-size: 17px; font-weight: 600; color: #1a1a2e; }

  /* هێڵی جیاکەرەوە */
  .divider { height: 0.5px; background: #e0e0e0; margin: 1.5rem 0; }

  /* بەشی گۆڕینی دراو */
  .converter { background: #fff; border: 0.5px solid #e0e0e0; border-radius: 12px; padding: 1.25rem 1.5rem; }
  /* ڕیزی فۆرمەکە */
  .converter-row { display: flex; gap: 10px; align-items: flex-end; margin-bottom: 12px; flex-wrap: wrap; }
  /* هەر خانەیەکی فۆرم */
  .field { display: flex; flex-direction: column; gap: 6px; flex: 1; min-width: 80px; }
  /* خانەی داخڵکردنی ژمارە */
  .field input { height: 40px; border: 0.5px solid #ccc; border-radius: 8px; background: #f9f9f9; padding: 0 10px; width: 100%; }

  /* دراپداون (هەڵبژاردنی دراو)ی تایبەت */
  .custom-select { position: relative; }
  /* دوگمەی کرانەوەی دراپداون */
  .custom-select-trigger { height: 40px; border: 0.5px solid #ccc; border-radius: 8px; background: #f9f9f9; padding: 0 30px 0 10px; cursor: pointer; display: flex; align-items: center; gap: 8px; }
  /* لیستی داخڵی دراپداون */
  .custom-dropdown { position: absolute; top: calc(100% + 4px); left: 0; right: 0; background: #fff; border-radius: 8px; display: none; z-index: 999; }
  .custom-dropdown.open { display: block; }
  /* هەر هەڵبژاردنێک لەناو لیستەکەدا */
  .dropdown-option { display: flex; align-items: center; gap: 10px; padding: 9px 12px; cursor: pointer; }

  /* دوگمەی ئاڵوگۆڕی دراوەکان (Swap) */
  .swap-btn { height: 40px; width: 40px; border: 0.5px solid #ccc; border-radius: 8px; background: #f9f9f9; cursor: pointer; display: flex; align-items: center; justify-content: center; }
  /* دوگمەی گۆڕین (Convert) */
  .convert-btn { width: 100%; height: 42px; background: #185FA5; color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }

  /* سندووقی پیشاندانی ئەنجام */
  .result-box { margin-top: 1rem; border-top: 0.5px solid #e0e0e0; padding-top: 1rem; display: none; }
  .result-box.show { display: block; }
  /* ئەنجامی سەرەکی */
  .result-main { font-size: 20px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

  /* دوگمەی نوێکردنەوە */
  .refresh-btn { font-size: 12px; color: #888; background: none; border: none; cursor: pointer; }

  /* بەیجەکانی پێچەوانە */
  .footer-badges { display: flex; gap: 6px; margin-top: 1.5rem; }
  .badge { font-size: 11px; padding: 3px 10px; border-radius: 20px; background: #f0f0f0; color: #666; }
</style>
</head>
<body>
<div class="app">

  <!-- ================= هێدەر ================= -->
  <div class="header">
    <!-- لۆگۆی شێوە دراوی -->
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
    <!-- بەیجی ڕاستەوخۆ و کات -->
    <div style="margin-left:auto; display:flex; flex-direction:column; align-items:flex-end;">
      <span class="live-badge"><span class="live-dot"></span> Live</span>
      <div class="update-time" id="updateTime"></div>
    </div>
  </div>

  <!-- ================= بەشی نرخی 100 دۆلار ================= -->
  <div class="section-label"><i class="ti ti-chart-bar"></i> 100 USD rates</div>
  <div class="refresh-row">
    <button class="refresh-btn" onclick="loadRates()"><i class="ti ti-refresh"></i> Refresh</button>
  </div>
  <div class="rates-grid" id="ratesGrid">
    <!-- کارتی IQD -->
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/iq.png" alt="IQ"></div>
      <div class="currency-code">IQD</div>
      <div class="rate-value" id="init-IQD">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <!-- کارتی TRY -->
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/tr.png" alt="TR"></div>
      <div class="currency-code">TRY</div>
      <div class="rate-value" id="init-TRY">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <!-- کارتی IRR -->
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/ir.png" alt="IR"></div>
      <div class="currency-code">IRR</div>
      <div class="rate-value" id="init-IRR">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <!-- کارتی EUR -->
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/eu.png" alt="EU"></div>
      <div class="currency-code">EUR</div>
      <div class="rate-value" id="init-EUR">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
    <!-- کارتی GBP -->
    <div class="rate-card">
      <div class="flag"><img src="https://flagcdn.com/24x18/gb.png" alt="GB"></div>
      <div class="currency-code">GBP</div>
      <div class="rate-value" id="init-GBP">—</div>
      <div class="rate-label">per 100 USD</div>
    </div>
  </div>

  <div class="divider"></div>

  <!-- ================= بەشی گۆڕینی دراو ================= -->
  <div class="section-label" style="margin-bottom:12px;"><i class="ti ti-arrows-exchange"></i> Convert</div>
  <div class="converter">
    <div class="converter-row">
      <!-- خانەی بڕی پارە -->
      <div class="field">
        <label>Amount</label>
        <input type="number" id="amount" placeholder="0.00" min="0" step="any">
      </div>
      <!-- هەڵبژاردنی دراوی سەرچاوە (From) -->
      <div class="field" style="max-width:150px;">
        <label>From</label>
        <div class="custom-select" id="select-from"></div>
      </div>
      <!-- دوگمەی ئاڵوگۆڕی دراوەکان -->
      <button class="swap-btn" onclick="swapCurrencies()" title="Swap">
        <i class="ti ti-arrows-exchange-2"></i>
      </button>
      <!-- هەڵبژاردنی دراوی ئامانج (To) -->
      <div class="field" style="max-width:150px;">
        <label>To</label>
        <div class="custom-select" id="select-to"></div>
      </div>
    </div>
    <!-- دوگمەی گۆڕین -->
    <button class="convert-btn" onclick="convert()">
      <i class="ti ti-calculator"></i> Convert
    </button>
    <!-- سندووقی پیشاندانی ئەنجام -->
    <div class="result-box" id="resultBox">
      <div class="result-main" id="resultMain"></div>
      <div class="result-sub" id="resultSub"></div>
    </div>
  </div>

  <!-- ================= پێچەوانە ================= -->
  <div class="footer-badges">
    <span class="badge"><i class="ti ti-map-pin"></i> Iraq</span>
    <span class="badge"><i class="ti ti-shield-check"></i> Market rates</span>
    <span class="badge"><i class="ti ti-clock"></i> Updated live</span>
  </div>

</div>

<script>
// ================= داتاکانی دراوەکان =================
// لیستی دراوەکان: کۆد، ناوی تەواو، کۆدی ئاڵا
const CURRENCIES = [
  { code: 'USD', name: 'US Dollar',      flag: 'us' },
  { code: 'IQD', name: 'Iraqi Dinar',    flag: 'iq' },
  { code: 'TRY', name: 'Turkish Lira',   flag: 'tr' },
  { code: 'IRR', name: 'Iranian Rial',   flag: 'ir' },
  { code: 'EUR', name: 'Euro',           flag: 'eu' },
  { code: 'GBP', name: 'British Pound',  flag: 'gb' },
];

// دراوەکانی کە نرخیان بۆ 100 دۆلار نیشان دەدرێت
const RATE_CURRENCIES = ['IQD', 'TRY', 'IRR', 'EUR', 'GBP'];

// بەدەستهێنانی بەستەری وێنەی ئاڵا بەپێی کۆدی وڵات
function flagUrl(flagCode) {
  return `https://flagcdn.com/24x18/${flagCode}.png`;
}

// گەڕان بە دوای دراوێک بە کۆدەکەی لە لیستی CURRENCIES
function getCurrency(code) {
  return CURRENCIES.find(c => c.code === code);
}

// ================= دروستکردنی دراپداونی تایبەت بۆ هەڵبژاردنی دراو =================
// حاڵەتی هەڵبژێردراوی دراوەکان (بنەڕەت: USD بۆ From، IQD بۆ To)
const selectState = { from: 'USD', to: 'IQD' };

// فەنکشنێک بۆ دروستکردنی دراپداون لە ناوەندێکی دیاریکراو
function buildSelect(containerId, selectedCode, onChange) {
  const container = document.getElementById(containerId);
  container.innerHTML = ''; // پاککردنەوەی ناوەڕۆکی پێشوو

  const cur = getCurrency(selectedCode);

  // دروستکردنی دوگمەی کرانەوەی دراپداون
  const trigger = document.createElement('div');
  trigger.className = 'custom-select-trigger';
  trigger.innerHTML = `
    <img src="${flagUrl(cur.flag)}" alt="${cur.code}">
    <span>${cur.code}</span>
    <span style="color:#aaa; font-weight:400; font-size:12px;">${cur.name}</span>
    <i class="ti ti-chevron-down arrow"></i>`;

  // دروستکردنی لیستی داخڵی دراپداون
  const dropdown = document.createElement('div');
  dropdown.className = 'custom-dropdown';

  // بۆ هەر دراوێک لە لیستەکە، هەڵبژاردنێک دروست بکە
  CURRENCIES.forEach(c => {
    const opt = document.createElement('div');
    opt.className = 'dropdown-option' + (c.code === selectedCode ? ' selected' : '');
    opt.innerHTML = `
      <img src="${flagUrl(c.flag)}" alt="${c.code}">
      <span class="opt-code">${c.code}</span>
      <span class="opt-name">${c.name}</span>`;
    // کاتێک کرتە لەسەر هەڵبژاردنێک دەکرێت
    opt.addEventListener('click', () => {
      onChange(c.code);       // بانگکردنی فەنکشنی گۆڕانکاری
      dropdown.classList.remove('open');
      trigger.classList.remove('open');
    });
    dropdown.appendChild(opt);
  });

  // کرتەکردن لەسەر دوگمەکە بۆ کردنەوە/داخستنی لیستەکە
  trigger.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = dropdown.classList.contains('open');
    closeAllDropdowns();      // داخستنی هەموو دراپداونەکانی تر
    if (!isOpen) {
      dropdown.classList.add('open');
      trigger.classList.add('open');
    }
  });

  container.appendChild(trigger);
  container.appendChild(dropdown);
}

// داخستنی هەموو دراپداونە کراوەکان
function closeAllDropdowns() {
  document.querySelectorAll('.custom-dropdown').forEach(d => d.classList.remove('open'));
  document.querySelectorAll('.custom-select-trigger').forEach(t => t.classList.remove('open'));
}

// کاتێک لە شوێنی تر کرتە دەکرێت، دراپداونەکان دابخە
document.addEventListener('click', closeAllDropdowns);

// فەنکشنەکان بۆ دروستکردن و نوێکردنەوەی هەڵبژاردنی From و To
function buildFromSelect(code) {
  selectState.from = code || selectState.from;
  buildSelect('select-from', selectState.from, (c) => buildFromSelect(c));
}
function buildToSelect(code) {
  selectState.to = code || selectState.to;
  buildSelect('select-to', selectState.to, (c) => buildToSelect(c));
}

// ================= کارکردن لەگەڵ نرخەکان =================
// شێوازکردنی نرخی ژمارەیی بۆ پیشاندان (بەپێی گەورەیی)
function formatRate(val) {
  const n = parseFloat(val);
  if (isNaN(n)) return '—';
  if (n > 10000) return n.toLocaleString(undefined, { maximumFractionDigits: 0 });
  if (n > 100)   return n.toLocaleString(undefined, { maximumFractionDigits: 2 });
  return n.toLocaleString(undefined, { maximumFractionDigits: 4 });
}

// نوێکردنەوەی کاتی پیشاندان
function updateTime() {
  document.getElementById('updateTime').textContent =
    new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

// بارکردنی نرخەکان بۆ 100 دۆلار لە فایلی convert.php
function loadRates() {
  updateTime();
  RATE_CURRENCIES.forEach(c => {
    const el = document.getElementById('init-' + c);
    if (el) el.textContent = '…';  // نیشاندانی "..." تا وەڵام بێتەوە
    // ناردنی داواکاری بۆ بەک ئێند
    fetch(`convert.php?amount=100&from=USD&to=${c}`)
      .then(r => r.json())
      .then(d => {
        const el2 = document.getElementById('init-' + c);
        if (el2) el2.textContent = formatRate(d.result);
      })
      .catch(() => {
        // ئەگەر هەڵە ڕوویدا، نیشانی "—" بدە
        const el2 = document.getElementById('init-' + c);
        if (el2) el2.textContent = '—';
      });
  });
}

// ================= ئاڵوگۆڕی دراوەکان (Swap) =================
function swapCurrencies() {
  const tmp = selectState.from;
  buildFromSelect(selectState.to);
  buildToSelect(tmp);
}

// ================= گۆڕینی دراو =================
function convert() {
  const a    = document.getElementById('amount').value;   // بڕی پارە
  const f    = selectState.from;                          // دراوی سەرچاوە
  const t    = selectState.to;                            // دراوی ئامانج
  const box  = document.getElementById('resultBox');
  const main = document.getElementById('resultMain');
  const sub  = document.getElementById('resultSub');

  // پشتڕاستکردنەوەی داخڵکراوی دروست
  if (!a || isNaN(a) || parseFloat(a) <= 0) {
    main.innerHTML = 'Please enter a valid amount.';
    sub.textContent = '';
    box.classList.add('show');
    return;
  }

  // نیشاندانی بارکردن
  main.innerHTML = 'Converting…';
  sub.textContent = '';
  box.classList.add('show');

  // ناردنی داواکاری بۆ بەک ئێند بە پارامەترەکانی amount, from, to
  fetch(`convert.php?amount=${a}&from=${f}&to=${t}`)
    .then(r => r.json())
    .then(d => {
      const fc = getCurrency(f);
      const tc = getCurrency(t);
      // نیشاندانی ئەنجام بە ئاڵاوەکان
      main.innerHTML = `
        <img src="${flagUrl(fc.flag)}" alt="${f}"> ${parseFloat(a).toLocaleString()} ${f}
        &nbsp;=&nbsp;
        <img src="${flagUrl(tc.flag)}" alt="${t}"> ${formatRate(d.result)} ${t}`;
      // نیشاندانی نرخی یەک یەکە بۆ دراوی سەرچاوە
      sub.textContent = `1 ${f} = ${formatRate(d.result / a)} ${t}`;
    })
    .catch(() => {
      main.textContent = 'Error fetching rate. Please try again.';
    });
}

// ================= دەستپێکردن =================
// دروستکردنی هەڵبژاردنەکان و بارکردنی نرخەکان کە پەڕە دەکرێتەوە
buildFromSelect();
buildToSelect();
loadRates();
</script>
</body>
</html>