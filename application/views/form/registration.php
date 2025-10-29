<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #FF9933, #FFFFFF, #138808);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .registration-form {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            padding: 30px;
        }

        .form-title {
            text-align: center;
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .form-label span {
            color: red;
        }

        .flag-header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .flag-bar {
            width: 30px;
            height: 6px;
            margin: 0 3px;
            border-radius: 2px;
        }

        .saffron {
            background-color: #FF9933;
        }

        .white {
            background-color: #FFFFFF;
            border: 1px solid #ddd;
        }

        .green {
            background-color: #138808;
        }

        .btn-flag {
            background-color: #0d6efd;
            border: none;
            color: #fff;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
        }

        .btn-flag:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="registration-form">
            <div class="flag-header">
                <div class="flag-bar saffron"></div>
                <div class="flag-bar white"></div>
                <div class="flag-bar green"></div>
            </div>

            <h3 class="form-title">Secure Registration Form</h3>

            <form>
                <!-- Full Name -->
                <div class="mb-3">
                    <label class="form-label">Full Name (as per Aadhaar) <span>*</span></label>
                    <input type="text" class="form-control" placeholder="Enter full name" required>
                </div>

                <!-- Aadhaar Number -->
                <div class="mb-3">
                    <label class="form-label">Aadhaar Number <span>*</span></label>
                    <input type="text" class="form-control" placeholder="Enter 12-digit Aadhaar number" maxlength="12"
                        required>
                </div>

                <!-- Aadhaar Photo -->
                <div class="mb-3">
                    <label class="form-label">Upload Aadhaar Photo/Image <span>*</span></label>
                    <input type="file" class="form-control" accept="image/*" required>
                </div>

                <!-- Mobile Number -->
                <div class="mb-3">
                    <label class="form-label">Mobile Contact Number <span>*</span></label>
                    <input type="tel" class="form-control" placeholder="Enter mobile number" maxlength="10" required>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label class="form-label">Email Address (optional for e-pass)</label>
                    <input type="email" class="form-control" placeholder="Enter email address (optional)">
                </div>

                <!-- Emergency Contact -->
                <div class="mb-3">
                    <label class="form-label">Emergency Contact Name <span>*</span></label>
                    <input type="text" class="form-control" placeholder="Enter emergency contact name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Emergency Contact Number <span>*</span></label>
                    <input type="tel" class="form-control" placeholder="Enter emergency contact number" maxlength="10"
                        required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-flag">Submit Registration</button>
            </form>
        </div>
    </div>

</body>

</html>