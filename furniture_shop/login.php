<?php
include 'includes/db.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php'); exit;
}

$error = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $result   = $conn->query("SELECT * FROM users WHERE email='$email'");
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: ' . ($user['role'] === 'admin' ? 'admin/index.php' : 'index.php'));
            exit;
        } else { $error = "Incorrect password. Please try again."; }
    } else { $error = "No account found with that email address."; }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | LUXURA</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: var(--bg); min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr;">

    <!-- Left: Atmospheric Image Panel -->
    <div style="position: relative; overflow: hidden; min-height: 100vh;">
        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=80"
             alt="Luxura Interior"
             style="width: 100%; height: 100%; object-fit: cover; display: block;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));"></div>
        <div style="position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: flex-end; padding: 4rem;">
            <a href="index.php" style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--primary); letter-spacing: 3px; display: block; margin-bottom: 3rem;">LUXURA</a>
            <blockquote style="font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.5rem; color: #fff; line-height: 1.6; margin: 0;">
                "Where design meets desire — welcome back to your sanctuary."
            </blockquote>
        </div>
    </div>

    <!-- Right: Login Form -->
    <div style="display: flex; align-items: center; justify-content: center; padding: 4rem; background: var(--surface);">
        <div style="width: 100%; max-width: 440px;">
            <div style="margin-bottom: 3rem;">
                <span style="color: var(--primary); letter-spacing: 4px; font-size: 0.7rem; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 1rem;">Welcome Back</span>
                <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin: 0;">Sign In</h1>
                <p style="color: var(--text-muted); margin-top: 0.75rem; font-size: 0.9rem;">Access your personal Luxura account</p>
            </div>

            <?php if($error): ?>
            <div style="background: rgba(255,77,77,0.1); border: 1px solid rgba(255,77,77,0.3); color: #ff4d4d; padding: 1rem 1.5rem; border-radius: 4px; font-size: 0.9rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div style="margin-bottom: 1.75rem;">
                    <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 0.75rem;">Email Address</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-envelope" style="position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="email" name="email" required placeholder="your@email.com"
                               style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: #fff; padding: 1rem 1.2rem 1rem 3rem; font-size: 0.9rem; outline: none; transition: border-color 0.3s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>

                <div style="margin-bottom: 2.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <label style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted);">Password</label>
                        <a href="#" style="font-size: 0.75rem; color: var(--primary);">Forgot Password?</a>
                    </div>
                    <div style="position: relative;">
                        <i class="fa-solid fa-lock" style="position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="password" name="password" id="pwdInput" required placeholder="••••••••"
                               style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: #fff; padding: 1rem 3rem 1rem 3rem; font-size: 0.9rem; outline: none; transition: border-color 0.3s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        <button type="button" onclick="togglePwd()" style="position: absolute; right: 1.2rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer;">
                            <i class="fa-regular fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase;">
                    Access My Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 2.5rem; padding-top: 2.5rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.85rem;">Not yet a member? <a href="register.php" style="color: var(--primary); font-weight: 600;">Create an Account</a></p>
            </div>

            <!-- Demo Credentials Box -->
            <div style="background: var(--bg); border: 1px solid var(--border); padding: 1.5rem; margin-top: 2rem; border-radius: 4px;">
                <p style="font-size: 0.7rem; color: var(--primary); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0.75rem; font-weight: 600;">Demo Credentials</p>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.3rem;"><strong style="color: #fff;">Admin:</strong> admin@example.com / admin123</p>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Or <a href="register.php" style="color: var(--primary);">register</a> a new user account</p>
            </div>
        </div>
    </div>

    <script>
    function togglePwd() {
        const inp = document.getElementById('pwdInput');
        const ico = document.getElementById('eyeIcon');
        if (inp.type === 'password') {
            inp.type = 'text';
            ico.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            inp.type = 'password';
            ico.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
    </script>
</body>
</html>
