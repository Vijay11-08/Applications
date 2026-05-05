<?php
include 'includes/db.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php'); exit;
}

$error = ""; $success = "";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $conn->real_escape_string(trim($_POST['name']));
    $email    = $conn->real_escape_string(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if(strlen($name) < 2) {
        $error = "Please enter your full name.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif(strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $check = $conn->query("SELECT id FROM users WHERE email='$email'");
        if($check->num_rows > 0) {
            $error = "This email is already registered. <a href='login.php' style='color:var(--primary)'>Sign in instead?</a>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hash')");
            $success = "Account created! Redirecting to login...";
            header("Refresh: 2; url=login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | LUXURA</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: var(--bg); min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr;">

    <!-- Left: Atmospheric Image Panel -->
    <div style="position: relative; overflow: hidden; min-height: 100vh;">
        <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=900&q=80"
             alt="Luxura Interior"
             style="width: 100%; height: 100%; object-fit: cover; display: block;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.75));"></div>
        <div style="position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: flex-end; padding: 4rem;">
            <a href="index.php" style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--primary); letter-spacing: 3px; display: block; margin-bottom: 3rem;">LUXURA</a>
            <blockquote style="font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.5rem; color: #fff; line-height: 1.6; margin: 0;">
                "Every great home begins with a vision. Let us help you realise yours."
            </blockquote>
            <div style="display: flex; gap: 2rem; margin-top: 3rem;">
                <div>
                    <p style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: var(--primary); font-weight: 700;">5,000+</p>
                    <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;">Happy Homes</p>
                </div>
                <div>
                    <p style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: var(--primary); font-weight: 700;">200+</p>
                    <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;">Unique Pieces</p>
                </div>
                <div>
                    <p style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: var(--primary); font-weight: 700;">10yr</p>
                    <p style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px;">Guarantee</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Registration Form -->
    <div style="display: flex; align-items: center; justify-content: center; padding: 4rem; background: var(--surface); overflow-y: auto;">
        <div style="width: 100%; max-width: 440px;">
            <div style="margin-bottom: 3rem;">
                <span style="color: var(--primary); letter-spacing: 4px; font-size: 0.7rem; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 1rem;">New Member</span>
                <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; margin: 0;">Create Account</h1>
                <p style="color: var(--text-muted); margin-top: 0.75rem; font-size: 0.9rem;">Join the Luxura family and discover your perfect space</p>
            </div>

            <?php if($error): ?>
            <div style="background: rgba(255,77,77,0.1); border: 1px solid rgba(255,77,77,0.3); color: #ff4d4d; padding: 1rem 1.5rem; border-radius: 4px; font-size: 0.9rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
            </div>
            <?php elseif($success): ?>
            <div style="background: rgba(76,175,80,0.1); border: 1px solid rgba(76,175,80,0.3); color: #4caf50; padding: 1rem 1.5rem; border-radius: 4px; font-size: 0.9rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-circle-check"></i> <?php echo $success; ?>
            </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 0.75rem;">Full Name</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-user" style="position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="text" name="name" required placeholder="Your full name"
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                               style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: #fff; padding: 1rem 1.2rem 1rem 3rem; font-size: 0.9rem; outline: none; transition: border-color 0.3s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 0.75rem;">Email Address</label>
                    <div style="position: relative;">
                        <i class="fa-regular fa-envelope" style="position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                        <input type="email" name="email" required placeholder="your@email.com"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                               style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: #fff; padding: 1rem 1.2rem 1rem 3rem; font-size: 0.9rem; outline: none; transition: border-color 0.3s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 0.75rem;">Password</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem;"></i>
                            <input type="password" name="password" required placeholder="Min. 6 chars"
                                   style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: #fff; padding: 1rem 1rem 1rem 2.75rem; font-size: 0.9rem; outline: none; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); margin-bottom: 0.75rem;">Confirm</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-lock-open" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem;"></i>
                            <input type="password" name="confirm_password" required placeholder="Repeat"
                                   style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: #fff; padding: 1rem 1rem 1rem 2.75rem; font-size: 0.9rem; outline: none; transition: border-color 0.3s;"
                                   onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.2rem; font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase;">
                    Create My Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 2.5rem; padding-top: 2.5rem; border-top: 1px solid var(--border);">
                <p style="color: var(--text-muted); font-size: 0.85rem;">Already have an account? <a href="login.php" style="color: var(--primary); font-weight: 600;">Sign In</a></p>
            </div>
        </div>
    </div>
</body>
</html>
