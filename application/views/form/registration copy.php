<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #FF9933, #FFFFFF, #138808);
            background-size: 400% 400%;
            animation: gradientMove 8s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins", sans-serif;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .registration-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 900px;
            overflow: hidden;
        }

        .flag-strip {
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, #FF9933, #FFFFFF, #138808);
        }

        .registration-form {
            padding: 40px 35px;
        }

        .form-title {
            text-align: center;
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-label span {
            color: red;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
            border: 1px solid #ccc;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 8px rgba(13, 110, 253, 0.4);
        }

        .btn-flag {
            background: linear-gradient(45deg, #FF9933, #138808);
            border: none;
            color: #fff;
            font-weight: 700;
            width: 100%;
            border-radius: 50px;
            padding: 12px;
            font-size: 16px;
            text-transform: uppercase;
            transition: 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-flag:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
            background: linear-gradient(45deg, #ff8c00, #0a8a00);
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
        }

        .form-footer a {
            text-decoration: none;
            color: #0d6efd;
            font-weight: 500;
        }

        .image-side {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .image-side img {
            width: 100%;
            max-width: 300px;
        }

        @media (max-width: 768px) {
            .image-side {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="registration-container">
        <div class="flag-strip"></div>
        <div class="row g-0">
            <!-- Left Side: Form -->
            <div class="col-md-7">
                <div class="registration-form">
                    <h3 class="form-title">Secure Registration Form</h3>

                    <form action="<?php echo site_url('form/submit_registration'); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Full Name (as per Aadhaar) <span>*</span></label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Aadhaar Number <span>*</span></label>
                            <input type="text" name="aadhaar_number" class="form-control" maxlength="12" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Aadhaar Photo/Image <span>*</span></label>
                            <input type="file" name="userfile" class="form-control" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile Contact Number <span>*</span></label>
                            <input type="tel" name="mobile_number" class="form-control" maxlength="10" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address (optional for e-pass)</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact Name <span>*</span></label>
                                <input type="text" name="emergency_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Emergency Contact Number <span>*</span></label>
                                <input type="tel" name="emergency_number" class="form-control" maxlength="10" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-flag mt-2">Submit Registration</button>

                        <div class="form-footer">
                            <p>By submitting, you confirm that details are accurate and verified with Aadhaar.</p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side: Image (Hidden on Mobile) -->
            <div class="col-md-5 image-side">
                <img src="<?php echo base_url('assets/images/image.png'); ?>" alt="Secure Registration">
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if ($this->session->flashdata('alert')):
        $alert = $this->session->flashdata('alert'); ?>
        <script>
            Swal.fire({
                icon: '<?= htmlspecialchars($alert['type'], ENT_QUOTES, 'UTF-8') ?>',
                title: '<?= htmlspecialchars($alert['message'], ENT_QUOTES, 'UTF-8') ?>',
                showConfirmButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
</body>

</html>