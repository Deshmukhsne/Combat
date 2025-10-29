<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// helper to mask aadhaar (show last 4 digits)
function mask_aadhaar($aadhaar) {
    $aad = preg_replace('/\D/', '', (string)$aadhaar);
    if (strlen($aad) < 4) return 'XXXX-XXXX-'.substr($aad, -min(4, strlen($aad)));
    return 'XXXX-XXXX-'.substr($aad, -4);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UWS — CATS Registration Dashboard (Army Theme)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    /* Army colour palette */
    :root{
      --army-olive:#3b4b2a;
      --army-dark:#1f2b16;
      --khaki:#c9b77a;
      --accent:#9fb24a;
      --muted:#9aa48a;
      --glass: rgba(255,255,255,0.04);
    }

    body{
      background: linear-gradient(180deg, #0f1310 0%, #162016 60%);
      color: #e6efe1;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      min-height:100vh;
      padding-top:1rem;
    }

    /* subtle camo texture using repeating-radial-gradients */
    .camo-bg{
      background-image:
        radial-gradient(circle at 10% 10%, rgba(63,76,48,0.12) 0%, transparent 15%),
        radial-gradient(circle at 80% 20%, rgba(120,118,80,0.06) 0%, transparent 18%),
        radial-gradient(circle at 40% 70%, rgba(50,60,40,0.07) 0%, transparent 20%);
      background-blend-mode: overlay;
    }

    .top-bar{
      backdrop-filter: blur(6px);
      background: linear-gradient(90deg, rgba(59,75,42,0.12), rgba(25,35,20,0.06));
      border:1px solid rgba(255,255,255,0.03);
      padding: .6rem 1rem;
      border-radius: .6rem;
    }

    .brand-title{font-weight:700; letter-spacing:1px}
    .brand-sub{color:var(--muted); font-size:.85rem}

    /* cards */
    .stat-card{background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.03);}
    .stat-card .value{font-size:1.6rem; font-weight:700}
    .stat-card .label{color:var(--muted); font-size:.85rem}

    /* table style */
    .table thead th{border-bottom:1px solid rgba(255,255,255,0.04); color:#dfe9d8}
    .table tbody tr{border-bottom:1px dashed rgba(255,255,255,0.03)}

    /* airplane animation */
    .sky{
      position: absolute; left:0; right:0; top:0; height:140px; pointer-events:none; overflow:visible;
    }

    .plane{
      position:absolute; width:140px; height:60px; transform:translateY(20px);
      will-change: transform; opacity:.95;
      filter: drop-shadow(0 6px 12px rgba(0,0,0,0.45));
    }

    /* plane path animations - multiple planes with different durations and delays */
    @keyframes fly-right {
      0%{transform: translateX(-20%) translateY(10px) rotate(-6deg); opacity:0}
      10%{opacity:1}
      50%{transform: translateX(50vw) translateY(-6px) rotate(2deg)}
      90%{opacity:1}
      100%{transform: translateX(120vw) translateY(10px) rotate(6deg); opacity:0}
    }

    .plane.p1{top:10px; left:-10%; animation: fly-right 14s linear infinite;}
    .plane.p2{top:60px; left:-20%; animation: fly-right 18s linear infinite; animation-delay:3s; opacity:0.9}
    .plane.p3{top:100px; left:-30%; animation: fly-right 22s linear infinite; animation-delay:7s; opacity:0.85}

    /* subtle floating for clouds/gauges */
    .floaty{ animation: floaty 6s ease-in-out infinite; }
    @keyframes floaty{0%{transform:translateY(0)}50%{transform:translateY(-6px)}100%{transform:translateY(0)}}

    /* animated ribbons */
    .ribbon{height:6px; border-radius:6px; background: linear-gradient(90deg, rgba(159,178,74,0.2), rgba(201,183,122,0.18)); margin-bottom:.8rem}

    /* responsive tweaks */
    @media (max-width:767px){
      .sky{height:90px}
      .plane{width:110px;height:45px}
    }

    /* nice smooth transitions */
    .btn, .form-control { transition: all .18s ease-in-out }
    a{ color:inherit }
  </style>
</head>
<body class="camo-bg">

  <!-- animated sky layer (planes) -->
  <div class="sky">
    <!-- inline SVGs (same as before) -->
  </div>

  <div class="container py-4">
    <div class="top-bar d-flex align-items-center justify-content-between mb-3">
      <div>
        <div class="brand-title">UWS — <span style="color:var(--khaki)">CATS</span> Registration Dashboard</div>
        <div class="brand-sub">Secure QR-based entry & verification • Helicopter Show</div>
      </div>
      <div class="text-end">
        <div class="small text-muted">Module: <strong>Your Module</strong></div>
        <div class="small text-muted">Host: PHP / LAMP-ready</div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-3 col-md-6">
        <div class="p-3 stat-card rounded-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="label">Total Registrants</div>
              <div class="value"><?php echo number_format((int) ($totalRegistrants ?? 0)); ?></div>
            </div>
            <div class="text-end">
              <i class="fa-solid fa-users fa-2x" style="color:var(--khaki)"></i>
            </div>
          </div>
          <div class="ribbon mt-3"></div>
          <small class="text-muted">Updated: <?php echo date('d M Y'); ?></small>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="p-3 stat-card rounded-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="label">QR Issued</div>
              <div class="value"><?php echo number_format((int) ($qrIssued ?? 0)); ?></div>
            </div>
            <div class="text-end">
              <i class="fa-solid fa-qrcode fa-2x" style="color:var(--accent)"></i>
            </div>
          </div>
          <div class="ribbon mt-3"></div>
          <small class="text-muted">Pending manual checks: <?php echo max(0, (int)(($totalRegistrants ?? 0) - ($qrIssued ?? 0))); ?></small>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="p-3 stat-card rounded-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="label">Checked-in</div>
              <div class="value"><?php echo number_format((int) ($checkedIn ?? 0)); ?></div>
            </div>
            <div class="text-end">
              <i class="fa-solid fa-check-circle fa-2x" style="color:#6ee7b7"></i>
            </div>
          </div>
          <div class="ribbon mt-3"></div>
          <small class="text-muted">Gates active: 4</small>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="p-3 stat-card rounded-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="label">Alerts</div>
              <div class="value"><?php echo number_format((int) ($alerts ?? 0)); ?></div>
            </div>
            <div class="text-end">
              <i class="fa-solid fa-triangle-exclamation fa-2x" style="color:#ffcc66"></i>
            </div>
          </div>
          <div class="ribbon mt-3"></div>
          <small class="text-muted">Last: <?php echo date('d M Y H:i'); ?></small>
        </div>
      </div>
    </div>

    <div class="row mt-4 g-3">
      <div class="col-lg-8">
        <div class="card stat-card p-3 rounded-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Recent Registrants</h5>
            <div class="d-flex gap-2">
              <input class="form-control form-control-sm" id="searchBox" placeholder="Search by name / Aadhaar / phone" />
              <button class="btn btn-sm btn-outline-light" id="btnExport"><i class="fa-solid fa-file-arrow-down"></i> Export</button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle mb-0">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Aadhaar (masked)</th>
                  <th>Phone</th>
                  <th>QR</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="registrantsTable">
                <?php if (!empty($recentRegistrants) && is_array($recentRegistrants)): ?>
                  <?php foreach ($recentRegistrants as $r): ?>
                    <?php
                      $id = (int)$r->id;
                      $name = htmlspecialchars($r->name ?? '—', ENT_QUOTES, 'UTF-8');
                      $aad = mask_aadhaar($r->aadhaar ?? '');
                      $phone = htmlspecialchars($r->phone ?? '—', ENT_QUOTES, 'UTF-8');
                      $qr_status = htmlspecialchars($r->qr_status ?? ($r->qr_issued ?? 0 ? 'Issued' : 'Pending'), ENT_QUOTES, 'UTF-8');
                      $checked = !empty($r->checked_in) ? true : false;
                      $photo = !empty($r->photo_url) ? htmlspecialchars($r->photo_url, ENT_QUOTES, 'UTF-8') : 'https://via.placeholder.com/48x48.png?text=ID';
                    ?>
                    <tr>
                      <td><img src="<?php echo $photo; ?>" class="rounded" alt="photo" width="48" height="48"></td>
                      <td><?php echo $name; ?></td>
                      <td><?php echo $aad; ?></td>
                      <td><?php echo $phone; ?></td>
                      <td>
                        <?php if (strtolower($qr_status) === 'issued' || (isset($r->qr_issued) && $r->qr_issued)): ?>
                          <span class="badge bg-secondary">Issued</span>
                        <?php else: ?>
                          <span class="badge bg-warning text-dark">Pending</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($checked): ?>
                          <span class="badge bg-success">Checked-in</span>
                        <?php else: ?>
                          <span class="badge bg-secondary">Awaiting</span>
                        <?php endif; ?>
                      </td>
                      <td><button class="btn btn-sm btn-outline-light" onclick="openDetails(<?php echo $id; ?>)"><i class="fa-solid fa-eye"></i></button></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="7" class="text-center text-muted">No recent registrants</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <!-- Quick actions & notifications (unchanged) -->
      </div>
    </div>

    <footer class="mt-4 text-center small text-muted">
      United We Stand Foundation • Combat Army Aviation Training School (CATS)
    </footer>
  </div>

  <!-- Bootstrap JS + Popper -->
  <!-- Modal + scripts (same as before) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // small client-side JS (identical to your previous file)
    function openDetails(id){
      // for demo: in real app, call a backend endpoint to fetch details via AJAX
      var modalBody = document.getElementById('detailBody');
      modalBody.innerHTML = '<p class="text-muted">Loading details for ID ' + id + '...</p>';
      var modal = new bootstrap.Modal(document.getElementById('detailModal'));
      modal.show();
    }

    document.getElementById('searchBox').addEventListener('input', function(e){
      const q = e.target.value.toLowerCase();
      const rows = document.querySelectorAll('#registrantsTable tr');
      rows.forEach(r=>{
        r.style.display = (q==='' || r.innerText.toLowerCase().includes(q)) ? '' : 'none';
      });
    });

    document.getElementById('btnExport').addEventListener('click', function(){
      alert('Export CSV via backend endpoint: /CiFresh/index.php/dashboard/export (implement server-side)');
    });
  </script>
</body>
</html>