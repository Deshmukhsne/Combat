<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

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
            position: relative;
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

        /* 🚁 Enhanced Helicopter Animation */
        .helicopter {
            position: fixed;
            top: 100px;
            left: -150px;
            width: 120px;
            animation: flyAcross 20s ease-in-out infinite;
            z-index: 1000;
            filter: drop-shadow(0 5px 5px rgba(0, 0, 0, 0.3));
            transform-origin: center;
        }

        @keyframes flyAcross {
            0% {
                transform: translateX(-200px) translateY(0) rotate(0deg);
            }

            10% {
                transform: translateX(15vw) translateY(50px) rotate(5deg);
            }

            20% {
                transform: translateX(30vw) translateY(-30px) rotate(-3deg);
            }

            30% {
                transform: translateX(45vw) translateY(70px) rotate(4deg);
            }

            40% {
                transform: translateX(60vw) translateY(-20px) rotate(-2deg);
            }

            50% {
                transform: translateX(75vw) translateY(40px) rotate(3deg);
            }

            60% {
                transform: translateX(90vw) translateY(-50px) rotate(-4deg);
            }

            70% {
                transform: translateX(105vw) translateY(30px) rotate(2deg);
            }

            80% {
                transform: translateX(120vw) translateY(-40px) rotate(-3deg);
            }

            90% {
                transform: translateX(135vw) translateY(60px) rotate(4deg);
            }

            100% {
                transform: translateX(150vw) translateY(0) rotate(0deg);
            }
        }

        /* Add helicopter shadow */
        .helicopter::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 50%;
            filter: blur(5px);
            animation: shadowMove 20s ease-in-out infinite;
        }

        @keyframes shadowMove {
            0% {
                transform: translateX(-50%) scale(1);
                opacity: 0.3;
            }

            50% {
                transform: translateX(-50%) scale(1.2);
                opacity: 0.5;
            }

            100% {
                transform: translateX(-50%) scale(1);
                opacity: 0.3;
            }
        }

        /* Add rotor animation */
        .rotor {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 10px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 5px;
            animation: rotorSpin 0.1s linear infinite;
        }

        @keyframes rotorSpin {
            0% {
                transform: translateX(-50%) rotate(0deg);
            }

            100% {
                transform: translateX(-50%) rotate(360deg);
            }
        }

        /* Add blinking light */
        .light {
            position: absolute;
            top: 25px;
            right: 20px;
            width: 8px;
            height: 8px;
            background: #ff0000;
            border-radius: 50%;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            50% {
                opacity: 1;
            }

            51%,
            100% {
                opacity: 0;
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
            position: relative;
            z-index: 100;
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

    <!-- 🚁 Enhanced Flying Helicopter -->
    <div class="helicopter">
        <div class="rotor"></div>
        <div class="light"></div>
        <img src="<?php echo base_url('assets/images/helicopter.png'); ?>" alt="Helicopter">
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center g-4">
            <!-- Left: Registration Form -->
            <div class="col-lg-7">
                <div class="registration-container">
                    <div class="flag-strip"></div>

                    <div class="registration-form">
                        <h3 class="form-title">Secure Registration Form</h3>

                        <form action="<?php echo site_url('form/submit_registration'); ?>" method="post"
                            enctype="multipart/form-data">

                            <div class="mb-3">
                                <label class="form-label">Full Name (as per Aadhaar) <span>*</span></label>
                                <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Aadhaar Number <span>*</span></label>
                                <input type="text" name="aadhaar_number" class="form-control" maxlength="12"
                                    placeholder="Enter 12-digit Aadhaar number" required>
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
                                    <label class="form-label">Email Address (optional for e-pass)</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email (optional)">
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
                <img src="<?php echo base_url('assets/images/image.png'); ?>" alt="Secure Registration">
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