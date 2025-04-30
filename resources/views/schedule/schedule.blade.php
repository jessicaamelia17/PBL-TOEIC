<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TOEIC Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #315efb;
        }
        .navbar a {
            color: white !important;
            margin-right: 15px;
            text-decoration: none;
        }
        .navbar a:hover {
            text-decoration: underline; /* Tampilkan underline saat hover */
        }
        .logo {
            font-weight: bold;
            color: white;
        }
        .content {
            flex: 1;
        }
        .footer {
            background-color: #315efb;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
        .table thead {
            background-color: #e2ecff;
        }
        .detail-link {
            color: #315efb;
            text-decoration: none;
        }
        .detail-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <nav class="navbar px-4">
            <span class="logo">TOEIC</span>
            <div class="ms-auto">
                <a href="#">Home</a>
                <a href="#">Registration</a>
                <a href="#">Schedule</a>
                <a href="#">Results</a>
                <a href="#">Guide</a>
                <a href="#">Contact</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mt-5 content">
            <h3 class="text-center fw-bold mb-4">TOEIC Test Schedule</h3>
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td>Monday</td>
                            <td>24/11/2025</td>
                            <td>10.00 - 12.00</td>
                            <td>Rt. 5 Lt. 5 Civil Engineering Building</td>
                            <td><a href="#" class="detail-link">Click Here</a></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            Copyright © 2025 TOEIC
        </div>
    </div>
</body>
</html>