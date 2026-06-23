<?php
include 'includes/config.php';
include 'includes/functions.php';

$featuredQuery = "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.featured = 1 ORDER BY p.created_at DESC LIMIT 6";
$featuredResult = mysqli_query($conn, $featuredQuery);
if (!$featuredResult) {
    die("Products Query Error: " . mysqli_error($conn));
}
$featured_products = mysqli_fetch_all($featuredResult, MYSQLI_ASSOC);
$active_offers = getActiveOffers($conn);
?>

<?php include 'includes/header.php'; ?>

<section class="hero-banner new-hero">
    <div class="container hero-content">
        <div class="hero-text">
            <span class="eyebrow">Since 1979</span>

            <h1>Delicious sweets and namkeen made fresh every day</h1>

            <p>Enjoy authentic flavor, handcrafted recipes, and fast delivery across the city.</p>

            <a class="button button-primary" href="<?= BASE_URL ?>/products.php">
                View Products
            </a>
        </div>
    </div>
</section>
<section class="festival-slider">

    <div class="festival-slide active slide1">

        <div class="festival-overlay"></div>

        <div class="festival-content">

            <span class="festival-tag">
                Everyday Special
            </span>

            <h2>
                Hot Fafda & Jalebi 
            </h2>

            <p>
                Fresh Gujarati breakfast happiness since 1979
            </p>

            <a href="<?= BASE_URL ?>/products.php"
               class="button button-primary">

                Shop Now

            </a>

        </div>
    </div>

    <div class="festival-slide slide2">

        <div class="festival-overlay"></div>

        <div class="festival-content">

            <span class="festival-tag">
                Premium Sweet
            </span>

            <h2>
                Kaju Katli Celebration Box
            </h2>

            <p>
                Rich taste crafted for every celebration
            </p>

            <a href="<?= BASE_URL ?>/products.php"
               class="button button-primary">

                Explore Sweets

            </a>

        </div>
    </div>
<div class="festival-slide slide3">

    <div class="festival-content">

        <span class="festival-tag">
            Crunchy Specials
        </span>

        <h2>
            Premium Namkeen Variety
        </h2>

        <p>
            Sev, chevdo, gathiya, mixture & more freshly made every day
        </p>

        <a href="<?= BASE_URL ?>/products.php"
           class="button button-primary">

            Explore Namkeen

        </a>

    </div>

</div>

<div class="festival-slide slide4">

    <div class="festival-content">

        <span class="festival-tag">
            Fresh & Crispy
        </span>

        <h2>
            Fresh Chips
        </h2>

        <p>
            Banana chips, potato wafers & masala crunch in every bite
        </p>

        <a href="<?= BASE_URL ?>/products.php"
           class="button button-primary">

            Shop Chips

        </a>

    </div>

</div>

<div class="festival-slide slide5">

    <div class="festival-content">

        <span class="festival-tag">
            Fasting Special
        </span>

        <h2>
            Pure Vrat Food Collection
        </h2>

        <p>
            Delicious farali snacks & sweets prepared with authentic taste
        </p>

        <a href="<?= BASE_URL ?>/products.php"
           class="button button-primary">

            View Vrat Items

        </a>

    </div>

</div>
</section>
<section class="featured-products container">
    <div class="section-heading">
        <h2>Featured Products</h2>
        <p>Handpicked sweets and treats ready for your next celebration.</p>
    </div>
    <section class="reviews-section">

    <div class="container">

        <div class="section-heading">
            <h2>What Customers Say 💛</h2>
            <p>Loved by sweet lovers across Ahmedabad</p>
        </div>

        <div class="reviews-grid">

            <div class="review-card">
                <div class="stars">★★★★★</div>

                <p>
                    “Best fafda jalebi in Ahmedabad 😍 Fresh taste and fast service.”
                </p>

                <h4>- Priyanshi Patel</h4>
            </div>

            <div class="review-card">
                <div class="stars">★★★★★</div>

                <p>
                    “Kaju katli quality is premium. Packaging was also beautiful.”
                </p>

                <h4>- Harsh Shah</h4>
            </div>

            <div class="review-card">
                <div class="stars">★★★★★</div>

                <p>
                    “Our family always orders sweets from Shree Mohan during festivals.”
                </p>

                <h4>- Meera Joshi</h4>
            </div>

        </div>

    </div>

