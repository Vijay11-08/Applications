<?php
include 'includes/header.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$user_id  = $_SESSION['user_id'];
$cart_res = $conn->query("SELECT c.*, p.name, p.price, p.image, c.product_id FROM cart c JOIN products p ON c.product_id=p.id WHERE c.user_id=$user_id");
$total = 0;
?>

<div style="background:var(--bg); padding:5rem 0;">
<div class="container" style="padding:0 2rem;">

    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:4rem; padding-bottom:2rem; border-bottom:1px solid var(--border);">
        <div>
            <span style="color:var(--primary); letter-spacing:5px; font-size:0.7rem; text-transform:uppercase; font-weight:600; display:block; margin-bottom:0.75rem;">Your Selection</span>
            <h1 style="font-family:'Playfair Display',serif; font-size:2.5rem; margin:0;">Shopping Cart</h1>
        </div>
        <a href="shop.php" class="btn btn-outline" style="padding:0.75rem 2rem; font-size:0.8rem; letter-spacing:1.5px;">Continue Shopping</a>
    </div>

    <?php if($cart_res->num_rows > 0):
        $items = [];
        while($row = $cart_res->fetch_assoc()) { $items[] = $row; $total += $row['price'] * $row['quantity']; }
    ?>
    <div style="display:grid; grid-template-columns:1fr 380px; gap:4rem; align-items:start;">

        <!-- Cart Items Table -->
        <div>
            <?php foreach($items as $item): ?>
            <div style="display:grid; grid-template-columns:100px 1fr auto; gap:2rem; align-items:center; padding:2rem 0; border-bottom:1px solid var(--border);">

                <!-- Product Image -->
                <a href="product.php?id=<?php echo $item['product_id']; ?>">
                    <img src="<?php echo $item['image']; ?>" style="width:100px; height:100px; object-fit:cover; border-radius:6px; border:1px solid var(--border);">
                </a>

                <!-- Product Info + Qty Controls -->
                <div>
                    <a href="product.php?id=<?php echo $item['product_id']; ?>">
                        <h3 style="font-family:'Playfair Display',serif; font-size:1.2rem; margin-bottom:0.4rem;"><?php echo $item['name']; ?></h3>
                    </a>
                    <p style="color:var(--text-muted); font-size:0.85rem; margin-bottom:1.25rem;"><?php echo CURRENCY . number_format($item['price'], 2); ?> / unit</p>

                    <!-- +/- Quantity Controls -->
                    <div style="display:flex; align-items:center; gap:0;">
                        <form action="manage_cart.php" method="POST" style="display:contents;">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="quantity" value="<?php echo max(1, $item['quantity']-1); ?>">
                            <button type="submit"
                                    style="width:38px; height:38px; background:var(--surface); border:1px solid var(--border); color:#fff; cursor:pointer; font-size:1.1rem; display:flex; align-items:center; justify-content:center; border-radius:4px 0 0 4px; transition:all 0.2s;"
                                    onmouseover="this.style.background='var(--accent)'; this.style.borderColor='var(--primary)';"
                                    onmouseout="this.style.background='var(--surface)'; this.style.borderColor='var(--border)';">
                                <i class="fa-solid fa-minus" style="font-size:0.7rem;"></i>
                            </button>
                        </form>
                        <span style="width:50px; height:38px; background:var(--bg); border-top:1px solid var(--border); border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.95rem;"><?php echo $item['quantity']; ?></span>
                        <form action="manage_cart.php" method="POST" style="display:contents;">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity']+1; ?>">
                            <button type="submit"
                                    style="width:38px; height:38px; background:var(--surface); border:1px solid var(--border); color:#fff; cursor:pointer; font-size:1.1rem; display:flex; align-items:center; justify-content:center; border-radius:0 4px 4px 0; transition:all 0.2s;"
                                    onmouseover="this.style.background='var(--accent)'; this.style.borderColor='var(--primary)';"
                                    onmouseout="this.style.background='var(--surface)'; this.style.borderColor='var(--border)';">
                                <i class="fa-solid fa-plus" style="font-size:0.7rem;"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Subtotal + Remove -->
                <div style="text-align:right;">
                    <p style="font-family:'Playfair Display',serif; font-size:1.4rem; color:var(--primary); font-weight:700; margin-bottom:0.75rem;">
                        <?php echo CURRENCY . number_format($item['price'] * $item['quantity'], 2); ?>
                    </p>
                    <form action="manage_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                        <input type="hidden" name="action" value="remove">
                        <button type="submit" style="background:none; border:none; color:var(--text-muted); cursor:pointer; font-size:0.8rem; display:flex; align-items:center; gap:0.4rem; margin-left:auto; transition:color 0.3s;"
                                onmouseover="this.style.color='#ff4d4d'" onmouseout="this.style.color='var(--text-muted)'">
                            <i class="fa-solid fa-xmark"></i> Remove
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Wishlist Quick-Add -->
            <div style="margin-top:2rem; padding:1.5rem; background:var(--surface); border-radius:8px; border:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; align-items:center; gap:0.75rem; color:var(--text-muted); font-size:0.85rem;">
                    <i class="fa-regular fa-heart" style="color:var(--primary);"></i>
                    Items you love can also be saved to your wishlist
                </div>
                <a href="wishlist.php" style="color:var(--primary); font-size:0.85rem; display:flex; align-items:center; gap:0.4rem;">View Wishlist <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
            </div>
        </div>

        <!-- Order Summary -->
        <div style="position:sticky; top:120px; background:var(--surface); border:1px solid var(--border); border-radius:8px; overflow:hidden;">
            <div style="padding:2rem; border-bottom:1px solid var(--border);">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.5rem; margin:0;">Summary</h2>
            </div>
            <div style="padding:2rem;">
                <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                    <span style="color:var(--text-muted); font-size:0.9rem;">Subtotal (<?php echo count($items); ?> items)</span>
                    <span style="font-size:0.9rem;"><?php echo CURRENCY . number_format($total, 2); ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:1rem;">
                    <span style="color:var(--text-muted); font-size:0.9rem;">Delivery</span>
                    <span style="color:#4caf50; font-size:0.9rem; font-weight:600;">FREE</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:2rem; padding-top:1rem; border-top:1px solid var(--border);">
                    <span style="font-family:'Playfair Display',serif; font-size:1.2rem;">Total</span>
                    <span style="font-family:'Playfair Display',serif; font-size:1.5rem; color:var(--primary); font-weight:700;"><?php echo CURRENCY . number_format($total, 2); ?></span>
                </div>
                <a href="checkout.php" class="btn btn-primary" style="display:block; width:100%; text-align:center; padding:1.1rem; font-size:0.85rem; letter-spacing:2px;">
                    Proceed to Checkout
                </a>
                <p style="text-align:center; color:var(--text-muted); font-size:0.75rem; margin-top:1rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;">
                    <i class="fa-solid fa-lock"></i> Secure & Encrypted Checkout
                </p>
            </div>
        </div>

    </div>

    <?php else: ?>
    <!-- Empty Cart -->
    <div style="text-align:center; padding:8rem 2rem; background:var(--surface); border-radius:8px; border:1px dashed var(--border);">
        <div style="width:80px; height:80px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; margin:0 auto 2rem;">
            <i class="fa-solid fa-cart-shopping" style="font-size:2rem; color:var(--text-muted);"></i>
        </div>
        <h3 style="font-family:'Playfair Display',serif; font-size:2rem; margin-bottom:1rem;">Your cart is empty</h3>
        <p style="color:var(--text-muted); margin-bottom:3rem; max-width:400px; margin-left:auto; margin-right:auto;">Discover our curated collection of premium furniture pieces.</p>
        <a href="shop.php" class="btn btn-primary" style="padding:1.1rem 3rem; letter-spacing:2px;">Discover Collection</a>
    </div>
    <?php endif; ?>

</div>
</div>

<?php include 'includes/footer.php'; ?>
