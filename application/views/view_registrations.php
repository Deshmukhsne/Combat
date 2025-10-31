<!-- application/views/view_registrations.php -->
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
    :root {
      --saffron: #ff9933;
      --offwhite: #fff;
      --leaf-green: #137a3f;
      --indigo: #0b3d91;
      --muted: #c7c9c6;
      --glass: rgba(255, 255, 255, 0.10);
      --glass-border: rgba(255, 255, 255, 0.25);
    }

    body {
      background: linear-gradient(180deg, #04102b 0%, rgba(11, 61, 145, 0.18) 40%, #031028 100%);
      color: var(--offwhite);
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      padding: 1.5rem 0 4rem;
      min-height: 100vh;
    }

    .top-bar {
      backdrop-filter: blur(14px) saturate(160%);
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.03));
      border: 1px solid var(--glass-border);
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1.5rem;
    }

    .card.glass {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.04), rgba(255, 255, 255, 0.02));
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(12px);
      color: var(--offwhite);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
    }

    .search-box input {
      width: 100%;
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.04);
      color: var(--offwhite);
      padding: 0.6rem 1rem;
      border-radius: 10px;
    }

    table.table thead th {
      background: rgba(255, 255, 255, 0.06);
      color: var(--offwhite);
      border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    table.table tbody tr td {
      color: #1a1a1a;
      vertical-align: middle;
    }

    /* === Status Badges === */
    .badge-bg-approved {
      background: var(--leaf-green);
      color: #fff;
    }

    .badge-bg-rejected {
      background: #d9534f;
      color: #fff;
    }

    /* === Action Buttons (Updated) === */
    .btn-accept {
      background: var(--leaf-green);
      color: #fff;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-accept:hover {
      background: #16a34a;
      box-shadow: 0 0 12px rgba(19, 122, 63, 0.6);
    }

    .btn-reject {
      background: var(--saffron);
      color: #fff;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-reject:hover {
      background: #ff7b00;
      box-shadow: 0 0 12px rgba(255, 153, 51, 0.6);
    }

    .btn-ghost {
      background: rgba(255, 255, 255, 0.04);
      color: var(--offwhite);
      border: 1px solid rgba(255, 255, 255, 0.04);
    }

    .btn-ghost:hover {
      background: rgba(255, 255, 255, 0.06);
    }

    /* === Action Buttons Container === */
    .action-buttons {
      background: linear-gradient(90deg, rgba(255, 153, 51, 0.15), rgba(19, 122, 63, 0.15));
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: inset 0 0 12px rgba(255, 255, 255, 0.05);
      transition: all 0.3s ease;
    }

    .action-buttons:hover {
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.08);
    }

    /* === Accept / Reject Buttons === */
    .btn-accept {
      background: linear-gradient(90deg, #137a3f, #17b169);
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .btn-accept:hover {
      background: #16a34a;
      box-shadow: 0 0 10px rgba(22, 163, 74, 0.7);
      transform: translateY(-1px);
    }

    .btn-reject {
      background: linear-gradient(90deg, #ff9933, #ff6f00);
      color: #fff;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .btn-reject:hover {
      background: #ff7b00;
      box-shadow: 0 0 10px rgba(255, 153, 51, 0.7);
      transform: translateY(-1px);
    }

    .aadhaar-thumb {
      width: 70px;
      height: 70px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: all 0.3s ease;
      box-shadow: 0 0 8px rgba(255, 255, 255, 0.1);
    }

    .aadhaar-thumb:hover {
      transform: scale(1.1);
      box-shadow: 0 0 12px rgba(255, 255, 255, 0.25);
    }

    /* === Aadhaar Image Modal (Glass Style) === */
    .image-modal {
      display: none;
      position: fixed;
      z-index: 1050;
      padding-top: 4rem;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(12px);
      transition: all 0.4s ease;
    }

    .image-modal.show {
      display: block;
      animation: fadeIn 0.4s ease;
    }

    .image-modal .modal-content {
      margin: auto;
      display: block;
      max-width: 60%;
      max-height: 70vh;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.25);
      animation: zoomIn 0.4s ease;
      object-fit: contain;
      transition: transform 0.3s ease;
    }

    .close-btn {
      position: fixed;
      top: 20px;
      right: 40px;
      color: #fff;
      font-size: 2rem;
      font-weight: 700;
      cursor: pointer;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      width: 42px;
      height: 42px;
      text-align: center;
      line-height: 40px;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .close-btn:hover {
      background: rgba(255, 255, 255, 0.35);
      transform: scale(1.1);
    }

    /* === Animations === */
    @keyframes zoomIn {
      from {
        transform: scale(0.7);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }
  </style>

</head>

<body>
  <div class="container">
    <div class="top-bar d-flex justify-content-between align-items-center">
      <div>
        <div style="font-weight:700; font-size:1.1rem">UWS — <span style="color:var(--saffron)">CATS</span>
          Registrations</div>
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
              <th>Aadhaar No.</th>
              <th>Aadhaar Image</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>Emergency Contact</th>
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

                  <!-- Aadhaar Number -->
                  <td><?php echo htmlspecialchars(substr($reg['aadhaar_number'], 0, 4) . '********'); ?></td>

                  <!-- Aadhaar Image -->
                  <td>
                    <?php if (!empty($reg['aadhaar_image'])): ?>
                      <img src="<?php echo base_url('uploads/aadhaar/' . $reg['aadhaar_image']); ?>" alt="Aadhaar Image"
                        class="img-thumbnail aadhaar-thumb"
                        onclick="showImage('<?php echo base_url('uploads/aadhaar/' . $reg['aadhaar_image']); ?>')">

                    <?php else: ?>
                      <span class="text-muted">No File</span>
                    <?php endif; ?>
                  </td>

                  <td><?php echo htmlspecialchars($reg['mobile_number']); ?></td>
                  <td><?php echo htmlspecialchars($reg['email']); ?></td>

                  <!-- Emergency Contact -->
                  <td>
                    <strong><?php echo htmlspecialchars($reg['emergency_name']); ?></strong><br>
                    <small class="text-muted"><?php echo htmlspecialchars($reg['emergency_number']); ?></small>
                  </td>

                  <!-- Status -->
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

                  <!-- Action Buttons -->
                  <td>
                    <div class="action-buttons d-flex justify-content-center gap-2 p-2 rounded-3">
                      <button class="btn btn-sm btn-accept flex-fill"
                        onclick="updateStatus(<?php echo $reg['id']; ?>,'accepted')">
                        <i class="bi bi-check-circle"></i> Accept
                      </button>
                      <button class="btn btn-sm btn-reject flex-fill"
                        onclick="updateStatus(<?php echo $reg['id']; ?>,'rejected')">
                        <i class="bi bi-x-circle"></i> Reject
                      </button>
                    </div>
                  </td>

                  <!-- <td>

                    <div class="action-buttons d-flex justify-content-center gap-2 p-2 rounded-3">

                      <button class="btn btn-sm btn-accept flex-fill" onclick="updateStatus(<?php echo $reg['id']; ?>,'accepted',

                                                '<?php echo htmlspecialchars(addslashes($reg['full_name'])); ?>',

                                                '<?php echo htmlspecialchars(addslashes($reg['aadhaar_number'])); ?>',

                                                '<?php echo htmlspecialchars(addslashes($reg['email'])); ?>')">

                        <I class="bi bi-check-circle"></I> Accept

                      </button>

                      <button class="btn btn-sm btn-reject flex-fill" onclick="updateStatus(<?php echo $reg['id']; ?>,'rejected')">

                        <I class="bi bi-x-circle"></I> Reject

                      </button>

                    </div>

                  </td> -->
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center text-muted">No registrations found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <footer class="text-center" style="color:var(--muted)">United We Stand Foundation • Manasvi Tech Solutions Pvt Ltd ©
      <?php echo date('Y'); ?>
    </footer>
  </div>
  <div id="imageModal" class="image-modal">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImg" alt="Aadhaar Full Image">
  </div>
  <script>
    $("#globalSearch").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("table tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });

    function updateStatus(id, status) {
      $.post("<?php echo site_url('form/update_status'); ?>", {
        id: id,
        status: status,
      }, function (response) {
        try {
          const data = (typeof response === 'object') ? response : JSON.parse(response);
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Updated',
              text: 'Status set to ' + status,
              timer: 1400,
              showConfirmButton: false
            });
            $(".status-" + id).html('<span class="badge ' + (status === 'accepted' ? 'badge-bg-approved' : 'badge-bg-rejected') + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>');
          } else {
            Swal.fire('Error', 'Failed to update status', 'error');
          }
        } catch (e) {
          Swal.fire('Error', 'Unexpected response from server', 'error');
        }
      });
    }
    // Aadhaar Image Zoom Modal
    function showImage(src) {
      const modal = document.getElementById("imageModal");
      const modalImg = document.getElementById("modalImg");
      modal.style.display = "block";
      modalImg.src = src;
      document.body.style.overflow = "hidden"; // prevent scroll
    }

    function closeModal() {
      const modal = document.getElementById("imageModal");
      modal.style.display = "none";
      document.body.style.overflow = "auto";
    }

    // Close modal on background click
    document.getElementById("imageModal").addEventListener("click", function (e) {
      if (e.target === this) closeModal();
    });
  </script>

</body>

</html>