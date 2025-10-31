<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Helicopter Show 2025 | QR Verification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      text-align: center;
      overflow-x: hidden;
      transition: background 0.6s ease;
    }

    body.valid {
      background: linear-gradient(135deg, #00b09b, #96c93d);
    }

    body.invalid {
      background: linear-gradient(135deg, #ff4b1f, #ff9068);
    }

    /* 🎟️ Ticket Container */
    .ticket {
      position: relative;
      background: rgba(255, 255, 255, 0.1);
      border: 2px dashed rgba(255, 255, 255, 0.3);
      border-radius: 16px;
      padding: 2rem;
      width: 90%;
      max-width: 420px;
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.4);
      animation: fadeIn 0.8s ease;
    }

    .ticket::before, .ticket::after {
      content: '';
      position: absolute;
      width: 25px;
      height: 25px;
      background: #000;
      border-radius: 50%;
      top: 50%;
      transform: translateY(-50%);
    }

    .ticket::before { left: -13px; }
    .ticket::after { right: -13px; }

    .event-title {
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: 1px;
      margin-bottom: 0.5rem;
    }

    .org {
      font-size: 0.9rem;
      color: #c8f9ff;
      margin-bottom: 1.5rem;
    }

    .details {
      background: rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 1rem;
      margin: 1.5rem 0;
      font-size: 0.95rem;
      color: #e7f5f3;
      box-shadow: inset 0 0 8px rgba(255, 255, 255, 0.15);
    }

    .details p {
      margin: 0.4rem 0;
    }

    .footer {
      font-size: 0.85rem;
      color: #d9ffec;
      margin-top: 1rem;
    }

    /* ✅ Subtle Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile adjustments */
    @media (max-width: 576px) {
      .ticket {
        padding: 1.5rem;
        width: 95%;
      }

      .event-title {
        font-size: 1.3rem;
      }
    }
  </style>
</head>

<body class="<?= isset($status) && $status === 'valid' ? 'valid' : 'invalid' ?>">
  <div class="ticket">

    <?php if (isset($status) && $status === 'valid'): ?>
      <?php 
        $aadhaar = $record->aadhaar_number;
        $masked_aadhaar = str_repeat('*', 8) . substr($aadhaar, -4);
      ?>

      <h3 class="event-title">HELICOPTER SHOW 2025</h3>
      <div class="org">Organised by United We Stand Foundation<br>in collaboration with Combat Army Aviation Training School (CATS), Nashik</div>

      <h5 class="text-light mb-3">✅ Verification Successful</h5>

      <div class="details">
        <p><strong>Name:</strong> <?= htmlspecialchars($record->full_name) ?></p>
        <p><strong>Aadhaar:</strong> <?= htmlspecialchars($masked_aadhaar) ?></p>
        <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($record->status)) ?></p>
        <hr style="border-color: rgba(255,255,255,0.3)">
        <p><strong>Event Date:</strong> 1st November 2025</p>
        <p><strong>Venue:</strong> CATS Upanagar, Nashik</p>
        <p><strong>Entry Time:</strong> 12:00 PM onwards</p>
      </div>

      <p class="footer">
        Please carry a valid photo ID.<br>
        Entry subject to security clearance.<br>
        Powered by <strong>United We Stand Foundation</strong>.
      </p>

    <?php else: ?>
      <h3 class="event-title">HELICOPTER SHOW 2025</h3>
      <div class="org">United We Stand Foundation • CATS, Nashik</div>

      <h5 class="text-danger mb-3">⛔ Invalid or Expired QR</h5>
      <p class="details">
        This QR code is not recognized in our system.<br>
        Please contact the event registration helpdesk.
      </p>

      <p class="footer">
        Report suspicious passes to security staff immediately.
      </p>
    <?php endif; ?>
  </div>
</body>
</html>