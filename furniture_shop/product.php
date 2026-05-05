<?php 
include 'includes/header.php'; 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = $conn->query("SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = $id");

if($result->num_rows == 0) {
    header('Location: shop.php');
    exit;
}

$prod = $result->fetch_assoc();
?>

<div class="container" style="padding-top: 5rem; padding-bottom: 5rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
        <div class="product-img-large animate-fade" style="border-radius: 12px; overflow: hidden; border: 1px solid var(--accent-color);">
            <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>" style="width: 100%; height: 500px; object-fit: cover;">
        </div>

        <div class="product-details animate-fade">
            <span class="product-category" style="font-size: 1rem;"><?php echo $prod['cat_name']; ?></span>
            <h1 style="font-size: 3rem; margin-bottom: 1rem; color: var(--primary-color);"><?php echo $prod['name']; ?></h1>
            <p style="font-size: 2rem; font-weight: 700; margin-bottom: 2rem;"><?php echo CURRENCY . number_format($prod['price'], 2); ?></p>
            
            <div style="margin-bottom: 2.5rem;">
                <h3 style="margin-bottom: 10px; color: var(--text-muted);">Description</h3>
                <p style="line-height: 1.8; color: var(--text-color);"><?php echo $prod['description']; ?></p>
            </div>

            <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 2.5rem;">
                <div style="display: flex; background: var(--accent-color); border-radius: 4px; padding: 5px;">
                    <button class="qty-btn" style="background: none; border: none; color: white; padding: 10px 15px; cursor: pointer;">-</button>
                    <input type="number" value="1" style="width: 50px; text-align: center; background: none; border: none; color: white; font-weight: 700;" readonly>
                    <button class="qty-btn" style="background: none; border: none; color: white; padding: 10px 15px; cursor: pointer;">+</button>
                </div>
                <span style="color: var(--text-muted);">Stock: <?php echo $prod['stock']; ?> items available</span>
            </div>

            <div style="display: flex; gap: 20px;">
                <form action="manage_cart.php" method="POST" style="flex: 2;">
                    <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                    <input type="hidden" name="action" value="add">
                    <button type="submit" class="btn" style="width: 100%; padding: 15px;">Add to Cart</button>
                </form>
                <form action="manage_wishlist.php" method="POST" style="flex: 1;">
                    <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                    <button type="submit" class="btn btn-outline" style="width: 100%; padding: 15px;"><i class="fa-regular fa-heart"></i></button>
                </form>
            </div>

            <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--accent-color);">
                <div style="display: flex; gap: 30px;">
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-truck-fast" style="color: var(--primary-color);"></i>
                        <span>Free Shipping</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-shield-check" style="color: var(--primary-color);"></i>
                        <span>2 Year Warranty</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; font-size: 0.9rem;">
                        <i class="fa-solid fa-rotate-left" style="color: var(--primary-color);"></i>
                        <span>30 Day Returns</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
