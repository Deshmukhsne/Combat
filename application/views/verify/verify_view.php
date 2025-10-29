<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>QR Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg, #04102b 0%, #0b3d91 40%, #031028 100%);
      color: #fff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      font-family: "Poppins", sans-serif;
    }
    .card {
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.4);
      max-width: 500px;
    }
  </style>
</head>
<body>
  <div class="card">
    <?php if (isset($status) && $status === 'valid'): ?>
      <h3 class="text-success">✅ Verification Successful</h3>
      <p><strong>Name:</strong> <?= htmlspecialchars($record->full_name) ?></p>
      <p><strong>Mobile:</strong> <?= htmlspecialchars($record->mobile_number) ?></p>
      <p><strong>Status:</strong> <?= ucfirst($record->status) ?></p>
      <hr>
      <p>This QR code is authentic and issued by the system.</p>
    <?php else: ?>
      <h3 class="text-danger">⛔ Invalid or expired QR</h3>
      <p>This QR does not match our records or has not been issued.</p>
    <?php endif; ?>
  </div>
</body>
</html>