<!doctype html>
<html lang="en">

<head>
    <!-- ✅ Favicon -->
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/Images/logo.png'); ?>">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* 🌈 Background Animation */
        body {
            background: linear-gradient(120deg, #FF9933, #FFFFFF, #138808);
            background-size: 400% 400%;
            animation: gradientMove 10s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins", sans-serif;
            padding: 20px;
            overflow-x: hidden;
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

        /* 🚁 Helicopter Animation */
        .helicopter {
            position: fixed;
            top: 120px;
            left: -150px;
            width: 140px;
            animation: flyAcross 16s linear infinite, hoverMotion 2s ease-in-out infinite;
            z-index: 1000;
            filter: drop-shadow(0 5px 5px rgba(0, 0, 0, 0.3));
            transform: scaleX(1);
            /* Facing right direction */
        }

        /* 🔄 Helicopter Flight Path */
        @keyframes flyAcross {
            0% {
                transform: translateX(-200px) scaleX(1);
            }

            50% {
                transform: translateX(calc(100vw + 200px)) translateY(-20px) scaleX(1);
            }

            100% {
                transform: translateX(-200px) scaleX(1);
            }
        }

        /* 🌀 Gentle Hover Motion */
        @keyframes hoverMotion {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        /* ✨ Spinning Rotor Effect */
        .helicopter::after {
            content: "";
            position: absolute;
            top: -10px;
            left: 25px;
            width: 90px;
            height: 6px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 4px;
            animation: spinRotor 0.12s linear infinite;
            transform-origin: center center;
            filter: blur(1.5px);
        }

        @keyframes spinRotor {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* 🧩 Registration Container */
        .registration-container {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            width: 100%;
            max-width: 700px;
            transition: all 0.3s ease;
        }

        .registration-container:hover {
            transform: scale(1.01);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .flag-strip {
            height: 8px;
            background: linear-gradient(to right, #FF9933, #FFFFFF, #138808);
        }

        .registration-form {
            padding: 20px 25px;
        }

        .form-title {
            text-align: center;
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 35px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(13, 110, 253, 0.3);
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-label span {
            color: red;
        }

        .form-control {
            border-radius: 12px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);
        }

        .btn-flag {
            background: linear-gradient(90deg, #FF9933, #138808);
            border: none;
            color: #fff;
            font-weight: 700;
            width: 100%;
            border-radius: 50px;
            padding: 8px;
            font-size: 16px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .btn-flag:hover {
            background: linear-gradient(90deg, #ff8c00, #0a8a00);
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.3);
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #555;
        }

        .image-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 40px;
        }

        .image-section img {
            width: 100%;
            max-width: 350px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .image-section {
                display: none;
            }

            .registration-container {
                max-width: 95%;
            }
        }
    </style>
</head>

<body>

    <!-- 🚁 Flying Helicopter -->
    <img src="<?php echo base_url('assets/images/helicopter.png'); ?>" alt="Helicopter" class="helicopter">

    <div class="container">
        <div class="row justify-content-center align-items-center g-4">
            <!-- Left: Registration Form -->
            <div class="col-lg-7">
                <div class="registration-container">
                    <div class="flag-strip"></div>

                    <div class="registration-form">
                        <h3 class="form-title">Secure Registration Form</h3>

                        <form action="<?php echo base_url('Form/submit_registration'); ?>" method="post"
                            enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label">Full Name (as per Aadhaar) <span>*</span></label>
                                <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Aadhaar Number <span>*</span></label>
                                <input type="text" name="aadhaar_number" class="form-control" maxlength="12"
                                    placeholder="Enter  Aadhaar number" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Aadhaar Photo/Image <span>*</span></label>
                                <input type="file" name="userfile" class="form-control" accept="image/*" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Contact Number <span>*</span></label>
                                    <input type="tel" name="mobile_number" class="form-control" maxlength="10"
                                        placeholder="Enter 10-digit number" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address </label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email ">
                                </div>
                            </div>

                            <!-- Emergency Contact Section -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Emergency Contact Name <span>*</span></label>
                                    <input type="text" name="emergency_name" class="form-control"
                                        placeholder="Enter emergency contact name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Emergency Contact Number <span>*</span></label>
                                    <input type="tel" name="emergency_number" class="form-control" maxlength="10"
                                        placeholder="Enter emergency number" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-flag mt-3">Submit Registration</button>

                            <div class="form-footer">
                                <p>By submitting, you confirm all details are accurate and verified with Aadhaar.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Image Outside Form -->
            <div class="col-lg-4 image-section">
                <img src="<?php echo base_url('assets/Images/image.png'); ?>" alt="Secure Registration">
            </div>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if ($this->session->flashdata('alert')):
        $alert = $this->session->flashdata('alert'); ?>
        <script>
            Swal.fire({
                icon: '<?= htmlspecialchars($alert['type'], ENT_QUOTES, 'UTF-8') ?>',
                title: '<?= htmlspecialchars($alert['message'], ENT_QUOTES, 'UTF-8') ?>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
</body>

</html>