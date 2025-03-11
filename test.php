<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System Login</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            padding: 10px 20px;
            color: #fff;
        }
        .header {
            background: url('assets/img/cover.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
        }
        .header-content {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        .login-options {
            display: flex;
            justify-content: center;
            gap: 30px;
        }
        .login-button {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .login-button:hover {
            transform: translateY(-5px);
        }
        .info-section {
            padding: 20px;
            background-color: #fff;
            text-align: center;
        }
        .footer {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 15px 0;
        }
        iframe {
            width: 100%;
            height: 300px;
            border: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="assets/img/logo.png" alt="School Logo" width="50">
            <span>BNSF</span>
        </div>
    </nav>
    
    <header class="header">
        <div class="header-content">
            <h2>Welcome to BNSF</h2>
            <p>Manage your schedules, grades, and more from one place.</p>
            <div class="login-options">
                <button class="login-button">Student Portal</button>
                <button class="login-button">Faculty Portal</button>
            </div>
        </div>
    </header>
    
    <section class="info-section">
        <h2>Information About Us</h2>
        <p>We are the only Fisheries School in region 12 that offers the best skills.</p>
        <h3>Location</h3>
        <p>Zone-7 Bula, General Santos City</p>
        <h3>Telephone</h3>
        <p>(083)301-4555</p>
        <h3>Email</h3>
        <p>bulanationallschooloffisheries@gmail.com</p>
    </section>
    
    <iframe src="//maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=+(general santos city, bula national school of fisheries)&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
    
    <footer class="footer">
        <p>&copy; 2025 BULA NATIONAL SCHOOL OF FISHERIES. All Rights Reserved.</p>
    </footer>
</body>
</html>
