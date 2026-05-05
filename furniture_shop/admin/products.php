<?php
require 'layout.php';

$msg = '';
// Delete
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    $msg = '<div style="background:rgba(76,175,80,0.1);border:1px solid rgba(76,175,80,0.3);color:#4caf50;padding:1rem 1.5rem;border-radius:6px;margin-bottom:2rem;font-size:0.88rem;"><i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>Product deleted successfully.</div>';
}

// Add
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $n  = $conn->real_escape_string($_POST['name']);
    $pr = (float)$_POST['price'];
    $ca = (int)$_POST['category'];
    $de = $conn->real_escape_string($_POST['description']);
    $im = $conn->real_escape_string($_POST['image']);
    $st = (int)$_POST['stock'];
    $conn->query("INSERT INTO products (name, price, category_id, description, image, stock) VALUES ('$n',$pr,$ca,'$de','$im',$st)");
    $msg = '<div style="background:rgba(76,175,80,0.1);border:1px solid rgba(76,175,80,0.3);color:#4caf50;padding:1rem 1.5rem;border-radius:6px;margin-bottom:2rem;font-size:0.88rem;"><i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>Product added successfully.</div>';
}

// Toggle Active/Inactive
if(isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $conn->query("UPDATE products SET is_active = NOT is_active WHERE id=$id");
    $msg = '<div style="background:rgba(76,175,80,0.1);border:1px solid rgba(76,175,80,0.3);color:#4caf50;padding:1rem 1.5rem;border-radius:6px;margin-bottom:2rem;font-size:0.88rem;"><i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>Status updated successfully.</div>';
}

// Update
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $id = (int)$_POST['product_id'];
    $n  = $conn->real_escape_string($_POST['name']);
    $pr = (float)$_POST['price'];
    $ca = (int)$_POST['category'];
    $de = $conn->real_escape_string($_POST['description']);
    $im = $conn->real_escape_string($_POST['image']);
    $st = (int)$_POST['stock'];
    $conn->query("UPDATE products SET name='$n', price=$pr, category_id=$ca, description='$de', image='$im', stock=$st WHERE id=$id");
    $msg = '<div style="background:rgba(76,175,80,0.1);border:1px solid rgba(76,175,80,0.3);color:#4caf50;padding:1rem 1.5rem;border-radius:6px;margin-bottom:2rem;font-size:0.88rem;"><i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>Product updated successfully.</div>';
}

