<?php
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$user_id  = $_SESSION['user_id'];
$cart_res = $conn->query("SELECT c.*, p.name, p.price, p.image FROM cart c JOIN products p ON c.product_id=p.id WHERE c.user_id=$user_id");
if($cart_res->num_rows == 0) { header('Location: cart.php'); exit; }

$items = []; $subtotal = 0;
while($row = $cart_res->fetch_assoc()) { $items[] = $row; $subtotal += $row['price'] * $row['quantity']; }

$success = false; $error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname   = $conn->real_escape_string($_POST['first_name']);
    $lname   = $conn->real_escape_string($_POST['last_name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city    = $conn->real_escape_string($_POST['city']);
    $pin     = $conn->real_escape_string($_POST['pincode']);
    $payment = $conn->real_escape_string($_POST['payment_method']);

    $conn->begin_transaction();
    try {
        $conn->query("INSERT INTO orders (user_id, total_amount, status) VALUES ($user_id, $subtotal, 'completed')");
        $order_id = $conn->insert_id;
        foreach($items as $item) {
            $pid = $item['product_id']; $price = $item['price']; $qty = $item['quantity'];
            $conn->query("INSERT INTO order_items (order_id, product_id, price, quantity) VALUES ($order_id, $pid, $price, $qty)");
        }
        $conn->query("DELETE FROM cart WHERE user_id=$user_id");
        $conn->commit();
        $success = true;
    } catch(Exception $e) { $conn->rollback(); $error = "Order failed. Please try again."; }
}
?>

<?php if($success): ?>
<!-- Success State -->
<div style="min-height:80vh; display:flex; align-items:center; justify-content:center; background:var(--bg);">
    <div style="text-align:center; max-width:500px; padding:4rem 2rem;">
        <div style="width:100px; height:100px; border-radius:50%; background:rgba(76,175,80,0.1); border:2px solid #4caf50; display:flex; align-items:center; justify-content:center; margin:0 auto 2.5rem;">
            <i class="fa-solid fa-check" style="font-size:2.5rem; color:#4caf50;"></i>
        </div>
        <h1 style="font-family:'Playfair Display',serif; font-size:2.5rem; margin-bottom:1rem;">Order Confirmed</h1>
        <p style="color:var(--text-muted); font-size:1rem; line-height:1.8; margin-bottom:3rem;">Thank you for your purchase. Your artifacts will be delivered with white-glove care. A confirmation has been sent to your email.</p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="orders.php" class="btn btn-primary" style="padding:1rem 2.5rem; letter-spacing:1.5px; font-size:0.85rem;">View My Orders</a>
            <a href="shop.php" class="btn btn-outline" style="padding:1rem 2.5rem; letter-spacing:1.5px; font-size:0.85rem;">Continue Shopping</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<?php exit; endif; ?>

<div style="background:var(--bg); padding:5rem 0;">
<div class="container" style="padding:0 2rem;">

    <!-- Page Title -->
    <div style="margin-bottom:4rem;">
        <span style="color:var(--primary); letter-spacing:5px; font-size:0.7rem; text-transform:uppercase; font-weight:600; display:block; margin-bottom:0.75rem;">Final Step</span>
        <h1 style="font-family:'Playfair Display',serif; font-size:2.5rem; margin:0;">Secure Checkout</h1>
    </div>

    <?php if($error): ?>
    <div style="background:rgba(255,77,77,0.1); border:1px solid rgba(255,77,77,0.3); color:#ff4d4d; padding:1rem 1.5rem; margin-bottom:2rem; font-size:0.9rem; display:flex; gap:0.75rem; align-items:center; border-radius:4px;">
        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <form action="" method="POST">
    <div style="display:grid; grid-template-columns:1fr 420px; gap:4rem; align-items:start;">

        <!-- LEFT: FORM -->
        <div>
            <!-- Delivery Details -->
            <div style="background:var(--surface); border:1px solid var(--border); border-radius:8px; padding:2.5rem; margin-bottom:2rem;">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:2rem; display:flex; align-items:center; gap:1rem;">
                    <span style="width:36px; height:36px; background:var(--primary); color:#000; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.9rem; font-weight:700;">1</span>
                    Delivery Details
                </h2>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                    <?php
                    $fields = [
                        ['first_name','First Name','text','John'],
                        ['last_name','Last Name','text','Doe'],
                        ['email','Email Address','email','your@email.com'],
                        ['phone','Phone Number','tel','+91 00000 00000'],
                    ];
                    foreach($fields as $f): ?>
                    <div>
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;"><?php echo $f[1]; ?></label>
                        <input type="<?php echo $f[2]; ?>" name="<?php echo $f[0]; ?>" required placeholder="<?php echo $f[3]; ?>"
                               style="width:100%; background:var(--bg); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; transition:border-color 0.3s; font-family:'Montserrat',sans-serif;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <?php endforeach; ?>
                    <div style="grid-column:1/-1;">
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;">Full Address</label>
                        <textarea name="address" required rows="2" placeholder="Street address, apartment, building..."
                                  style="width:100%; background:var(--bg); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; resize:none; font-family:'Montserrat',sans-serif; transition:border-color 0.3s;"
                                  onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'"></textarea>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;">City</label>
                        <input type="text" name="city" required placeholder="Mumbai"
                               style="width:100%; background:var(--bg); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; transition:border-color 0.3s; font-family:'Montserrat',sans-serif;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;">PIN Code</label>
                        <input type="text" name="pincode" required placeholder="400001"
                               style="width:100%; background:var(--bg); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; transition:border-color 0.3s; font-family:'Montserrat',sans-serif;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div style="background:var(--surface); border:1px solid var(--border); border-radius:8px; padding:2.5rem;">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; margin-bottom:2rem; display:flex; align-items:center; gap:1rem;">
                    <span style="width:36px; height:36px; background:var(--primary); color:#000; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.9rem; font-weight:700;">2</span>
                    Payment Method
                </h2>

                <?php
                $methods = [
                    ['cod',   'fa-hand-holding-dollar', 'Cash on Delivery',    'Pay securely when your order arrives at your door.'],
                    ['card',  'fa-credit-card',         'Credit / Debit Card',  'Visa, Mastercard, American Express accepted.'],
                    ['upi',   'fa-mobile-screen-button','UPI Payment',          'Pay instantly via GPay, PhonePe, BHIM & more.'],
                    ['wallet','fa-wallet',              'Digital Wallet',       'Paytm, Amazon Pay and other wallets accepted.'],
                ];
                foreach($methods as $i => $m): ?>
                <label style="display:flex; align-items:center; gap:1.5rem; padding:1.25rem 1.5rem; border:1px solid var(--border); border-radius:6px; cursor:pointer; margin-bottom:1rem; transition:all 0.3s; background:var(--bg);"
                       onmouseover="this.style.borderColor='var(--primary)'" onmouseout="if(!this.querySelector('input').checked) this.style.borderColor='var(--border)'"
                       id="lbl_<?php echo $m[0]; ?>">
                    <input type="radio" name="payment_method" value="<?php echo $m[0]; ?>" <?php echo $i===0?'checked':''; ?>
                           style="accent-color:var(--primary); width:18px; height:18px;"
                           onchange="document.querySelectorAll('[id^=lbl_]').forEach(l=>l.style.borderColor='var(--border)'); this.closest('label').style.borderColor='var(--primary)'">
                    <div style="width:44px; height:44px; background:rgba(197,160,89,0.1); border-radius:6px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fa-solid <?php echo $m[1]; ?>" style="color:var(--primary); font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <p style="font-weight:600; font-size:0.95rem; margin-bottom:0.2rem;"><?php echo $m[2]; ?></p>
                        <p style="color:var(--text-muted); font-size:0.8rem;"><?php echo $m[3]; ?></p>
                    </div>
                </label>
                <?php endforeach; ?>

                <!-- Card Fields (shown when Card is selected) -->
                <div id="card_fields" style="display:none; margin-top:1.5rem; padding:1.5rem; background:var(--bg); border:1px solid var(--border); border-radius:6px;">
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;">Card Number</label>
                        <input type="text" placeholder="0000 0000 0000 0000" maxlength="19"
                               style="width:100%; background:var(--surface); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; font-family:'Montserrat',sans-serif;">
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div>
                            <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;">Expiry</label>
                            <input type="text" placeholder="MM / YY" maxlength="7"
                                   style="width:100%; background:var(--surface); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; font-family:'Montserrat',sans-serif;">
                        </div>
                        <div>
                            <label style="display:block; font-size:0.75rem; text-transform:uppercase; letter-spacing:2px; color:var(--text-muted); margin-bottom:0.6rem;">CVV</label>
                            <input type="password" placeholder="•••" maxlength="4"
                                   style="width:100%; background:var(--surface); border:1px solid var(--border); color:#fff; padding:0.9rem 1rem; font-size:0.9rem; outline:none; border-radius:4px; font-family:'Montserrat',sans-serif;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: ORDER SUMMARY -->
        <div style="position:sticky; top:120px;">
            <div style="background:var(--surface); border:1px solid var(--border); border-radius:8px; overflow:hidden;">
                <div style="padding:2rem 2rem 1.5rem; border-bottom:1px solid var(--border);">
                    <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; margin:0;">Order Summary</h2>
                    <p style="color:var(--text-muted); font-size:0.8rem; margin-top:0.3rem;"><?php echo count($items); ?> item<?php echo count($items)>1?'s':''; ?></p>
                </div>

                <!-- Items List -->
                <div style="padding:1.5rem 2rem; max-height:350px; overflow-y:auto;">
                    <?php foreach($items as $item): ?>
                    <div style="display:flex; gap:1.25rem; align-items:center; margin-bottom:1.5rem;">
                        <div style="position:relative; flex-shrink:0;">
                            <img src="<?php echo $item['image']; ?>" style="width:65px; height:65px; object-fit:cover; border-radius:6px; border:1px solid var(--border);">
                            <span style="position:absolute; top:-8px; right:-8px; background:var(--primary); color:#000; width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.7rem; font-weight:700;"><?php echo $item['quantity']; ?></span>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <p style="font-weight:600; font-size:0.9rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo $item['name']; ?></p>
                            <p style="color:var(--text-muted); font-size:0.8rem;">Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <p style="font-weight:700; font-size:0.95rem; color:var(--primary); flex-shrink:0;"><?php echo CURRENCY . number_format($item['price'] * $item['quantity'], 2); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Totals -->
                <div style="padding:1.5rem 2rem; border-top:1px solid var(--border); background:var(--bg);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                        <span style="color:var(--text-muted); font-size:0.9rem;">Subtotal</span>
                        <span style="font-size:0.9rem;"><?php echo CURRENCY . number_format($subtotal, 2); ?></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                        <span style="color:var(--text-muted); font-size:0.9rem;">White Glove Delivery</span>
                        <span style="color:#4caf50; font-size:0.9rem; font-weight:600;">FREE</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                        <span style="color:var(--text-muted); font-size:0.9rem;">Tax (GST 18%)</span>
                        <span style="font-size:0.9rem;"><?php echo CURRENCY . number_format($subtotal * 0.18, 2); ?></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding-top:1rem; border-top:1px solid var(--border);">
                        <span style="font-family:'Playfair Display',serif; font-size:1.25rem;">Total</span>
                        <span style="font-family:'Playfair Display',serif; font-size:1.5rem; color:var(--primary); font-weight:700;"><?php echo CURRENCY . number_format($subtotal * 1.18, 2); ?></span>
                    </div>
                </div>

                <!-- Submit -->
                <div style="padding:1.5rem 2rem;">
                    <button type="submit" class="btn btn-primary" style="width:100%; padding:1.2rem; font-size:0.9rem; letter-spacing:2px; text-transform:uppercase;">
                        <i class="fa-solid fa-shield-check" style="margin-right:8px;"></i> Place Secure Order
                    </button>
                    <p style="text-align:center; color:var(--text-muted); font-size:0.75rem; margin-top:1rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                        <i class="fa-solid fa-lock"></i> 256-bit SSL Encrypted &amp; Secure
                    </p>
                </div>
            </div>

            <!-- Trust Badges -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-top:1.5rem;">
                <?php
                $badges = [
                    ['fa-rotate-left','30-Day Returns'],
                    ['fa-truck-fast','Free Delivery'],
                    ['fa-shield-check','Secure Payment'],
                    ['fa-headset','24/7 Support'],
                ];
                foreach($badges as $b): ?>
                <div style="background:var(--surface); border:1px solid var(--border); border-radius:6px; padding:1rem; display:flex; align-items:center; gap:0.75rem;">
                    <i class="fa-solid <?php echo $b[0]; ?>" style="color:var(--primary); font-size:1rem;"></i>
                    <span style="font-size:0.75rem; color:var(--text-muted);"><?php echo $b[1]; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    </form>
</div>
</div>

<script>
// Show/hide card fields
document.querySelectorAll('input[name="payment_method"]').forEach(r => {
    r.addEventListener('change', () => {
        document.getElementById('card_fields').style.display = r.value === 'card' ? 'block' : 'none';
        // Update label borders
        document.querySelectorAll('[id^=lbl_]').forEach(l => l.style.borderColor = 'var(--border)');
        r.closest('label').style.borderColor = 'var(--primary)';
    });
});
// Set initial border for default (COD)
document.getElementById('lbl_cod').style.borderColor = 'var(--primary)';

// Card number formatting
const cardInput = document.querySelector('input[placeholder="0000 0000 0000 0000"]');
if(cardInput) {
    cardInput.addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g,'').substring(0,16);
        e.target.value = v.replace(/(.{4})/g,'$1 ').trim();
    });
}
</script>

<?php include 'includes/footer.php'; ?>
