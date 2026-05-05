<?php
require 'layout.php';

// Delete user
if(isset($_GET['delete'])) {
    $uid = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$uid AND role='user'");
}

$users = $conn->query("SELECT u.*, 
    (SELECT COUNT(*) FROM orders WHERE user_id=u.id) as order_count,
    (SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE user_id=u.id AND status='completed') as total_spent
    FROM users u WHERE u.role='user' ORDER BY u.created_at DESC");
?>

    <div class="adm-topbar">
        <h1>Customers</h1>
        <span style="font-size:0.8rem;color:#555;"><?php echo $users->num_rows; ?> registered customers</span>
    </div>

    <div class="adm-content">
        <div class="adm-card">
            <div class="adm-card-body">
                <table class="adm-table">
                    <thead><tr>
                        <th>ID</th><th>Name</th><th>Email</th><th>Orders</th><th>Total Spent</th><th>Member Since</th><th style="text-align:center;">Actions</th>
                    </tr></thead>
                    <tbody>
                    <?php while($u = $users->fetch_assoc()): ?>
                    <tr>
                        <td style="color:#555;font-size:0.82rem;">#<?php echo $u['id']; ?></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.75rem;">
                                <div style="width:34px;height:34px;border-radius:50%;background:rgba(197,160,89,0.15);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#c5a059;flex-shrink:0;">
                                    <?php echo strtoupper(substr($u['name'],0,1)); ?>
                                </div>
                                <span style="font-weight:600;font-size:0.9rem;"><?php echo htmlspecialchars($u['name']); ?></span>
                            </div>
                        </td>
                        <td style="color:#555;font-size:0.82rem;"><?php echo $u['email']; ?></td>
                        <td>
                            <?php if($u['order_count'] > 0): ?>
                                <span class="badge-pill badge-green"><?php echo $u['order_count']; ?> order<?php echo $u['order_count']>1?'s':''; ?></span>
                            <?php else: ?>
                                <span class="badge-pill badge-yellow">No orders</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:700;color:#c5a059;"><?php echo CURRENCY . number_format($u['total_spent'],2); ?></td>
                        <td style="color:#555;font-size:0.82rem;"><?php echo date('d M Y', strtotime($u['created_at'])); ?></td>
                        <td style="text-align:center;">
                            <a href="?delete=<?php echo $u['id']; ?>" 
                               class="adm-btn adm-btn-danger" 
                               style="font-size:0.75rem;padding:0.45rem 0.9rem;"
                               onclick="return confirm('Remove this customer account? This cannot be undone.')">
                                <i class="fa-solid fa-user-slash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <?php if($users->num_rows === 0): ?>
                <div style="text-align:center;padding:5rem;color:#444;">
                    <i class="fa-solid fa-users" style="font-size:3rem;margin-bottom:1rem;display:block;"></i>
                    <p>No customers yet. Share your store link to get started.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
</body></html>
