<?php
require 'layout.php';

// Update status
if(isset($_POST['update_status'])) {
    $oid    = (int)$_POST['order_id'];
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE orders SET status='$status' WHERE id=$oid");
}

$orders = $conn->query("SELECT o.*, u.name as uname, u.email as uemail FROM orders o JOIN users u ON o.user_id=u.id ORDER BY o.created_at DESC");
?>

    <div class="adm-topbar">
        <h1>Orders</h1>
        <span style="font-size:0.8rem;color:#555;"><?php echo $orders->num_rows; ?> total orders</span>
    </div>

    <div class="adm-content">
        <div class="adm-card">
            <div class="adm-card-body">
                <table class="adm-table">
                    <thead><tr>
                        <th>Order ID</th><th>Customer</th><th>Email</th><th>Amount</th><th>Items</th><th>Status</th><th>Date</th><th style="text-align:center;">Action</th>
                    </tr></thead>
                    <tbody>
                    <?php while($o = $orders->fetch_assoc()):
                        $oid      = $o['id'];
                        $icount   = $conn->query("SELECT COUNT(*) as c FROM order_items WHERE order_id=$oid")->fetch_assoc()['c'];
                    ?>
                    <tr>
                        <td style="color:#c5a059;font-weight:700;">#LUX-<?php echo str_pad($oid,4,'0',STR_PAD_LEFT); ?></td>
                        <td style="font-weight:600;"><?php echo htmlspecialchars($o['uname']); ?></td>
                        <td style="color:#555;font-size:0.82rem;"><?php echo $o['uemail']; ?></td>
                        <td style="font-weight:700;"><?php echo CURRENCY . number_format($o['total_amount'],2); ?></td>
                        <td style="color:#555;"><?php echo $icount; ?> piece<?php echo $icount>1?'s':''; ?></td>
                        <td>
                            <?php
                            $bc = ['completed'=>'badge-green','pending'=>'badge-yellow','cancelled'=>'badge-red'];
                            $cls = $bc[$o['status']] ?? 'badge-yellow';
                            ?>
                            <span class="badge-pill <?php echo $cls; ?>"><?php echo ucfirst($o['status']); ?></span>
                        </td>
                        <td style="color:#555;font-size:0.82rem;"><?php echo date('d M Y', strtotime($o['created_at'])); ?></td>
                        <td style="text-align:center;">
                            <button onclick="document.getElementById('modal_<?php echo $oid; ?>').style.display='flex'"
                                    class="adm-btn adm-btn-ghost" style="font-size:0.75rem;padding:0.45rem 0.9rem;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Per-order Status Modal -->
                    <div id="modal_<?php echo $oid; ?>" style="display:none;" class="adm-modal-overlay" onclick="if(event.target===this)this.style.display='none'">
                        <div class="adm-modal" style="width:420px;">
                            <div class="adm-modal-header">
                                <h2 style="font-family:'Playfair Display',serif;font-size:1.25rem;">Order #LUX-<?php echo str_pad($oid,4,'0',STR_PAD_LEFT); ?></h2>
                                <button onclick="document.getElementById('modal_<?php echo $oid; ?>').style.display='none'" style="background:none;border:none;color:#555;font-size:1.3rem;cursor:pointer;">&times;</button>
                            </div>
                            <div class="adm-modal-body">
                                <?php
                                $items_q = $conn->query("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id=p.id WHERE oi.order_id=$oid");
                                while($item = $items_q->fetch_assoc()):
                                ?>
                                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid rgba(255,255,255,0.06);">
                                    <img src="<?php echo $item['image']; ?>" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                    <div style="flex:1;">
                                        <p style="font-size:0.88rem;font-weight:600;"><?php echo $item['name']; ?></p>
                                        <p style="font-size:0.78rem;color:#555;">Qty: <?php echo $item['quantity']; ?> &times; <?php echo CURRENCY.number_format($item['price'],2); ?></p>
                                    </div>
                                    <p style="color:#c5a059;font-weight:700;"><?php echo CURRENCY.number_format($item['price']*$item['quantity'],2); ?></p>
                                </div>
                                <?php endwhile; ?>

                                <form method="POST" style="margin-top:1.5rem;">
                                    <input type="hidden" name="order_id" value="<?php echo $oid; ?>">
                                    <label class="adm-label">Update Status</label>
                                    <select name="status" class="adm-input" style="margin-bottom:1rem;">
                                        <?php foreach(['pending','completed','cancelled'] as $s): ?>
                                        <option value="<?php echo $s; ?>" <?php echo $o['status']===$s?'selected':''; ?>><?php echo ucfirst($s); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="update_status" class="adm-btn adm-btn-primary" style="width:100%;padding:0.9rem;">Update Order</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</body></html>
