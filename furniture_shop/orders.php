<?php
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$user_id = $_SESSION['user_id'];
$orders  = $conn->query("SELECT * FROM orders WHERE user_id=$user_id ORDER BY created_at DESC");
$total_orders = $orders->num_rows;
?>

<div style="background:var(--bg); padding:5rem 0; min-height:80vh;">
<div class="container" style="padding:0 2rem;">

    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:4rem; padding-bottom:2rem; border-bottom:1px solid var(--border);">
        <div>
            <span style="color:var(--primary); letter-spacing:5px; font-size:0.7rem; text-transform:uppercase; font-weight:600; display:block; margin-bottom:0.75rem;">Account</span>
            <h1 style="font-family:'Playfair Display',serif; font-size:2.5rem; margin:0;">Order History</h1>
        </div>
        <div style="display:flex; align-items:center; gap:1rem;">
            <span style="color:var(--text-muted); font-size:0.85rem;"><?php echo $total_orders; ?> order<?php echo $total_orders !== 1 ? 's' : ''; ?> placed</span>
            <a href="shop.php" class="btn btn-outline" style="padding:0.75rem 2rem; font-size:0.8rem; letter-spacing:1.5px;">Continue Shopping</a>
        </div>
    </div>

    <?php if($total_orders > 0): ?>
        <div style="display:flex; flex-direction:column; gap:2rem;">
            <?php while($order = $orders->fetch_assoc()):
                $order_id  = $order['id'];
                $order_items = $conn->query("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=$order_id");
                $item_count  = $order_items->num_rows;
                $status_color = $order['status'] === 'completed' ? '#4caf50' : ($order['status'] === 'cancelled' ? '#ff4d4d' : 'var(--primary)');
                $status_bg    = $order['status'] === 'completed' ? 'rgba(76,175,80,0.1)' : ($order['status'] === 'cancelled' ? 'rgba(255,77,77,0.1)' : 'rgba(197,160,89,0.1)');
            ?>
            <div style="background:var(--surface); border:1px solid var(--border); border-radius:8px; overflow:hidden;">

                <!-- Order Header Row -->
                <div style="background:var(--bg); padding:1.5rem 2rem; display:grid; grid-template-columns:1fr 1fr 1fr 1fr auto; gap:1rem; align-items:center; border-bottom:1px solid var(--border);">
                    <div>
                        <p style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; margin-bottom:0.3rem;">Order ID</p>
                        <p style="font-weight:700; font-size:0.95rem;">#LUX-<?php echo str_pad($order_id, 4, '0', STR_PAD_LEFT); ?></p>
                    </div>
                    <div>
                        <p style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; margin-bottom:0.3rem;">Date Placed</p>
                        <p style="font-size:0.9rem;"><?php echo date('d M Y', strtotime($order['created_at'])); ?></p>
                    </div>
                    <div>
                        <p style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; margin-bottom:0.3rem;">Items</p>
                        <p style="font-size:0.9rem;"><?php echo $item_count; ?> piece<?php echo $item_count !== 1 ? 's' : ''; ?></p>
                    </div>
                    <div>
                        <p style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; margin-bottom:0.3rem;">Total</p>
                        <p style="font-family:'Playfair Display',serif; font-size:1.2rem; color:var(--primary); font-weight:700;"><?php echo CURRENCY . number_format($order['total_amount'], 2); ?></p>
                    </div>
                    <div>
                        <span style="background:<?php echo $status_bg; ?>; color:<?php echo $status_color; ?>; padding:0.5rem 1.25rem; border-radius:20px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; border:1px solid <?php echo $status_color; ?>;">
                            <?php if($order['status'] === 'completed'): ?><i class="fa-solid fa-circle-check" style="margin-right:5px;"></i><?php endif; ?>
                            <?php echo ucfirst($order['status']); ?>
                        </span>
                    </div>
                </div>

                <!-- Order Items -->
                <div style="padding:2rem;">
                    <?php $counter = 0; while($item = $order_items->fetch_assoc()): $counter++; ?>
                        <?php if($counter > 3): ?>
                            <div style="display:flex; align-items:center; gap:0.5rem; color:var(--text-muted); font-size:0.85rem; padding-top:1rem; border-top:1px solid var(--border);">
                                <i class="fa-solid fa-plus" style="font-size:0.7rem;"></i>
                                <?php echo ($item_count - 3); ?> more item<?php echo ($item_count - 3) > 1 ? 's' : ''; ?> in this order
                            </div>
                            <?php break; ?>
                        <?php endif; ?>
                    <div style="display:flex; align-items:center; gap:1.5rem; <?php echo $counter < min(3, $item_count) ? 'margin-bottom:1.25rem; padding-bottom:1.25rem; border-bottom:1px solid rgba(255,255,255,0.04);' : ''; ?>">
                        <img src="<?php echo $item['image']; ?>" style="width:70px; height:70px; object-fit:cover; border-radius:6px; border:1px solid var(--border); flex-shrink:0;">
                        <div style="flex:1;">
                            <p style="font-weight:600; font-size:0.95rem; margin-bottom:0.3rem;"><?php echo $item['name']; ?></p>
                            <p style="color:var(--text-muted); font-size:0.8rem;">Qty: <?php echo $item['quantity']; ?> &times; <?php echo CURRENCY . number_format($item['price'], 2); ?></p>
                        </div>
                        <p style="font-weight:700; color:var(--primary);"><?php echo CURRENCY . number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                    <?php endwhile; ?>
                </div>

                <!-- Order Footer Actions -->
                <div style="padding:1.25rem 2rem; border-top:1px solid var(--border); background:rgba(0,0,0,0.2); display:flex; justify-content:space-between; align-items:center;">
                    <div style="display:flex; align-items:center; gap:0.75rem; color:var(--text-muted); font-size:0.8rem;">
                        <i class="fa-solid fa-truck-fast" style="color:var(--primary);"></i>
                        <?php if($order['status'] === 'completed'): ?>
                            Delivered on <?php echo date('d M Y', strtotime($order['created_at'] . ' +5 days')); ?>
                        <?php else: ?>
                            Expected delivery in 5–7 business days
                        <?php endif; ?>
                    </div>
                    <div style="display:flex; gap:1rem;">
                        <a href="shop.php" style="color:var(--primary); font-size:0.8rem; display:flex; align-items:center; gap:0.4rem; border:1px solid var(--border); padding:0.5rem 1.25rem; border-radius:4px; transition:all 0.3s;"
                           onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                            <i class="fa-solid fa-rotate-right" style="font-size:0.7rem;"></i> Reorder
                        </a>
                        <a href="#" style="color:var(--text-muted); font-size:0.8rem; display:flex; align-items:center; gap:0.4rem; border:1px solid var(--border); padding:0.5rem 1.25rem; border-radius:4px; transition:all 0.3s;"
                           onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-muted)'">
                            <i class="fa-regular fa-file-lines" style="font-size:0.7rem;"></i> Invoice
                        </a>
                    </div>
                </div>

            </div>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <!-- Empty Orders State -->
        <div style="text-align:center; padding:8rem 2rem; background:var(--surface); border-radius:8px; border:1px dashed var(--border);">
            <div style="width:80px; height:80px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; margin:0 auto 2rem;">
                <i class="fa-solid fa-box-open" style="font-size:2rem; color:var(--text-muted);"></i>
            </div>
            <h3 style="font-family:'Playfair Display',serif; font-size:2rem; margin-bottom:1rem;">No orders yet</h3>
            <p style="color:var(--text-muted); margin-bottom:3rem; max-width:400px; margin-left:auto; margin-right:auto;">You haven't placed any orders yet. Start curating your dream home today.</p>
            <a href="shop.php" class="btn btn-primary" style="padding:1.1rem 3rem; letter-spacing:2px;">Browse Collection</a>
        </div>
    <?php endif; ?>

</div>
</div>

<?php include 'includes/footer.php'; ?>
