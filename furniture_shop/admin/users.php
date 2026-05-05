<?php
require 'layout.php';

// Delete user
if(isset($_GET['delete'])) {
    $uid = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$uid AND role='user'");
}

// Toggle active/inactive
if(isset($_GET['toggle'])) {
    $uid = (int)$_GET['toggle'];
    $conn->query("UPDATE users SET is_active = NOT is_active WHERE id=$uid AND role='user'");
}

// Update user
if(isset($_POST['update_user'])) {
    $uid = (int)$_POST['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$uid AND role='user'");
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
                        <th>ID</th><th>Name</th><th>Email</th><th>Orders</th><th>Total Spent</th><th>Status</th><th>Member Since</th><th style="text-align:center;">Actions</th>
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
                        <td>
                            <?php if($u['is_active']): ?>
                                <span class="badge-pill badge-green">Active</span>
                            <?php else: ?>
                                <span class="badge-pill badge-red">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <button onclick="document.getElementById('modal_<?php echo $u['id']; ?>').style.display='flex'" class="adm-btn adm-btn-ghost" style="font-size:0.75rem;padding:0.45rem 0.9rem;margin-right:4px;" title="View/Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <a href="?toggle=<?php echo $u['id']; ?>" class="adm-btn <?php echo $u['is_active'] ? 'adm-btn-yellow' : 'adm-btn-green'; ?>" style="font-size:0.75rem;padding:0.45rem 0.9rem;margin-right:4px;" title="<?php echo $u['is_active'] ? 'Deactivate' : 'Activate'; ?>">
                                <i class="fa-solid <?php echo $u['is_active'] ? 'fa-ban' : 'fa-check'; ?>"></i>
                            </a>
                            <a href="?delete=<?php echo $u['id']; ?>" 
                               class="adm-btn adm-btn-danger" 
                               style="font-size:0.75rem;padding:0.45rem 0.9rem;"
                               onclick="return confirm('Remove this customer account? This cannot be undone.')" title="Delete">
                                <i class="fa-solid fa-user-slash"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- View/Edit Modal -->
                    <div id="modal_<?php echo $u['id']; ?>" style="display:none;" class="adm-modal-overlay" onclick="if(event.target===this)this.style.display='none'">
                        <div class="adm-modal" style="width:400px;text-align:left;">
                            <div class="adm-modal-header">
                                <h2 style="font-family:'Playfair Display',serif;font-size:1.25rem;">Edit Customer</h2>
                                <button onclick="document.getElementById('modal_<?php echo $u['id']; ?>').style.display='none'" style="background:none;border:none;color:#555;font-size:1.3rem;cursor:pointer;">&times;</button>
                            </div>
                            <div class="adm-modal-body">
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                    <div style="margin-bottom:1rem;">
                                        <label class="adm-label">Name</label>
                                        <input type="text" name="name" class="adm-input" value="<?php echo htmlspecialchars($u['name']); ?>" required>
                                    </div>
                                    <div style="margin-bottom:1.5rem;">
                                        <label class="adm-label">Email</label>
                                        <input type="email" name="email" class="adm-input" value="<?php echo htmlspecialchars($u['email']); ?>" required>
                                    </div>
                                    <button type="submit" name="update_user" class="adm-btn adm-btn-primary" style="width:100%;padding:0.9rem;">Update Details</button>
                                </form>
                            </div>
                        </div>
                    </div>
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
