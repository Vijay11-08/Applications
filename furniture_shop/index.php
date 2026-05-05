<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section style="min-height: 90vh; background: linear-gradient(to right, rgba(0,0,0,0.85) 50%, rgba(0,0,0,0.3)), url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?auto=format&fit=crop&w=1920&q=80') center/cover; display: flex; align-items: center;">
    <div class="container" style="padding: 6rem 2rem;">
        <div style="max-width: 650px;">
            <span style="display: inline-block; color: var(--primary); letter-spacing: 5px; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; margin-bottom: 2rem; border: 1px solid var(--primary); padding: 0.5rem 1.5rem;">Premium Collection 2026</span>
            <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(3rem, 7vw, 5.5rem); line-height: 1.05; margin-bottom: 2rem; font-weight: 700;">Art of Living,<br><em style="font-style: italic; color: var(--primary);">Defined by You</em></h1>
            <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 3.5rem; line-height: 1.8; max-width: 500px;">Experience the harmony of artisanal craftsmanship and contemporary design. Every piece tells a story of timeless elegance.</p>
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                <a href="shop.php" class="btn btn-primary" style="padding: 1.2rem 3rem; font-size: 0.85rem; letter-spacing: 2px;">Explore Atelier</a>
                <a href="#categories" class="btn btn-outline" style="padding: 1.2rem 3rem; font-size: 0.85rem; letter-spacing: 2px;">Our Categories</a>
            </div>
        </div>
    </div>
</section>

<!-- Trust Bar -->
<div style="background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0;">
        <?php 
        $perks = [
            ['icon' => 'fa-truck-fast', 'title' => 'White Glove Delivery', 'desc' => 'Complimentary nationwide'],
            ['icon' => 'fa-shield-check', 'title' => '10 Year Guarantee', 'desc' => 'On every artifact'],
            ['icon' => 'fa-rotate-left', 'title' => '30 Day Returns', 'desc' => 'Hassle-free returns'],
            ['icon' => 'fa-headset', 'title' => 'Expert Concierge', 'desc' => 'Mon–Sat, 9am–8pm'],
        ];
        foreach($perks as $perk): ?>
        <div style="padding: 2rem; text-align: center; border-right: 1px solid var(--border);">
            <i class="fa-solid <?php echo $perk['icon']; ?>" style="font-size: 1.5rem; color: var(--primary); margin-bottom: 1rem; display: block;"></i>
            <p style="font-weight: 600; font-size: 0.9rem; margin-bottom: 0.3rem;"><?php echo $perk['title']; ?></p>
            <p style="color: var(--text-muted); font-size: 0.75rem;"><?php echo $perk['desc']; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Categories Section -->
<section id="categories" style="padding: 8rem 0; background: var(--bg);">
    <div class="container">
        <div style="text-align: center; margin-bottom: 5rem;">
            <span style="color: var(--primary); letter-spacing: 5px; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 1rem;">Browse By Room</span>
            <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 1rem;">Our Collections</h2>
            <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto;">From intimate nooks to grand salons — furniture for every corner of your world.</p>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; grid-template-rows: 280px 280px; gap: 1.5rem;">
            <?php
            $cat_map = [
                1 => ['img' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=80', 'span' => 'grid-row: 1 / span 2;'],
                2 => ['img' => 'https://images.unsplash.com/photo-1505693419173-42b92588627e?auto=format&fit=crop&w=600&q=80', 'span' => ''],
                3 => ['img' => 'https://images.unsplash.com/photo-1592078615290-033ee584e267?auto=format&fit=crop&w=600&q=80', 'span' => ''],
                4 => ['img' => 'https://images.unsplash.com/photo-1577145946459-39f504e7194e?auto=format&fit=crop&w=600&q=80', 'span' => ''],
                5 => ['img' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=600&q=80', 'span' => ''],
            ];
            $cats = $conn->query("SELECT * FROM categories");
            while($cat = $cats->fetch_assoc()):
                $info = $cat_map[$cat['id']] ?? ['img' => '', 'span' => ''];
            ?>
            <a href="shop.php?category=<?php echo $cat['id']; ?>" style="position: relative; overflow: hidden; border-radius: 4px; display: block; <?php echo $info['span']; ?>">
                <img src="<?php echo $info['img']; ?>" alt="<?php echo $cat['name']; ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 20%, transparent); display: flex; flex-direction: column; justify-content: flex-end; padding: 2rem;">
                    <span style="color: var(--primary); font-size: 0.7rem; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 0.5rem;"><?php echo $cat['name']; ?></span>
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; color: #fff; margin-bottom: 0.75rem;">Shop <?php echo $cat['name']; ?>s</h3>
                    <span style="color: var(--text-muted); font-size: 0.8rem;">Explore →</span>
                </div>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section style="padding: 8rem 0; background: var(--surface);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 5rem;">
            <div>
                <span style="color: var(--primary); letter-spacing: 5px; font-size: 0.75rem; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 1rem;">Handpicked</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0;">Featured Artifacts</h2>
            </div>
            <a href="shop.php" style="color: var(--primary); letter-spacing: 2px; font-size: 0.8rem; text-transform: uppercase; border-bottom: 1px solid var(--primary); padding-bottom: 3px;">View All Collection →</a>
        </div>
        <div class="product-grid">
            <?php
            $prod_res = $conn->query("SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC LIMIT 4");
            while($prod = $prod_res->fetch_assoc()): ?>
                <div class="product-card" style="opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease;" data-reveal>
                    <div class="product-img">
                        <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>">
                        <div class="product-overlay">
                            <form action="manage_wishlist.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                <button type="submit" class="btn-icon" title="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                            </form>
                            <form action="manage_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="btn-icon" title="Add to Cart"><i class="fa-solid fa-cart-plus"></i></button>
                            </form>
                            <a href="product.php?id=<?php echo $prod['id']; ?>" class="btn-icon" title="View"><i class="fa-solid fa-eye"></i></a>
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
    </div>
</section>

<!-- Interior Quote Banner -->
<section style="padding: 8rem 0; background: url('https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=1920&q=80') center/cover fixed; position: relative;">
    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.75);"></div>
    <div class="container" style="position: relative; z-index: 2; text-align: center;">
        <p style="font-family: 'Playfair Display', serif; font-style: italic; font-size: clamp(1.5rem, 4vw, 2.5rem); color: #fff; max-width: 800px; margin: 0 auto 2rem; line-height: 1.6;">"A room should feel like a sanctuary — every piece you choose should speak to who you are."</p>
        <a href="shop.php" class="btn btn-primary" style="padding: 1.2rem 3.5rem; letter-spacing: 2px;">Begin Your Journey</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script>
// Scroll reveal
const reveals = document.querySelectorAll('[data-reveal]');
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.style.opacity = '1';
            e.target.style.transform = 'translateY(0)';
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// Category card zoom on hover
document.querySelectorAll('[href*="shop.php?category"] img').forEach(img => {
    img.parentElement.addEventListener('mouseenter', () => img.style.transform = 'scale(1.06)');
    img.parentElement.addEventListener('mouseleave', () => img.style.transform = 'scale(1)');
});
</script>
