<?php
include 'includes/header.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}

$user_id  = $_SESSION['user_id'];
$wish_res = $conn->query("SELECT w.*, p.name, p.price, p.image, c.name as cat_name
                           FROM wishlist w
                           JOIN products p ON w.product_id = p.id
                           JOIN categories c ON p.category_id = c.id
                           WHERE w.user_id = $user_id");
$count = $wish_res->num_rows;
?>

<div class="container" style="padding: 5rem 2rem;">
    <!-- Page Header -->
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:4rem; padding-bottom:2rem; border-bottom:1px solid var(--border);">
        <div>
            <span style="color:var(--primary); letter-spacing:5px; font-size:0.7rem; text-transform:uppercase; font-weight:600; display:block; margin-bottom:0.75rem;">Saved Items</span>
            <h1 style="font-family:'Playfair Display',serif; font-size:2.5rem; margin:0;">My Wishlist</h1>
        </div>
        <div style="display:flex; align-items:center; gap:1rem;">
            <span style="color:var(--text-muted); font-size:0.85rem;"><?php echo $count; ?> Piece<?php echo $count !== 1 ? 's' : ''; ?> Saved</span>
            <a href="shop.php" class="btn btn-outline" style="padding:0.75rem 2rem; font-size:0.8rem; letter-spacing:1.5px;">Continue Shopping</a>
        </div>
    </div>

    <?php if($count > 0): ?>

        <!-- Success/Notice -->
        <?php if(isset($_GET['added'])): ?>
        <div style="background:rgba(76,175,80,0.1); border:1px solid rgba(76,175,80,0.3); color:#4caf50; padding:1rem 1.5rem; border-radius:4px; font-size:0.9rem; margin-bottom:2rem; display:flex; align-items:center; gap:0.75rem;">
            <i class="fa-solid fa-circle-check"></i> Item added to your wishlist.
        </div>
        <?php elseif(isset($_GET['removed'])): ?>
        <div style="background:rgba(255,77,77,0.1); border:1px solid rgba(255,77,77,0.3); color:#ff4d4d; padding:1rem 1.5rem; border-radius:4px; font-size:0.9rem; margin-bottom:2rem; display:flex; align-items:center; gap:0.75rem;">
            <i class="fa-solid fa-circle-check"></i> Item removed from wishlist.
        </div>
        <?php endif; ?>

        <div class="product-grid">
            <?php while($prod = $wish_res->fetch_assoc()): ?>
                <div class="product-card" style="position:relative;">
                    <!-- Remove Button (top-right corner) -->
                    <form action="manage_wishlist.php" method="POST" style="position:absolute; top:1rem; right:1rem; z-index:10;">
                        <input type="hidden" name="product_id" value="<?php echo $prod['product_id']; ?>">
                        <button type="submit" title="Remove from Wishlist"
                                style="width:36px; height:36px; border-radius:50%; background:rgba(0,0,0,0.7); border:none; color:#ff4d4d; cursor:pointer; font-size:0.9rem; display:flex; align-items:center; justify-content:center; transition:all 0.3s;"
                                onmouseover="this.style.background='#ff4d4d'; this.style.color='#fff';"
                                onmouseout="this.style.background='rgba(0,0,0,0.7)'; this.style.color='#ff4d4d';">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>

                    <div class="product-img">
                        <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>">
                        <div class="product-overlay">
                            <a href="product.php?id=<?php echo $prod['product_id']; ?>" class="btn-icon" title="View Details"><i class="fa-solid fa-eye"></i></a>
                        </div>
                    </div>

                    <div class="product-info">
                        <span class="product-cat"><?php echo $prod['cat_name']; ?></span>
                        <h3 class="product-name"><?php echo $prod['name']; ?></h3>
                        <p class="product-price" style="margin-bottom:1.25rem;"><?php echo CURRENCY . number_format($prod['price'], 2); ?></p>

                        <!-- Move to Cart Button -->
                        <form action="manage_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $prod['product_id']; ?>">
                            <input type="hidden" name="action" value="add">
                            <button type="submit" class="btn btn-primary" style="width:100%; padding:0.9rem; font-size:0.8rem; letter-spacing:1.5px;">
                                <i class="fa-solid fa-cart-plus" style="margin-right:8px;"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    <?php else: ?>
        <!-- Empty State -->
        <div style="text-align:center; padding:8rem 2rem; background:var(--surface); border-radius:8px; border:1px dashed var(--border);">
            <div style="width:80px; height:80px; border-radius:50%; background:var(--accent); display:flex; align-items:center; justify-content:center; margin:0 auto 2rem;">
                <i class="fa-regular fa-heart" style="font-size:2rem; color:var(--text-muted);"></i>
            </div>
            <h3 style="font-family:'Playfair Display',serif; font-size:2rem; margin-bottom:1rem;">Your wishlist is empty</h3>
            <p style="color:var(--text-muted); margin-bottom:3rem; max-width:400px; margin-left:auto; margin-right:auto;">Start curating your dream home — save pieces you love and come back to them anytime.</p>
            <a href="shop.php" class="btn btn-primary" style="padding:1.1rem 3rem; letter-spacing:2px;">Discover Collection</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
