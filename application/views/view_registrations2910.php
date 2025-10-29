<!-- application/views/view_registrations.php -->
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UWS — CATS Registrations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      --saffron:#ff9933;
      --offwhite:#fff;
      --leaf-green:#137a3f;
      --indigo:#0b3d91;
      --muted:#c7c9c6;
      --glass: rgba(255,255,255,0.10);
      --glass-border: rgba(255,255,255,0.25);
    }
    body{
      background: linear-gradient(180deg, #04102b 0%, rgba(11,61,145,0.18) 40%, #031028 100%);
      color:var(--offwhite);
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      padding:1.5rem 0 4rem;
      min-height:100vh;
    }
    .top-bar{
      backdrop-filter: blur(14px) saturate(160%);
      background: linear-gradient(135deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03));
      border:1px solid var(--glass-border);
      padding:1rem;
      border-radius:8px;
      margin-bottom:1.5rem;
    }
    .card.glass {
      background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
      border:1px solid var(--glass-border);
      backdrop-filter: blur(12px);
      color:var(--offwhite);
      box-shadow: 0 10px 30px rgba(0,0,0,0.35);
    }
    .search-box input {
      width:100%;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.04);
      color:var(--offwhite);
      padding:0.6rem 1rem;
      border-radius:10px;
    }
    table.table thead th {
      background: rgba(255,255,255,0.06);
      color:var(--offwhite);
      border-bottom:1px solid rgba(255,255,255,0.04);
    }
    table.table tbody tr td {
      color:var(--offwhite);
      vertical-align: middle;
    }
    .badge-bg-approved { background: var(--leaf-green); color: #fff; }
    .badge-bg-rejected { background: #d9534f; color: #fff; }
    .btn-ghost { background: rgba(255,255,255,0.04); color:var(--offwhite); border:1px solid rgba(255,255,255,0.04); }
    .btn-ghost:hover { background: rgba(255,255,255,0.06); }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-bar d-flex justify-content-between align-items-center">
      <div>
        <div style="font-weight:700; font-size:1.1rem">UWS — <span style="color:var(--saffron)">CATS</span> Registrations</div>
        <div style="color:var(--muted); font-size:.9rem">Registered user details • Manage status</div>
      </div>
      <div class="text-end" style="color:var(--muted)">Host: PHP / LAMP-ready</div>
    </div>

    <div class="card glass p-3 mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Registered Users</h4>
        <div class="d-flex gap-2">
          <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-ghost btn-sm">Back to Dashboard</a>
          <a href="<?php echo site_url('dashboard/registrations'); ?>" class="btn btn-ghost btn-sm">View All</a>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <div class="search-box">
            <i class="bi bi-search" style="position:absolute;margin:12px;color:rgba(255,255,255,0.6)"></i>
            <input id="globalSearch" type="text" placeholder="Search users by any field..." style="padding-left:36px;">
          </div>
        </div>
        <div class="col-md-6 text-end text-muted">
          Total: <?php echo count($registrations ?? []); ?>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-borderless align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Full Name</th>
              <th>Aadhaar</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>Emergency</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($registrations)): ?>
              <?php foreach ($registrations as $reg): ?>
                <tr id="row-<?php echo $reg['id']; ?>">
                  <td><?php echo $reg['id']; ?></td>
                  <td><?php echo htmlspecialchars($reg['full_name']); ?></td>
                  <td><?php echo htmlspecialchars(substr($reg['aadhaar_number'],0,4) . '********'); ?></td>
                  <td><?php echo htmlspecialchars($reg['mobile_number']); ?></td>
                  <td><?php echo htmlspecialchars($reg['email']); ?></td>
                  <td><?php echo htmlspecialchars($reg['emergency_name']) . '<br>' . htmlspecialchars($reg['emergency_number']); ?></td>
                  <td class="status-<?php echo $reg['id']; ?>">
                    <?php
                      $s = strtolower($reg['status'] ?? 'unknown');
                      if ($s === 'accepted' || $s === 'approved') {
                        $cls = 'badge-bg-approved';
                        $label = 'Approved';
                      } elseif ($s === 'rejected') {
                        $cls = 'badge-bg-rejected';
                        $label = 'Rejected';
                      } else {
                        $cls = 'badge bg-secondary';
                        $label = ucfirst($s);
                      }
                    ?>
                    <span class="badge <?php echo $cls; ?>"><?php echo $label; ?></span>
                  </td>
                  <td>
                    <button class="btn btn-sm btn-ghost me-1" onclick="updateStatus(<?php echo $reg['id']; ?>,'accepted')">Accept</button>
                    <button class="btn btn-sm btn-ghost" onclick="updateStatus(<?php echo $reg['id']; ?>,'rejected')">Reject</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="8" class="text-center text-muted">No registrations found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <footer class="text-center" style="color:var(--muted)">United We Stand Foundation • Manasvi Tech Solutions Pvt Ltd © <?php echo date('Y'); ?></footer>
  </div>

<script>
$("#globalSearch").on("keyup", function() {
  var value = $(this).val().toLowerCase();
  $("table tbody tr").filter(function() {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
});

function updateStatus(id, status) {
  $.post("<?php echo site_url('form/update_status'); ?>", {id: id, status: status}, function(response){
    try {
      const data = (typeof response === 'object') ? response : JSON.parse(response);
      if (data.success) {
        Swal.fire({icon:'success',title:'Updated',text:'Status set to ' + status, timer:1400, showConfirmButton:false});
        $(".status-" + id).html('<span class="badge ' + (status === 'accepted' ? 'badge-bg-approved' : 'badge-bg-rejected') + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>');
      } else {
        Swal.fire('Error','Failed to update status','error');
      }
    } catch (e) {
      Swal.fire('Error','Unexpected response from server','error');
    }
  });
}
</script>

</body>
</html>