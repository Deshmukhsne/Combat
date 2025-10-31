<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Helicopter Show 2025 | QR Verification</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ✅ Favicon -->
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/Images/logo.png'); ?>">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --valid-bg: linear-gradient(135deg, #00b09b, #96c93d);
      --invalid-bg: linear-gradient(135deg, #ff4b1f, #ff9068);
      --ticket-bg: rgba(255, 255, 255, 0.1);
      --ticket-border: rgba(255, 255, 255, 0.3);
    }

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
      padding: 10px;
    }

    body.valid {
      background: var(--valid-bg);
    }

    body.invalid {
      background: var(--invalid-bg);
    }

    /* 🎟️ Ticket */
    .ticket {
      position: relative;
      background: var(--ticket-bg);
      border: 2px dashed var(--ticket-border);
      border-radius: 16px;
      padding: 1.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 6px 30px rgba(0, 0, 0, 0.4);
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

    /* ✅ Logo styling */
    .ticket-logo {
      width: 70px;
      height: 70px;
      object-fit: contain;
      margin-bottom: 12px;
      filter: drop-shadow(0 0 6px rgba(255, 255, 255, 0.3));
      animation: popIn 0.6s ease;
    }

    .event-title {
      font-size: 1.6rem;
      font-weight: 700;
      letter-spacing: 0.5px;
      margin-bottom: 0.3rem;
      text-transform: uppercase;
    }

    .org {
      font-size: 0.9rem;
      color: #d9f9ff;
      margin-bottom: 1.2rem;
      line-height: 1.3rem;
    }

    .details {
      background: rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 1rem;
      margin: 1.5rem 0;
      font-size: 1rem;
      color: #f7fff7;
      box-shadow: inset 0 0 8px rgba(255, 255, 255, 0.15);
      line-height: 1.4rem;
    }

    .details p {
      margin: 0.4rem 0;
      word-break: break-word;
    }

    .footer {
      font-size: 0.85rem;
      color: #e9ffee;
      margin-top: 1rem;
    }

    /* ✅ Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes popIn {
      0% { transform: scale(0.8); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    /* ✅ Mobile optimization */
    @media (max-width: 576px) {
      .ticket {
        max-width: 100%;
        padding: 1.2rem;
        border-width: 1.5px;
      }

      .ticket-logo {
        width: 60px;
        height: 60px;
      }

      .event-title {
        font-size: 1.3rem;
      }

      .details {
        font-size: 0.95rem;
        padding: 0.9rem;
      }

      .footer {
        font-size: 0.8rem;
      }
    }
  </style>
</head>

<body class="<?= isset($status) && $status === 'valid' ? 'valid' : 'invalid' ?>">

  <div class="ticket">
    <!-- ✅ Logo -->
    <img src="<?php echo base_url('assets/Images/logo.png'); ?>" alt="UWS Logo" class="ticket-logo">

    <?php if (isset($status) && $status === 'valid'): ?>
      <?php 
        $aadhaar = $record->aadhaar_number;
        $masked_aadhaar = str_repeat('*', 8) . substr($aadhaar, -4);
      ?>

      <h3 class="event-title">HELICOPTER SHOW 2025</h3>
      <div class="org">
        Organised by <strong>United We Stand Foundation</strong><br>
        in collaboration with <strong>CATS, Nashik</strong>
      </div>

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
        Report suspicious passes to event security immediately.
      </p>
    <?php endif; ?>
  </div>
</body>
</html>