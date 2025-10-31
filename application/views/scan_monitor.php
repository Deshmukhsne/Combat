<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Real-time Check-ins — UWS CATS</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap + icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- jsPDF + html2canvas for PDF export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

  <!-- confetti lib -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

  <style>
    :root{
      --saffron:#ff9933; --leaf:#137a3f; --indigo:#0b3d91; --muted:#c7c9c6;
    }
    html,body{height:100%}
    body{
      margin:0;
      background: linear-gradient(180deg,#04102b 0%, rgba(11,61,145,0.18) 45%, #031028 100%);
      font-family: "Inter", "Poppins", system-ui;
      color:#fff;
      padding:16px;
      -webkit-font-smoothing:antialiased;
    }
    .hero{display:flex;gap:1rem;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-bottom:18px;}
    .logo { width:64px; height:64px; border-radius:12px; background:linear-gradient(135deg,var(--saffron),var(--leaf)); display:flex;align-items:center;justify-content:center;font-weight:800;color:#fff;font-size:20px; box-shadow: 0 10px 30px rgba(0,0,0,0.6);}
    .title { font-weight:800; font-size:1.18rem; letter-spacing:0.4px; font-family:"Poppins",sans-serif; }
    .subtitle { color:var(--muted); font-size:.88rem; margin-top:2px; }

    .monitor-wrap { display:flex; gap:18px; align-items:flex-start; }
    .left { flex:1 1 720px; min-width:280px; }
    .right { width:360px; min-width:260px; }

    .card.monitor { background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.012)); border:1px solid rgba(255,255,255,0.06); border-radius:12px; padding:12px; box-shadow: 0 12px 40px rgba(0,0,0,0.45); }
    .controls { display:flex; gap:8px; align-items:center; margin-bottom:8px; flex-wrap:wrap; }
    .controls .form-control { background: rgba(255,255,255,0.03); color:#fff; border:1px solid rgba(255,255,255,0.04); }
    .controls .btn { border-radius:8px; }

    table.scans { width:100%; border-collapse:collapse; }
    table.scans thead th { color:var(--muted); text-align:left; font-weight:700; padding:12px 10px; font-size:.85rem; border-bottom: 1px dashed rgba(255,255,255,0.04); }

    table.scans tbody tr {
      background: linear-gradient(90deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00));
      border-radius:8px;
      transition: transform .22s ease, box-shadow .22s ease;
      position:relative;
      overflow:hidden;
      margin-bottom:10px;
    }
    table.scans tbody tr:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.45); }
    table.scans td { padding:12px 10px; color:#111; vertical-align:middle; font-size:.95rem; }

    .name-wrap { display:flex; align-items:center; gap:10px; }
    .name-accent { width:6px; height:36px; border-radius:6px; background: linear-gradient(180deg,var(--indigo),var(--leaf)); flex-shrink:0; }
    .name-text { font-weight:700; color:#061226; font-size:1rem; font-family:"Poppins",sans-serif; }
    .name-sub { font-size:0.85rem; color: #5b5b5b; margin-top:4px; }

    .chip { padding:6px 10px; border-radius:999px; font-weight:700; font-size:.85rem; color:#fff; display:inline-block; min-width:74px; text-align:center; }
    .chip.valid { background: linear-gradient(90deg,#16a34a,#34d399); box-shadow:0 8px 20px rgba(52,211,153,0.06); }
    .chip.invalid { background: linear-gradient(90deg,#ff5f43,#ffb199); box-shadow:0 8px 20px rgba(255,95,67,0.06); }

    .qr-btn { background:rgba(255,255,255,0.02); color:#fff; border:1px solid rgba(255,255,255,0.04); padding:.55rem .8rem; border-radius:8px; font-weight:700; transition: transform .18s ease, box-shadow .18s ease; }
    .qr-btn:hover { transform: translateY(-3px); box-shadow:0 8px 18px rgba(0,0,0,0.4); }

    .mobile-only { display:none; }
    .row-card { display:flex; gap:12px; align-items:center; padding:12px; border-radius:10px; background: linear-gradient(90deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); margin-bottom:10px; transition: transform .22s cubic-bezier(.2,.9,.3,1), box-shadow .22s ease; }
    .avatar { width:64px; height:64px; border-radius:12px; display:flex;align-items:center;justify-content:center; font-weight:800;color:#fff;font-size:20px; background:linear-gradient(135deg,var(--indigo),var(--leaf)); box-shadow:0 10px 30px rgba(0,0,0,0.45); flex-shrink:0; }
    .meta .name { font-weight:800; color:#fff; font-size:1rem; font-family:"Poppins",sans-serif; }
    .meta .small { color:var(--muted); font-size:.85rem; margin-top:4px; }

    .name-divider { height:1px; background: linear-gradient(90deg, rgba(255,255,255,0.02), rgba(255,255,255,0)); margin:10px 0; border-radius:2px; }
    .underline-anim { height:3px; width:0%; background: linear-gradient(90deg,var(--saffron),var(--leaf)); border-radius:4px; transition: width .45s cubic-bezier(.2,.9,.3,1); }
    .row-card:hover .underline-anim, table.scans tbody tr:hover .underline-anim { width:72%; }

    .stat { display:flex; align-items:center; gap:12px; padding:12px; border-radius:10px; background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); margin-bottom:12px; }
    .stat .num { font-size:1.6rem; font-weight:800; color:#fff; }
    .stat .lbl { color:var(--muted); }

    .qr-modal .modal-content { background: transparent; border: none; box-shadow:none; }
    .qr-modal .modal-body { padding:0; display:flex; align-items:center; justify-content:center; }
    .qr-modal img { width: min(90vw, 420px); height: auto; border-radius:10px; box-shadow:0 14px 44px rgba(0,0,0,0.6) }

    @media (min-width: 900px) { .mobile-only { display:none !important; } }
    @media (max-width: 899px) { .desktop-only { display:none !important; } .right { display:none; } .monitor-wrap { flex-direction:column; } .qr-btn{ padding:.6rem .95rem; } .avatar{width:56px;height:56px;font-size:18px;} .name-text{font-size:0.98rem;} }
  </style>
</head>
<body>

  <div class="hero">
    <div style="display:flex;gap:12px;align-items:center;">
      <div class="logo">UWS</div>
      <div>
        <div class="title">UWS — <span style="color:var(--saffron)">CATS</span> Check-in Monitor</div>
        <div class="subtitle">Live scan feed — name, masked Aadhaar, phone & entry time</div>
      </div>
    </div>

    <div class="live-pill">
      <div style="width:12px;height:12px;border-radius:50%;background:#34d399;box-shadow:0 0 10px rgba(52,211,153,0.6);"></div>
      <div style="margin-left:8px;text-align:right;">
        <div style="font-weight:700">LIVE</div>
        <div id="lastUpdate" style="color:var(--muted); font-size:.85rem">Last update: —</div>
      </div>
    </div>
  </div>

  <div class="monitor-wrap">
    <div class="left">
      <div class="card monitor">
        <div class="controls mb-2">
          <input id="qFilter" class="form-control form-control-sm" placeholder="Filter by name / aadhaar / phone" style="min-width:220px">
          <select id="resultFilter" class="form-control form-control-sm" style="max-width:140px">
            <option value="">All results</option>
            <option value="valid">Valid</option>
            <option value="invalid">Invalid</option>
          </select>

          <button id="refreshBtn" class="btn btn-sm btn-outline-light"><i class="fa fa-sync"></i> Refresh</button>
          <button id="exportPdf" class="btn btn-sm btn-outline-light"><i class="fa fa-file-pdf"></i> Export PDF</button>

          <div style="margin-left:auto; display:flex; gap:8px; align-items:center;">
            <div style="color:var(--muted); font-size:.86rem;">Showing: <span id="showingCount">—</span></div>
          </div>
        </div>

        <!-- TABLE for large screens -->
        <div class="desktop-only" style="overflow:auto; max-height:65vh;">
          <table class="scans" id="scansTable">
            <thead>
              <tr>
                <th style="width:150px">Time</th>
                <th>Name</th>
                <th style="width:150px">Aadhaar (last 4)</th>
                <th style="width:140px">Phone</th>
                <th style="width:120px">Result</th>
                <th style="width:120px">QR</th>
              </tr>
            </thead>
            <tbody id="scansBody">
              <!-- rows injected here -->
            </tbody>
          </table>
        </div>

        <!-- MOBILE card list -->
        <div class="mobile-only" id="mobileList" style="max-height:65vh; overflow:auto; padding-top:6px;">
          <!-- injected -->
        </div>
      </div>
    </div>

    <div class="right">
      <div class="card monitor stats p-3">
        <div class="stat">
          <div>
            <div class="num" id="statTotal">—</div>
            <div class="lbl">Total scans (recent)</div>
          </div>
        </div>
        <div class="stat">
          <div>
            <div class="num" id="statValid">—</div>
            <div class="lbl">Valid</div>
          </div>
        </div>
        <div class="stat">
          <div>
            <div class="num" id="statInvalid">—</div>
            <div class="lbl">Invalid</div>
          </div>
        </div>

        <div style="margin-top:12px;">
          <button class="btn btn-ghost btn-sm qr-btn w-100" id="clearSeen">Mark current as seen</button>
        </div>
      </div>
    </div>
  </div>

  <!-- QR Modal -->
  <div class="modal fade qr-modal" id="qrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center p-0">
          <img id="qrImage" src="" alt="QR code preview">
        </div>
      </div>
    </div>
  </div>

  <!-- audio chime (small beep) -->
  <audio id="chimeSound" preload="auto">
    <source src="<?php echo base_url('assets/sounds/chime.mp3'); ?>" type="audio/mpeg">
  </audio>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // --- Configuration ---
    const endpoint = '<?php echo site_url("scan-monitor/latest_scans"); ?>';
    const pollInterval = 3000; // ms
    let lastSeenId = parseInt(localStorage.getItem('lastSeenScanId') || 0, 10);
    let knownIds = new Set();

    // Helper: format scanned time (assumes DB string like "YYYY-MM-DD HH:MM:SS")
    function displayTime(iso) {
      try {
        // treat input as local time string (no timezone); create Date safely
        const parts = iso.split(' ');
        if (parts.length === 2) {
          const dParts = parts[0].split('-').map(Number);
          const tParts = parts[1].split(':').map(Number);
          const dt = new Date(dParts[0], dParts[1]-1, dParts[2], tParts[0], tParts[1], tParts[2]);
          return dt.toLocaleString();
        }
        return iso;
      } catch (e) { return iso; }
    }

    // Template: desktop row (fixed correct column order)
    function desktopRow(item) {
      const resultClass = (String(item.result).toLowerCase() === 'valid') ? 'chip valid' : 'chip invalid';
      const isNew = (item.scan_id > lastSeenId);
      return `
        <tr data-id="${item.scan_id}" class="${isNew ? 'new' : ''}">
          <td>${displayTime(item.scanned_at)}</td>
          <td>
            <div class="name-wrap">
              <div class="name-accent" aria-hidden="true"></div>
              <div>
                <div class="name-text">${escapeHtml(item.name || '—')}</div>
                <div class="name-sub">${item.scanner ? 'Scanner: '+escapeHtml(item.scanner) : ''}</div>
                <div class="name-divider"></div>
                <div class="underline-anim"></div>
              </div>
            </div>
          </td>
          <td>${escapeHtml(item.aadhaar_masked || '—')}</td>
          <td>${escapeHtml(item.phone || '—')}</td>
          <td><div class="${resultClass}">${escapeHtml(capitalize(item.result || 'unknown'))}</div></td>
          <td><button class="qr-btn" data-qr="${escapeAttr(item.qr_code_file || '')}" ${item.qr_code_file ? '' : 'disabled'}>Open QR</button></td>
        </tr>
      `;
    }

    // Template: mobile card
    function mobileCard(item) {
      const resultClass = (String(item.result).toLowerCase() === 'valid') ? 'chip valid' : 'chip invalid';
      const initial = (item.name ? item.name.charAt(0).toUpperCase() : 'U');
      const isNewCls = (item.scan_id > lastSeenId) ? 'new' : '';
      return `
        <div class="row-card ${isNewCls}" data-id="${item.scan_id}">
          <div class="avatar">${escapeHtml(initial)}</div>
          <div class="meta">
            <div class="title-line">
              <div class="name">${escapeHtml(item.name || '—')} <small style="color:var(--muted); font-weight:600; margin-left:6px;">#${item.registration_id || ''}</small></div>
              <div><div class="${resultClass}">${escapeHtml(capitalize(item.result || 'unknown'))}</div></div>
            </div>
            <div class="small">${displayTime(item.scanned_at)} • ${escapeHtml(item.scanner || '-')}</div>
            <div class="name-divider"></div>
            <div style="display:flex; gap:10px; align-items:center; margin-top:8px;">
              <div style="color:var(--muted); font-weight:700;">${escapeHtml(item.aadhaar_masked || '')}</div>
              <div style="margin-left:auto;">
                <button class="qr-btn" data-qr="${escapeAttr(item.qr_code_file || '')}" ${item.qr_code_file ? '' : 'disabled'}>Open QR</button>
              </div>
            </div>
            <div class="underline-anim" style="margin-top:8px;"></div>
          </div>
        </div>
      `;
    }

    // Render list into DOM
    function renderList(arr) {
      const $body = $('#scansBody');
      const $mobile = $('#mobileList');
      $body.empty();
      $mobile.empty();

      let total = 0, valid = 0, invalid = 0;

      arr.forEach(it => {
        $body.append(desktopRow(it));
        $mobile.append(mobileCard(it));
        total++;
        if (String(it.result).toLowerCase() === 'valid') valid++; else invalid++;
      });

      $('#statTotal').text(total);
      $('#statValid').text(valid);
      $('#statInvalid').text(invalid);
      $('#showingCount').text(total);
      $('#lastUpdate').text('Last update: ' + new Date().toLocaleString());

      // attach QR click
      $('.qr-btn').off('click').on('click', function(){
        const qr = $(this).data('qr');
        if (!qr) return;
        $('#qrImage').attr('src', qr);
        const modal = new bootstrap.Modal(document.getElementById('qrModal'));
        modal.show();
      });

      // Play chime + confetti for newly-arrived valid scans
      // detect items that are new (not knownIds)
      const newValid = arr.filter(it => (it.scan_id && !knownIds.has(it.scan_id) && String(it.result).toLowerCase() === 'valid'));
      newValid.forEach(triggerCelebration);

      // update knownIds and lastSeenId
      arr.forEach(it => { if (it.scan_id) knownIds.add(Number(it.scan_id)); });
      const ids = Array.from(knownIds);
      if (ids.length) {
        const maxId = Math.max.apply(null, ids);
        if (maxId > lastSeenId) {
          lastSeenId = maxId;
          localStorage.setItem('lastSeenScanId', lastSeenId);
        }
      }
    }

    // play chime + confetti (non-blocking)
    function triggerCelebration(item) {
      try {
        // play chime
        const chime = document.getElementById('chimeSound');
        if (chime) {
          chime.currentTime = 0;
          chime.play().catch(()=>{/* ignore autoplay block */});
        }

        // confetti burst
        confetti({
          particleCount: 60,
          spread: 70,
          origin: { y: 0.3 },
          colors: ['#16a34a','#34d399','#ff9933']
        });
      } catch(e){ console.warn('celebration failed', e); }
    }

    // Fetch scans from server
    function fetchScans() {
      $.getJSON(endpoint, { limit: 200 })
        .done(function(res){
          if (!res || !res.success) return;
          renderList(res.data || []);
        }).fail(function(){ console.error('Failed to fetch scans.'); });
    }

    // Export visible list to PDF
    async function exportPdf() {
      // We'll capture the desktop table or mobile list container and create a PDF.
      const captureEl = document.querySelector('.card.monitor');
      if (!captureEl) return alert('Nothing to export.');

      const originalScale = document.body.style.transform || '';
      // increase scale for crisp capture on small screens
      document.body.style.transform = 'scale(1)';
      try {
        const canvas = await html2canvas(captureEl, { useCORS: true, scale: 2, scrollY: -window.scrollY });
        const imgData = canvas.toDataURL('image/png');
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgProps = pdf.getImageProperties(imgData);
        const imgWidth = pageWidth - 20; // margins
        const imgHeight = (imgProps.height * imgWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        const ts = new Date().toISOString().replace(/[:.]/g,'-');
        pdf.save('checkins-' + ts + '.pdf');
      } catch (e) {
        console.error('Export failed', e);
        alert('Export failed: ' + (e.message || e));
      } finally {
        document.body.style.transform = originalScale;
      }
    }

    // small helpers
    function escapeHtml(s){ if(!s) return ''; return String(s).replace(/[&<>"']/g, function(m){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]; }); }
    function escapeAttr(s){ return escapeHtml(s).replace(/"/g,'&quot;'); }
    function capitalize(s){ if(!s) return ''; s = String(s); return s.charAt(0).toUpperCase() + s.slice(1); }

    // filter UI interactions
    $(function(){
      // initial fetch
      fetchScans();
      setInterval(fetchScans, pollInterval);

      $('#refreshBtn').on('click', fetchScans);
      $('#exportPdf').on('click', exportPdf);

      $('#qFilter').on('input', function(){
        const q = $(this).val().toLowerCase();
        $('#scansBody tr, #mobileList .row-card').each(function(){
          $(this).toggle(q === '' || $(this).text().toLowerCase().indexOf(q) > -1);
        });
      });

      $('#resultFilter').on('change', function(){
        const val = $(this).val();
        $('#scansBody tr, #mobileList .row-card').each(function(){
          if (!val) $(this).show(); else $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
        });
      });

      $('#clearSeen').on('click', function(){
        // mark all known IDs as seen
        const ids = $('#scansBody tr').map(function(){ return parseInt($(this).data('id'),10) || 0; }).get();
        if (ids.length) {
          const maxId = Math.max.apply(null, ids);
          lastSeenId = maxId;
          localStorage.setItem('lastSeenScanId', lastSeenId);
          $('#scansBody tr, #mobileList .row-card').removeClass('new');
        }
      });

      // initialize knownIds from server (optional: first fetch will populate)
      // knownIds is updated on renderList
    });
  </script>
</body>
</html>