</section>
    <div class="product-grid">
        <?php if (!empty($featured_products)): ?>
            <?php foreach ($featured_products as $product): ?>
                <article class="product-card">
                    <img src="assets/images/products/<?php echo trim($product['image']); ?>" 
     alt="<?php echo $product['name']; ?>" 
     style="height:350px; object-fit:cover;">
     
                    <div class="product-card-body">
                        <h3><?php echo sanitize($product['name']); ?></h3>
                        <p class="category"><?php echo sanitize($product['category_name'] ?: 'All Products'); ?></p>
                        <p class="price">₹<?php echo sanitize($product['price']); ?></p>
                        <form method="POST" action="<?= BASE_URL ?>/cart_action.php" class="product-card-form">
                            <input type="hidden" name="product_id" value="<?php echo sanitize($product['id']); ?>">
                           <label>Select Weight:</label>

<select name="weight">
    <option value="250g">250g</option>
    <option value="500g">500g</option>
    <option value="1kg">1kg</option>
</select>

<label>Quantity</label>

<input type="number" name="quantity" value="1" min="1">

<button type="submit">Add to Cart</button>
<button type="button" class="wishlist-btn"
        data-id="<?php echo sanitize($product['id']); ?>"
        data-name="<?php echo sanitize($product['name']); ?>"
        data-image="<?php echo trim($product['image']); ?>">
    ❤️ Add to Wishlist
</button>
                            
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No featured products available at the moment.</p>
        <?php endif; ?>
    </div>
</section>

<section class="offers container">
    <div class="section-heading">
        <h2>Current Offers</h2>
        <p>Don't miss these special savings.</p>
    </div>
    <div class="offers-list">
        <?php if (!empty($active_offers)): ?>
            <?php foreach ($active_offers as $offer): ?>
                <div class="offer-card">
                    <p><?php echo sanitize($offer['description']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="offer-card">
                <p>Check back soon for fresh offers.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="about-preview container">
    <div class="about-card">
        <h2>Trusted Sweetmakers Since 1979</h2>
        <p>From classic laddus to crunchy namkeen, we use quality ingredients and recipes passed down through generations.</p>
        <a class="button button-secondary" href="<?= BASE_URL ?>/about.php">Learn More</a>
    </div>
</section>

<a href="https://wa.me/919313202040" class="whatsapp-button" target="_blank">Order via WhatsApp</a>
<?php
$reviewsQuery = mysqli_query(
    $conn,
    "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 3"
);

$reviews = mysqli_fetch_all(
    $reviewsQuery,
    MYSQLI_ASSOC
);
?>

<section class="reviews-section">

    <div class="container">

        <div class="section-heading">

            <h2>What Customers Say 💛</h2>

            <p>
                Loved by sweet lovers across Ahmedabad
            </p>

        </div>

        <div class="reviews-grid">

            <?php foreach ($reviews as $review): ?>

                <div class="review-card">

                    <div class="stars">

                        <?php echo str_repeat("⭐", $review['rating']); ?>

                    </div>

                    <p>
                        “<?php echo sanitize($review['review_text']); ?>”
                    </p>

                    <h4>
                        - <?php echo sanitize($review['customer_name']); ?>
                    </h4>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>
<div id="offerPopup" class="offer-popup">
    <div class="offer-popup-box">
        <button class="offer-close" onclick="closeOfferPopup()">×</button>

        <h2>🎉 Special Offer!</h2>
        <p>Fresh sweets & namkeen for every celebration.</p>

        <a href="<?= BASE_URL ?>/products.php" class="button button-primary">
            Shop Now
        </a>
    </div>
</div>
<script>
setTimeout(function(){
    document.getElementById("offerPopup").style.display = "flex";
}, 1200);

function closeOfferPopup(){
    document.getElementById("offerPopup").style.display = "none";
}
</script>
<?php include 'includes/footer.php'; ?>
<script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</body>
</html>