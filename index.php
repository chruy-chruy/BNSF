<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Homepage with Login Modal</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <!-- Navbar Section -->
    <nav class="navbar">
        <div class="logo">
            <a href="./">
                <img src="assets/img/logo.png" alt="MyWebsite Logo" class="logo-img">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <button class="login-btn" onclick="openModal()">Login</button>
    </nav>

    <!-- Header Section (with Cover Image) -->
    <header style="background-image: url('assets/img/cover.jpg'); height: 100vh; background-size: cover; background-position: center;">
    <div class="header-content">
        <h1>Welcome to BNSF</h1>
        <p>BULA NATIONAL SCHOOL OF FISHERIES INFORMATION MANAGEMENT SYSTEM </p>
    </div>
</header>


    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Login</h2>
            <form class="login" action="validate_login.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                <?php if (isset($_GET['error'])) { ?>
                <p class="error-message" style="margin-bottom: 15px; color :red ;"><?php echo $_GET['error']; ?></p>
            <?php } ?>
                <button type="submit" class="submit-btn">Login</button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Modal -->
    <script>
        // Open the modal
        function openModal() {
            document.getElementById('loginModal').style.display = 'block';
        }

        // Close the modal
        function closeModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('loginModal')) {
                closeModal();
            }
        }

         // Check if there's an error and open the modal automatically
    <?php if (isset($_GET['error'])) { ?>
        openModal();
    <?php } ?>
    </script>
</body>
</html>
