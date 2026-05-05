<?php 
include 'includes/header.php'; 

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$query = "SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";

if($category_id > 0) {
    $query .= " AND p.category_id = $category_id";
}
if(!empty($search)) {
    $query .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
}

$query .= " ORDER BY p.created_at DESC";
$result = $conn->query($query);
?>

<div class="container" style="padding: 4rem 0;">
    <div style="text-align: center; margin-bottom: 4rem;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 1rem;">Our Collection</h2>
        <p style="color: var(--text-muted);">Handpicked premium furniture for the discerning eye.</p>
    </div>

    <div class="shop-layout">
        <!-- Filters Sidebar -->
        <aside class="sidebar animate-up">
            <h3>Categories</h3>
            <ul class="filter-list">
                <li><a href="shop.php" class="<?php echo $category_id == 0 ? 'active' : ''; ?>">All Products</a></li>
                <?php
                $cats = $conn->query("SELECT * FROM categories");
                while($cat = $cats->fetch_assoc()):
                ?>
                    <li><a href="shop.php?category=<?php echo $cat['id']; ?>" class="<?php echo $category_id == $cat['id'] ? 'active' : ''; ?>"><?php echo $cat['name']; ?></a></li>
                <?php endwhile; ?>
            </ul>

            <div style="margin-top: 3rem;">
                <h3 style="border: none; margin-bottom: 1rem;">Search</h3>
                <form action="" method="GET">
                    <input type="text" name="search" class="form-control" style="width: 100%; padding: 0.8rem; background: var(--bg); border: 1px solid var(--border); color: #fff;" placeholder="Find something..." value="<?php echo $search; ?>">
                </form>
            </div>
        </aside>

        <!-- Products List -->
        <main>
            <?php if($result->num_rows > 0): ?>
                <div class="product-grid">
                    <?php while($prod = $result->fetch_assoc()): ?>
                        <div class="product-card animate-up">
                            <div class="product-img">
                                <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>">
                                <div class="product-overlay">
                                    <form action="manage_wishlist.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                        <button type="submit" class="btn-icon"><i class="fa-regular fa-heart"></i></button>
                                    </form>
                                    <form action="manage_cart.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                        <input type="hidden" name="action" value="add">
                                        <button type="submit" class="btn-icon"><i class="fa-solid fa-plus"></i></button>
                                    </form>
                                    <a href="product.php?id=<?php echo $prod['id']; ?>" class="btn-icon"><i class="fa-solid fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="product-info">
                                <span class="product-cat"><?php echo $prod['cat_name']; ?></span>
                                <h3 class="product-name"><?php echo $prod['name']; ?></h3>
                                <p class="product-price"><?php echo CURRENCY . number_format($prod['price'], 2); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 5rem; background: var(--surface); border-radius: 12px; border: 1px dashed var(--border);">
                    <i class="fa-solid fa-couch" style="font-size: 3rem; color: var(--accent); margin-bottom: 1rem;"></i>
                    <p>No products found matching your criteria.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
