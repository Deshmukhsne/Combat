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

        .registration-form {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 650px;
            padding: 40px 35px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .registration-form:hover {
            transform: scale(1.01);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.25);
        }

        .flag-strip {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: linear-gradient(to right, #FF9933, #FFFFFF, #138808);
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
    </style>
</head>

<body>

    <div class="container">
        <div class="registration-form">
            <div class="flag-strip"></div>

            <h3 class="form-title">Secure Registration Form</h3>

            <form action="<?= base_url('form/submit_registration') ?>"
                method="post"
                enctype="multipart/form-data">

                <!-- Full Name -->
                <div class="mb-3">
                    <label class="form-label">Full Name (as per Aadhaar) <span>*</span></label>
                    <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
                </div>

                <!-- Aadhaar Number -->
                <div class="mb-3">
                    <label class="form-label">Aadhaar Number <span>*</span></label>
                    <input type="text" name="aadhaar_number" class="form-control" placeholder="Enter 12-digit Aadhaar number" maxlength="12" required>
                </div>

                <!-- Aadhaar Photo -->
                <div class="mb-3">
                    <label class="form-label">Upload Aadhaar Photo/Image <span>*</span></label>
                    <input type="file" name="userfile" class="form-control" accept="image/*" required>

                </div>

                <!-- Mobile Number -->
                <div class="mb-3">
                    <label class="form-label">Mobile Contact Number <span>*</span></label>
                    <input type="tel" name="mobile_number" class="form-control" placeholder="Enter mobile number" maxlength="10" required>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label">Email Address (optional for e-pass)</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email address (optional)">
                </div>

                <!-- Emergency Contact -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emergency Contact Name <span>*</span></label>
                        <input type="text" name="emergency_name" class="form-control" placeholder="Enter emergency contact name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emergency Contact Number <span>*</span></label>
                        <input type="tel" name="emergency_number" class="form-control" placeholder="Enter emergency contact number" maxlength="10" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-flag mt-2">Submit Registration</button>

                <div class="form-footer">
                    <p>By submitting, you confirm that details are accurate and verified with Aadhaar.</p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>