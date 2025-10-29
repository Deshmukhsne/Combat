<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>

    <!-- Bootstrap & SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* === Glassmorphism & Indian Theme === */
        body {
            background: linear-gradient(135deg, #FF9933, #FFFFFF, #138808);
            background-size: 300% 300%;
            animation: gradientBG 10s ease infinite;
            font-family: "Poppins", sans-serif;
            color: #333;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-container {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .table thead {
            background: rgba(255, 255, 255, 0.2);
            color: #222;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.25);
            transition: 0.3s ease;
        }

        .btn-success { background-color: #138808 !important; border: none; }
        .btn-danger { background-color: #FF9933 !important; border: none; }

        .search-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .search-box input {
            border-radius: 30px;
            border: none;
            padding: 10px 40px;
            width: 100%;
            font-size: 16px;
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #555;
        }

        h2 {
            text-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
    </style>
</head>

<body class="py-5">

<div class="container">
    <div class="glass-container">
        <h2 class="text-center mb-4 text-white fw-bold">🇮🇳 Registered User Details</h2>

        <!-- 🔍 Global Search -->
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="globalSearch" placeholder="Search users by any field...">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center" id="registrationTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Aadhaar</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Emergency Contact</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($registrations)): ?>
                        <?php foreach($registrations as $reg): ?>
                            <tr id="row-<?php echo $reg['id']; ?>">
                                <td><?php echo $reg['id']; ?></td>
                                <td><?php echo htmlspecialchars($reg['full_name']); ?></td>
                                <td><?php echo substr($reg['aadhaar_number'], 0, 4) . "********"; ?></td>
                                <td><?php echo htmlspecialchars($reg['mobile_number']); ?></td>
                                <td><?php echo htmlspecialchars($reg['email']); ?></td>
                                <td><?php echo htmlspecialchars($reg['emergency_name']) . "<br>" . htmlspecialchars($reg['emergency_number']); ?></td>
                                <td class="status-<?php echo $reg['id']; ?>">
                                    <span class="badge bg-<?php echo ($reg['status'] == 'accepted') ? 'success' : (($reg['status'] == 'rejected') ? 'danger' : 'secondary'); ?>">
                                        <?php echo ucfirst($reg['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm me-1" onclick="updateStatus(<?php echo $reg['id']; ?>, 'accepted')">Accept</button>
                                    <button class="btn btn-danger btn-sm" onclick="updateStatus(<?php echo $reg['id']; ?>, 'rejected')">Reject</button>
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
</div>

<script>
/* === 🔍 Global Search Filter === */
$("#globalSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#registrationTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

/* === ✅ Status Update via AJAX === */
function updateStatus(id, status) {
    $.ajax({
        url: "<?php echo site_url('form/update_status'); ?>",
        type: "POST",
        data: {id: id, status: status},
        success: function(response) {
            const data = JSON.parse(response);
            if(data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status Updated!',
                    text: 'User has been ' + status + '.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $(".status-" + id).html('<span class="badge bg-' + (status === 'accepted' ? 'success' : 'danger') + '">' + status.charAt(0).toUpperCase() + status.slice(1) + '</span>');
            } else {
                Swal.fire('Error', 'Failed to update status', 'error');
            }
        }
    });
}
</script>

<!-- Bootstrap Icons for Search Icon -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</body>
</html>