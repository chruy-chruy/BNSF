
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School System Login</title>
        <style>
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

        /* Footer Styles */
        .footer {
            background-color: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="logo">
            <a href="#">
                <img src="assets/img/logo.png" alt="School Logo" class="logo-img">
            </a>
            <span class="school-name">BNSF</span>
        </div>
        <ul class="nav-links">
            <li><a href="#about">About</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <!-- Header Section -->
    <header class="header">
        <div class="header-content">
            <h2>Welcome to BNSF</h2>
            <p>Manage your schedules, grades, and more from one place.</p>
            <div class="login-options">
                <button class="login-button" onclick="openModal('student')">
                    <img src="assets/img/students.png" alt="Student Icon">
                    <span>Student Portal</span>
                </button>
                <button class="login-button" onclick="openModal('faculty')">
                    <img src="assets/img/teacher.png" alt="Faculty Icon">
                    <span>Faculty Portal</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeModal()">&times;</button>
            <h3 id="modal-title">Login</h3>
            <form id="login-form" action="validate_login.php" method="POST">
                <input type="text" placeholder="Username" name="username" required>
                <input type="password" placeholder="Password" name="password" required>
                <!-- Hidden input for role -->
                <input type="hidden" id="role-input" name="role" value="">
                <button type="submit">Login</button>
            </form>
            <!-- Display error message if any -->
            <?php if (isset($_GET['error'])) { ?>
                    <p class="error-message" style="margin-bottom: 15px; color: red;"><?php echo $_GET['error']; ?></p>
                <?php } ?>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <p>&copy; 2025 BULA NATIONAL SCHOOL OF FISHERIES. All Rights Reserved.</p>
    </footer>

    <script>
        function openModal(role) {
            const modal = document.getElementById('modal');
            const modalTitle = document.getElementById('modal-title');
            const roleInput = document.getElementById('role-input');

            // Update modal title and hidden input value based on role
            if (role === 'student') {
                modalTitle.textContent = 'Student Portal Login';
                roleInput.value = 'student';
            } else if (role === 'faculty') {
                modalTitle.textContent = 'Faculty Portal Login';
                roleInput.value = 'teacher';
            }

            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        <?php if (isset($_GET['error'])) { ?>
            openModal(role);
        <?php } ?>
    </script>
</body>
</html>

