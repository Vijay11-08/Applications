<?php
/* ─── Admin Layout Include ───────────────────────────────────────────── */
require_once '../includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php'); exit;
}

// Which page is active?
$current = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUXURA — Management Portal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{display:grid;grid-template-columns:260px 1fr;min-height:100vh;background:#0a0a0a;font-family:'Montserrat',sans-serif;color:#fff;}
        /* Sidebar */
        .adm-sidebar{background:#0f0f0f;border-right:1px solid rgba(255,255,255,0.06);display:flex;flex-direction:column;padding:0;}
        .adm-sidebar-logo{padding:2.5rem 2rem;border-bottom:1px solid rgba(255,255,255,0.06);}
        .adm-sidebar-logo span{display:block;font-size:0.65rem;letter-spacing:4px;color:#666;text-transform:uppercase;margin-top:4px;}
        .adm-nav{padding:1.5rem 1rem;flex:1;}
        .adm-nav-label{font-size:0.6rem;letter-spacing:3px;color:#444;text-transform:uppercase;padding:0 1rem;margin:1.5rem 0 0.5rem;}
        .adm-nav a{display:flex;align-items:center;gap:0.9rem;padding:0.85rem 1rem;border-radius:6px;color:#666;font-size:0.85rem;font-weight:500;transition:all 0.2s;margin-bottom:2px;}
        .adm-nav a:hover,.adm-nav a.active{background:rgba(197,160,89,0.1);color:#c5a059;}
        .adm-nav a.active{border-left:3px solid #c5a059;padding-left:calc(1rem - 3px);}
        .adm-nav a i{width:18px;text-align:center;font-size:0.9rem;}
        .adm-sidebar-footer{padding:1.5rem;border-top:1px solid rgba(255,255,255,0.06);}
        /* Main */
        .adm-main{display:flex;flex-direction:column;overflow:hidden;}
        .adm-topbar{background:#0f0f0f;border-bottom:1px solid rgba(255,255,255,0.06);padding:1.25rem 3rem;display:flex;justify-content:space-between;align-items:center;}
        .adm-topbar h1{font-family:'Playfair Display',serif;font-size:1.75rem;font-weight:700;}
        .adm-content{padding:3rem;overflow-y:auto;flex:1;}
        /* Cards */
        .adm-card{background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:8px;}
        .adm-card-header{padding:1.5rem 2rem;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:space-between;}
        .adm-card-header h3{font-family:'Playfair Display',serif;font-size:1.25rem;}
        .adm-card-body{padding:0;}
        /* Table */
        .adm-table{width:100%;border-collapse:collapse;}
        .adm-table thead tr{border-bottom:1px solid rgba(255,255,255,0.06);}
        .adm-table thead th{padding:1rem 1.5rem;text-align:left;font-size:0.65rem;text-transform:uppercase;letter-spacing:2px;color:#555;font-weight:600;}
        .adm-table tbody tr{border-bottom:1px solid rgba(255,255,255,0.04);transition:background 0.2s;}
        .adm-table tbody tr:hover{background:rgba(255,255,255,0.02);}
        .adm-table tbody td{padding:1.1rem 1.5rem;font-size:0.88rem;vertical-align:middle;}
        .adm-table tbody tr:last-child{border-bottom:none;}
        /* Stat card */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-bottom:2.5rem;}
        .stat-box{background:#141414;border:1px solid rgba(255,255,255,0.07);border-radius:8px;padding:2rem;}
        .stat-box .stat-icon{width:46px;height:46px;border-radius:8px;background:rgba(197,160,89,0.12);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;}
        .stat-box .stat-icon i{color:#c5a059;font-size:1.15rem;}
        .stat-box .stat-val{font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:#c5a059;margin-bottom:0.2rem;}
        .stat-box .stat-lbl{font-size:0.7rem;text-transform:uppercase;letter-spacing:2px;color:#555;}
        /* Badge */
        .badge-pill{padding:0.3rem 0.9rem;border-radius:20px;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;}
        .badge-green{background:rgba(76,175,80,0.15);color:#4caf50;border:1px solid rgba(76,175,80,0.3);}
        .badge-yellow{background:rgba(197,160,89,0.15);color:#c5a059;border:1px solid rgba(197,160,89,0.3);}
        .badge-red{background:rgba(255,77,77,0.15);color:#ff4d4d;border:1px solid rgba(255,77,77,0.3);}
        /* Form */
        .adm-input{width:100%;background:#0a0a0a;border:1px solid rgba(255,255,255,0.1);color:#fff;padding:0.8rem 1rem;border-radius:6px;font-size:0.88rem;font-family:'Montserrat',sans-serif;outline:none;transition:border-color 0.3s;}
        .adm-input:focus{border-color:#c5a059;}
        .adm-label{display:block;font-size:0.7rem;text-transform:uppercase;letter-spacing:2px;color:#666;margin-bottom:0.5rem;}
        /* Button */
        .adm-btn{padding:0.7rem 1.5rem;border:none;border-radius:6px;cursor:pointer;font-size:0.8rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;transition:all 0.2s;font-family:'Montserrat',sans-serif;}
        .adm-btn-primary{background:#c5a059;color:#000;}
        .adm-btn-primary:hover{background:#e0b975;}
        .adm-btn-ghost{background:transparent;border:1px solid rgba(255,255,255,0.1);color:#666;}
        .adm-btn-ghost:hover{border-color:#c5a059;color:#c5a059;}
        .adm-btn-danger{background:rgba(255,77,77,0.1);border:1px solid rgba(255,77,77,0.3);color:#ff4d4d;}
        .adm-btn-danger:hover{background:rgba(255,77,77,0.2);}
        /* Modal */
        .adm-modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.85);z-index:1000;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);}
        .adm-modal{background:#141414;border:1px solid rgba(255,255,255,0.1);border-radius:12px;width:560px;max-width:95vw;max-height:90vh;overflow-y:auto;}
        .adm-modal-header{padding:2rem;border-bottom:1px solid rgba(255,255,255,0.06);display:flex;justify-content:space-between;align-items:center;}
        .adm-modal-body{padding:2rem;}
    </style>
</head>
<body>
<!-- SIDEBAR -->
<aside class="adm-sidebar">
    <div class="adm-sidebar-logo">
        <a href="../index.php" style="font-family:'Playfair Display',serif;font-size:1.8rem;color:#c5a059;letter-spacing:2px;text-decoration:none;">LUXURA</a>
        <span>Management Portal</span>
    </div>
    <nav class="adm-nav">
        <div class="adm-nav-label">Main</div>
        <a href="index.php" class="<?php echo $current==='index'?'active':''; ?>"><i class="fa-solid fa-chart-line"></i> Analytics</a>
        <a href="products.php" class="<?php echo $current==='products'?'active':''; ?>"><i class="fa-solid fa-couch"></i> Products</a>
        <a href="orders.php" class="<?php echo $current==='orders'?'active':''; ?>"><i class="fa-solid fa-receipt"></i> Orders</a>
        <a href="users.php" class="<?php echo $current==='users'?'active':''; ?>"><i class="fa-solid fa-users"></i> Customers</a>

        <div class="adm-nav-label">Store</div>
        <a href="../index.php" target="_blank"><i class="fa-solid fa-store"></i> View Store</a>
        <a href="../shop.php" target="_blank"><i class="fa-solid fa-bag-shopping"></i> Shop Front</a>
    </nav>
    <div class="adm-sidebar-footer">
        <div style="display:flex;align-items:center;gap:0.8rem;margin-bottom:1rem;">
            <div style="width:36px;height:36px;background:rgba(197,160,89,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-user-tie" style="color:#c5a059;font-size:0.85rem;"></i>
            </div>
            <div>
                <p style="font-size:0.85rem;font-weight:600;"><?php echo $_SESSION['user_name']; ?></p>
                <p style="font-size:0.7rem;color:#555;">Administrator</p>
            </div>
        </div>
        <a href="../logout.php" style="display:flex;align-items:center;gap:0.75rem;color:#555;font-size:0.8rem;padding:0.6rem 0;transition:color 0.2s;" onmouseover="this.style.color='#ff4d4d'" onmouseout="this.style.color='#555'">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
        </a>
    </div>
</aside>

<!-- MAIN CONTENT AREA -->
<div class="adm-main">
