<?php
session_start();
include 'includes/config.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit();
        } else { $error = "Invalid Credentials!"; }
    } else { $error = "User not found!"; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Login | YatraTour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=Inter:wght@300;400;600&display=swap');

        :root {
            --accent: #ff4d00;
            --glass: rgba(255, 255, 255, 0.08);
            --border: rgba(255, 255, 255, 0.15);
        }

        body, html {
            margin: 0; padding: 0; height: 100%;
            font-family: 'Inter', sans-serif;
            background: #050505;
            overflow: hidden;
        }

        /* Full Screen Background Image with Overlay */
        .bg-video-wrap {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
        }

        .bg-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at center, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.8) 100%);
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-container {
            background: var(--glass);
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 60px 50px;
            width: 100%;
            max-width: 480px;
            text-align: center;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 2.8rem;
            background: linear-gradient(to right, #fff, #ff4d00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
            margin-bottom: 5px;
        }

        .subtitle {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            margin-bottom: 40px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Modern Input Styling */
        .input-group-modern {
            position: relative;
            margin-bottom: 25px;
        }

        .form-control {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid var(--border) !important;
            border-radius: 18px;
            padding: 18px 25px;
            color: #fff !important;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.1) !important;
            border-color: var(--accent) !important;
            box-shadow: 0 0 20px rgba(255, 77, 0, 0.3);
            transform: scale(1.02);
        }

        /* Premium Button */
        .btn-luxury {
            background: #fff;
            color: #000;
            border: none;
            border-radius: 18px;
            padding: 18px;
            width: 100%;
            font-weight: 700;
            font-size: 1.1rem;
            transition: 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            margin-top: 15px;
        }

        .btn-luxury:hover {
            background: var(--accent);
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(255, 77, 0, 0.4);
        }

        .signup-link {
            margin-top: 30px;
            color: rgba(255,255,255,0.5);
            font-size: 0.9rem;
        }

        .signup-link a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 2px solid var(--accent);
            padding-bottom: 2px;
        }

        /* Floating elements for depth */
        .floating-icon {
            position: absolute;
            color: rgba(255,255,255,0.1);
            font-size: 5rem;
            z-index: -1;
            animation: float 6s infinite ease-in-out;
        }
    </style>
</head>
<body>

<div class="bg-video-wrap">
    <div class="bg-overlay"></div>
</div>

<div class="login-wrapper">
    <i class="fas fa-plane floating-icon" style="top: 10%; left: 10%;"></i>
    <i class="fas fa-umbrella-beach floating-icon" style="bottom: 10%; right: 10%; animation-delay: 2s;"></i>

    <div class="glass-container">
        <div class="logo-text">Yatra.</div>
        <div class="subtitle">Experience Excellence</div>

        <?php if(isset($error)): ?>
            <div class="alert bg-danger text-white border-0 py-2 small mb-4" style="border-radius: 12px;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group-modern">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            
            <div class="input-group-modern">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="btn btn-luxury">SIGN IN</button>
            
            <div class="signup-link">
                Not a member? <a href="register.php">JOIN THE CLUB</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>