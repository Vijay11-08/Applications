<?php
require 'layout.php';

$total_users    = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='user'")->fetch_assoc()['c'];
$total_products = $conn->query("SELECT COUNT(*) as c FROM products")->fetch_assoc()['c'];
$total_orders   = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
$total_revenue  = $conn->query("SELECT COALESCE(SUM(total_amount),0) as t FROM orders WHERE status='completed'")->fetch_assoc()['t'];
$recent_orders  = $conn->query("SELECT o.*, u.name as uname FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.created_at DESC LIMIT 8");
$top_products   = $conn->query("SELECT p.name, p.image, SUM(oi.quantity) as sold FROM order_items oi JOIN products p ON oi.product_id=p.id GROUP BY oi.product_id ORDER BY sold DESC LIMIT 5");
?>

    <!-- TOP BAR -->
    <div class="adm-topbar">
        <h1>Analytics Overview</h1>
        <span style="font-size:0.8rem;color:#555;"><?php echo date('l, d F Y'); ?></span>
    </div>

    <!-- CONTENT -->
    <div class="adm-content">

        <!-- Stat Cards -->
        <div class="stat-grid">
            <div class="stat-box">
                <div class="stat-icon"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                <div class="stat-val"><?php echo CURRENCY . number_format($total_revenue, 0); ?></div>
                <div class="stat-lbl">Total Revenue</div>
            </div>
            <div class="stat-box">
                <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
                <div class="stat-val"><?php echo $total_orders; ?></div>
                <div class="stat-lbl">Total Orders</div>
            </div>
            <div class="stat-box">
                <div class="stat-icon"><i class="fa-solid fa-couch"></i></div>
                <div class="stat-val"><?php echo $total_products; ?></div>
                <div class="stat-lbl">Products</div>
            </div>
            <div class="stat-box">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="stat-val"><?php echo $total_users; ?></div>
                <div class="stat-lbl">Customers</div>
            </div>
        </div>

        <!-- Two column grid -->
        <div style="display:grid;grid-template-columns:1fr 320px;gap:2rem;">

            <!-- Recent Orders -->
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3>Recent Orders</h3>
                    <a href="orders.php" style="font-size:0.75rem;color:#c5a059;">View All →</a>
                </div>
                <div class="adm-card-body">
                    <table class="adm-table">
                        <thead><tr>
                            <th>Order</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th>
                        </tr></thead>
                        <tbody>
                        <?php while($o = $recent_orders->fetch_assoc()): ?>
                        <tr>
                            <td style="color:#c5a059;font-weight:700;">#LUX-<?php echo str_pad($o['id'],4,'0',STR_PAD_LEFT); ?></td>
                            <td><?php echo htmlspecialchars($o['uname']); ?></td>
                            <td style="font-weight:600;"><?php echo CURRENCY.number_format($o['total_amount'],2); ?></td>
                            <td><span class="badge-pill badge-green"><?php echo $o['status']; ?></span></td>
                            <td style="color:#555;"><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
                        </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Products -->
            <div class="adm-card">
                <div class="adm-card-header">
                    <h3>Top Pieces</h3>
                </div>
                <div style="padding:1.5rem;">
                    <?php while($p = $top_products->fetch_assoc()): ?>
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.25rem;">
                        <img src="<?php echo $p['image']; ?>" style="width:44px;height:44px;object-fit:cover;border-radius:6px;border:1px solid rgba(255,255,255,0.08);">
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.85rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo $p['name']; ?></p>
                            <p style="font-size:0.75rem;color:#555;"><?php echo $p['sold']; ?> sold</p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body></html>
