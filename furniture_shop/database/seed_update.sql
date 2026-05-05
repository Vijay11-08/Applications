-- Reset Products for a fresh start
TRUNCATE TABLE order_items;
TRUNCATE TABLE cart;
TRUNCATE TABLE wishlist;
DELETE FROM products;
ALTER TABLE products AUTO_INCREMENT = 1;

-- Seed Products (5 per category)

-- 1. SOFAS
INSERT INTO products (category_id, name, description, price, image, stock) VALUES 
(1, 'Velvet Royal Sofa', 'Deep emerald velvet with gold-finished legs. The pinnacle of luxury comfort.', 1299.99, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80', 10),
(1, 'Nordic Cloud Sectional', 'Ultra-soft fabric sectional in misty gray. Perfect for family lounging.', 849.50, 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=800&q=80', 5),
(1, 'Tan Leather Classic', 'Top-grain Italian leather sofa that ages beautifully with time.', 1800.00, 'https://images.unsplash.com/photo-1550254478-ead40cc54513?auto=format&fit=crop&w=800&q=80', 3),
(1, 'Mid-Century Modern Duo', 'Two-seater sofa with walnut wood frame and teal upholstery.', 750.00, 'https://images.unsplash.com/photo-1567016432779-094069958ad5?auto=format&fit=crop&w=800&q=80', 8),
(1, 'Minimalist Studio Sofa', 'Compact and sleek design, ideal for modern urban apartments.', 499.00, 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&w=800&q=80', 12);

-- 2. BEDS
INSERT INTO products (category_id, name, description, price, image, stock) VALUES 
(2, 'Serene Queen Platform', 'Minimalist oak platform bed with integrated headboard lighting.', 950.00, 'https://images.unsplash.com/photo-1505693419173-42b92588627e?auto=format&fit=crop&w=800&q=80', 7),
(2, 'Velvet Tufted King', 'Majestic king-size bed with deep diamond tufting in charcoal.', 1400.00, 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=800&q=80', 4),
(2, 'Scandi Loft Bed', 'Light wood frame with built-in storage drawers. Space-saving elegance.', 1100.00, 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80', 6),
(2, 'Japanese Zen Futon', 'Low-profile floor bed designed for ultimate spinal support and peace.', 650.00, 'https://images.unsplash.com/photo-1540518614846-7eded433c457?auto=format&fit=crop&w=800&q=80', 10),
(2, 'Industrial Metal Frame', 'Hand-forged iron frame with a rustic, vintage-inspired finish.', 799.00, 'https://images.unsplash.com/photo-1531835221326-88053a992569?auto=format&fit=crop&w=800&q=80', 15);

-- 3. CHAIRS
INSERT INTO products (category_id, name, description, price, image, stock) VALUES 
(3, 'Eames Style Lounge', 'The iconic mid-century lounge chair with matching ottoman.', 450.00, 'https://images.unsplash.com/photo-1592078615290-033ee584e267?auto=format&fit=crop&w=800&q=80', 12),
(3, 'Velvet Accent Chair', 'Occasional chair in blush pink with thin gold-plated legs.', 280.00, 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?auto=format&fit=crop&w=800&q=80', 20),
(3, 'Rattan Terrace Chair', 'Hand-woven natural rattan chair for indoor or sheltered outdoor use.', 199.00, 'https://images.unsplash.com/photo-1519947486511-46149fa0a254?auto=format&fit=crop&w=800&q=80', 25),
(3, 'Executive Leather Swivel', 'Professional grade ergonomic office chair in premium black leather.', 550.00, 'https://images.unsplash.com/photo-1505843490701-5be550b13e5e?auto=format&fit=crop&w=800&q=80', 10),
(3, 'Sleek Poly Shell', 'Modern molded plastic chair with wooden Eiffel legs. Set of 2.', 120.00, 'https://images.unsplash.com/photo-1561677843-39dee7a319ca?auto=format&fit=crop&w=800&q=80', 40);

-- 4. TABLES
INSERT INTO products (category_id, name, description, price, image, stock) VALUES 
(4, 'Solid Oak Dining', 'Handcrafted dining table for 8, made from reclaimed European oak.', 1200.00, 'https://images.unsplash.com/photo-1577145946459-39f504e7194e?auto=format&fit=crop&w=800&q=80', 5),
(4, 'Marble Coffee Table', 'Genuine white Carrara marble top with a brushed steel base.', 450.00, 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?auto=format&fit=crop&w=800&q=80', 12),
(4, 'Glass Workspace Desk', 'Tempered glass desk with a minimalist trestle frame in white.', 320.00, 'https://images.unsplash.com/photo-1518455027359-f3f8164ba6bd?auto=format&fit=crop&w=800&q=80', 15),
(4, 'Rustic Pine Console', 'Long, slim console table perfect for entryways and hallways.', 250.00, 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?auto=format&fit=crop&w=800&q=80', 8),
(4, 'Industrial Nesting Tables', 'Set of three nesting side tables with wood tops and iron frames.', 180.00, 'https://images.unsplash.com/photo-1532372320572-cda25653a26d?auto=format&fit=crop&w=800&q=80', 20);

-- 5. LIGHTING
INSERT INTO products (category_id, name, description, price, image, stock) VALUES 
(5, 'Modern Brass Floor', 'Tall arc floor lamp with a heavy marble base and brass shade.', 220.00, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=800&q=80', 15),
(5, 'Crystal Chandelier', 'Elegant 8-light crystal chandelier for dining rooms or foyers.', 650.00, 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?auto=format&fit=crop&w=800&q=80', 4),
(5, 'Concrete Table Lamp', 'Architectural table lamp with a raw concrete base and linen shade.', 85.00, 'https://images.unsplash.com/photo-1534073828943-f801091bb18c?auto=format&fit=crop&w=800&q=80', 30),
(5, 'Industrial Edison Pendant', 'Triple pendant light with exposed vintage-style Edison bulbs.', 140.00, 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?auto=format&fit=crop&w=800&q=80', 25),
(5, 'Smart LED Glow Cube', 'Color-changing LED mood light with remote control and scheduling.', 110.00, 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?auto=format&fit=crop&w=800&q=80', 18);
