<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> | Premium Furniture</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Applications/furniture_shop/assets/css/style.css">
</head>
<body>

<header>
    <div class="container nav">
        <a href="/Applications/furniture_shop/index.php" class="logo">LUXURA</a>

        <ul class="nav-links">
            <li><a href="/Applications/furniture_shop/index.php">Maison</a></li>
            <li><a href="/Applications/furniture_shop/shop.php">Atelier</a></li>
            <li><a href="/Applications/furniture_shop/shop.php?category=1">Sofas</a></li>
            <li><a href="/Applications/furniture_shop/shop.php?category=2">Beds</a></li>
            <li><a href="/Applications/furniture_shop/shop.php?category=3">Chairs</a></li>
            <li><a href="/Applications/furniture_shop/shop.php?category=5">Lighting</a></li>
        </ul>

        <div class="nav-icons">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="/Applications/furniture_shop/wishlist.php" class="icon-btn" title="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>
                <a href="/Applications/furniture_shop/cart.php" class="icon-btn" title="Cart">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge" id="cart-count"><?php
                        $uid   = $_SESSION['user_id'];
                        $cqty  = $conn->query("SELECT COALESCE(SUM(quantity),0) as t FROM cart WHERE user_id=$uid")->fetch_assoc()['t'];
                        echo $cqty;
                    ?></span>
                </a>
                <div class="user-menu" style="position:relative;">
                    <a href="#" id="userDropdownTrigger" class="icon-btn">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <div id="userDropdown" style="display:none; position:absolute; right:0; top:calc(100% + 1rem); background:var(--surface); border:1px solid var(--border); padding:1.5rem; width:220px; z-index:200; box-shadow:var(--shadow);">
                        <p style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem;">
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </p>
                        <hr style="margin-bottom:1rem; border:none; border-top:1px solid var(--border);">
                        <?php if($_SESSION['user_role'] === 'admin'): ?>
                            <a href="/Applications/furniture_shop/admin/index.php" style="display:block; padding:0.5rem 0; color:var(--primary); font-size:0.85rem; font-weight:600;">
                                <i class="fa-solid fa-gauge" style="margin-right:6px;"></i> Admin Panel
                            </a>
                        <?php endif; ?>
                        <a href="/Applications/furniture_shop/orders.php" style="display:block; padding:0.5rem 0; font-size:0.85rem;">
                            <i class="fa-solid fa-receipt" style="margin-right:6px;"></i> My Orders
                        </a>
                        <a href="/Applications/furniture_shop/logout.php" style="display:block; padding:0.5rem 0; color:#ff4d4d; font-size:0.85rem; margin-top:0.75rem;">
                            <i class="fa-solid fa-arrow-right-from-bracket" style="margin-right:6px;"></i> Sign Out
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/Applications/furniture_shop/login.php" class="btn btn-outline" style="padding:0.6rem 1.5rem; font-size:0.78rem; letter-spacing:1.5px;">
                    Access
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
// Dropdown toggle
const trigger = document.getElementById('userDropdownTrigger');
const dropdown = document.getElementById('userDropdown');
if(trigger && dropdown) {
    trigger.addEventListener('click', e => {
        e.preventDefault();
        e.stopPropagation();
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    });
    document.addEventListener('click', () => { dropdown.style.display = 'none'; });
}
</script>