$products   = $conn->query("SELECT p.*, c.name as cat FROM products p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC");
$categories = $conn->query("SELECT * FROM categories");
?>

    <div class="adm-topbar">
        <h1>Inventory</h1>
        <button class="adm-btn adm-btn-primary" onclick="document.getElementById('addModal').style.display='flex'">
            <i class="fa-solid fa-plus" style="margin-right:6px;"></i> Add Product
        </button>
    </div>

    <div class="adm-content">
        <?php echo $msg; ?>
        <div class="adm-card">
            <div class="adm-card-header">
                <h3>All Products <span style="font-size:0.8rem;color:#555;margin-left:0.5rem;">(<?php echo $products->num_rows; ?>)</span></h3>
            </div>
            <div class="adm-card-body">
                <table class="adm-table">
                    <thead><tr>
                        <th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th style="text-align:center;">Actions</th>
                    </tr></thead>
                    <tbody>
                    <?php while($p = $products->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?php echo $p['image']; ?>" style="width:52px;height:52px;object-fit:cover;border-radius:6px;border:1px solid rgba(255,255,255,0.08);"></td>
                        <td style="font-weight:600;max-width:220px;"><span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;"><?php echo htmlspecialchars($p['name']); ?></span></td>
                        <td><span class="badge-pill badge-yellow"><?php echo $p['cat'] ?? '—'; ?></span></td>
                        <td style="color:#c5a059;font-weight:700;"><?php echo CURRENCY . number_format($p['price'],2); ?></td>
                        <td>
                            <span class="badge-pill <?php echo $p['stock'] > 5 ? 'badge-green' : 'badge-red'; ?>">
                                <?php echo $p['stock']; ?> left
                            </span>
                        </td>
                        <td>
                            <?php if($p['is_active']): ?>
                                <span class="badge-pill badge-green">Active</span>
                            <?php else: ?>
                                <span class="badge-pill badge-red">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center; white-space:nowrap;">
                            <button onclick="document.getElementById('modal_edit_<?php echo $p['id']; ?>').style.display='flex'" class="adm-btn adm-btn-ghost" style="font-size:0.75rem;padding:0.5rem 0.8rem;margin-right:4px;" title="View/Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <a href="?toggle=<?php echo $p['id']; ?>" class="adm-btn <?php echo $p['is_active'] ? 'adm-btn-yellow' : 'adm-btn-green'; ?>" style="font-size:0.75rem;padding:0.5rem 0.8rem;margin-right:4px;" title="<?php echo $p['is_active'] ? 'Deactivate' : 'Activate'; ?>">
                                <i class="fa-solid <?php echo $p['is_active'] ? 'fa-ban' : 'fa-check'; ?>"></i>
                            </a>
                            <a href="?delete=<?php echo $p['id']; ?>" class="adm-btn adm-btn-danger" style="font-size:0.75rem;padding:0.5rem 0.8rem;" onclick="return confirm('Delete this product permanently?')" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div id="modal_edit_<?php echo $p['id']; ?>" style="display:none;" class="adm-modal-overlay" onclick="if(event.target===this)this.style.display='none'">
                        <div class="adm-modal" style="text-align:left;">
                            <div class="adm-modal-header">
                                <h2 style="font-family:'Playfair Display',serif;font-size:1.5rem;">Edit Product</h2>
                                <button onclick="document.getElementById('modal_edit_<?php echo $p['id']; ?>').style.display='none'" style="background:none;border:none;color:#555;font-size:1.3rem;cursor:pointer;">&times;</button>
                            </div>
                            <div class="adm-modal-body">
                                <form action="" method="POST">
                                    <input type="hidden" name="update_product" value="1">
                                    <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                    <div style="margin-bottom:1.25rem;">
                                        <label class="adm-label">Product Name</label>
                                        <input type="text" name="name" class="adm-input" value="<?php echo htmlspecialchars($p['name']); ?>" required>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
                                        <div>
                                            <label class="adm-label">Price (<?php echo CURRENCY; ?>)</label>
                                            <input type="number" name="price" step="0.01" class="adm-input" value="<?php echo $p['price']; ?>" required>
                                        </div>
                                        <div>
                                            <label class="adm-label">Stock</label>
                                            <input type="number" name="stock" class="adm-input" value="<?php echo $p['stock']; ?>" required>
                                        </div>
                                    </div>
                                    <div style="margin-bottom:1.25rem;">
                                        <label class="adm-label">Category</label>
                                        <select name="category" class="adm-input" required>
                                            <option value="">— Select Category —</option>
                                            <?php $categories->data_seek(0); while($c=$categories->fetch_assoc()): ?>
                                            <option value="<?php echo $c['id']; ?>" <?php echo $c['id']==$p['category_id']?'selected':''; ?>><?php echo $c['name']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div style="margin-bottom:1.25rem;">
                                        <label class="adm-label">Image URL</label>
                                        <input type="url" name="image" class="adm-input" value="<?php echo htmlspecialchars($p['image']); ?>" required>
                                    </div>
                                    <div style="margin-bottom:2rem;">
                                        <label class="adm-label">Description</label>
                                        <textarea name="description" rows="3" class="adm-input"><?php echo htmlspecialchars($p['description']); ?></textarea>
                                    </div>
                                    <div style="display:flex;gap:1rem;">
                                        <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;padding:1rem;">Update Product</button>
                                        <button type="button" onclick="document.getElementById('modal_edit_<?php echo $p['id']; ?>').style.display='none'" class="adm-btn adm-btn-ghost" style="flex:1;padding:1rem;">Cancel</button>
                                    </div>
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

    <!-- ADD PRODUCT MODAL -->
    <div id="addModal" style="display:none;" class="adm-modal-overlay" onclick="if(event.target===this)this.style.display='none'">
        <div class="adm-modal">
            <div class="adm-modal-header">
                <h2 style="font-family:'Playfair Display',serif;font-size:1.5rem;">Add New Product</h2>
                <button onclick="document.getElementById('addModal').style.display='none'" style="background:none;border:none;color:#555;font-size:1.3rem;cursor:pointer;">&times;</button>
            </div>
            <div class="adm-modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="add_product" value="1">
                    <div style="margin-bottom:1.25rem;">
                        <label class="adm-label">Product Name</label>
                        <input type="text" name="name" class="adm-input" required placeholder="e.g. Velvet Royal Sofa">
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.25rem;">
                        <div>
                            <label class="adm-label">Price (<?php echo CURRENCY; ?>)</label>
                            <input type="number" name="price" step="0.01" class="adm-input" required placeholder="0.00">
                        </div>
                        <div>
                            <label class="adm-label">Stock</label>
                            <input type="number" name="stock" class="adm-input" required placeholder="10">
                        </div>
                    </div>
                    <div style="margin-bottom:1.25rem;">
                        <label class="adm-label">Category</label>
                        <select name="category" class="adm-input" required>
                            <option value="">— Select Category —</option>
                            <?php $categories->data_seek(0); while($c=$categories->fetch_assoc()): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div style="margin-bottom:1.25rem;">
                        <label class="adm-label">Image URL</label>
                        <input type="url" name="image" class="adm-input" required placeholder="https://images.unsplash.com/...">
                    </div>
                    <div style="margin-bottom:2rem;">
                        <label class="adm-label">Description</label>
                        <textarea name="description" rows="3" class="adm-input" placeholder="Short product description..."></textarea>
                    </div>
                    <div style="display:flex;gap:1rem;">
                        <button type="submit" class="adm-btn adm-btn-primary" style="flex:1;padding:1rem;">Add Product</button>
                        <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="adm-btn adm-btn-ghost" style="flex:1;padding:1rem;">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</body></html>
