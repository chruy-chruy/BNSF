<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: modules/dashboard/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png">
    <title>About Us - BNSF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>      /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Additional Styles for Map and Info */
        .map-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            background-color: #fff;
        }

        .map-container, .info-section {
            width: 50%;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            /* box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2); */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-section {
            /* background-color: #ecf0f1; */
            text-align: left;
            padding: 20px;
        }

        .info-section h2 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #16a085;
        }

        .info-section p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .info-item i {
            font-size: 24px;
            margin-right: 10px;
            color: #16a085;
        }

         /* General Styles */
         body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            padding: 10px 20px;
            color: #fff;
        }

        .navbar .logo {
            display: flex;
            align-items: center;
        }

        .navbar .logo-img {
            width: 50px;
            margin-right: 10px;
        }

        .navbar .school-name {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .navbar .nav-links a {
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            background-color: #34495e;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8)), url('assets/img/cover.jpg') no-repeat center center/cover;
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
            max-width: 700px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .header-content h2 {
            font-size: 2.5em;
            margin-bottom: 15px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .header-content p {
            font-size: 1.2em;
            margin-bottom: 20px;
            font-style: italic;
        }

        /* Login Buttons Styled as Cards */
        .login-options {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .login-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 20px;
            width: 180px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .login-button:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.4);
        }

        .login-button img {
            width: 60px;
            margin-bottom: 10px;
        }

        .login-button span {
            font-size: 1.2em;
            font-weight: bold;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .modal-content h3 {
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-content button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background-color: #2980b9;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: #555;
        }

        .close-btn:hover {
            color: #000;
        }
/* Ensure the page fills the full viewport height */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Make content section grow to push the footer down */
.main-content {
    flex: 1;
}

/* Footer Styling */
.footer {
    background-color: #2c3e50;
    color: #fff;
    text-align: center;
    padding: 15px 0;
}
        .about-content {
            max-width: 800px;
            margin: auto;
            font-size: 1.2em;
        }
        .vision-mission {
            background: linear-gradient(to right, #1abc9c, #16a085);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .vision-mission h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .about-section {
            padding: 50px 20px;
            background-color: #fff;
            text-align: center;
        }
        .about-section h2 {
            font-size: 2.5em;
            color: #16a085;
        }
    </style>
</head>
<body>
   <!-- Navbar Section -->
   <nav class="navbar">
        <div class="logo">
        <a href="index.php">
                <img src="assets/img/logo.png" alt="School Logo" class="logo-img">
                <span class="school-name">BNSF</span>
        </a>
        </div>
        <ul class="nav-links">
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="index.php">Home</a></li>
        </ul>
    </nav>
    <section class="about-section">
        <h2>About Us</h2>
        <div class="about-content">
            <p>Welcome to Bula National School of Fisheries (BNSF), the premier Fisheries School in Region 12, dedicated to providing top-tier education and skill training.</p>
        </div>
    </section>
    <section class="vision-mission">
        <h2>VISION</h2>
        <p>We dream of Filipinos who passionately love their country and whose competencies and values enable them to realize their full potential and contribute meaningfully to building the nation.</p>
        <p>We are a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.</p>
    </section>
    <section class="vision-mission">
        <h2>MISSION</h2>
        <p>To protect and promote the right of every Filipino to quality, equitable, culture-based, and complete basic education where:</p>
        <p>- Students learn in a child-friendly, gender-sensitive, safe, and motivating environment.</p>
        <p>- Teachers facilitate learning and constantly nurture every learner.</p>
        <p>- Administrators and staff ensure an enabling and supportive environment for effective learning.</p>
        <p>- Family, community, and other stakeholders are actively engaged in lifelong learning.</p>
    </section>
    <footer class="footer">
        <p>&copy; 2025 BULA NATIONAL SCHOOL OF FISHERIES. All Rights Reserved.</p>
    </footer>
</body>
</html>
