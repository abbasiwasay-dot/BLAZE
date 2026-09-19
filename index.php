<?php
require "db.php";

$select="SELECT * FROM items";
$prepare=$connection->prepare($select);
$prepare->execute();
$result=$prepare->get_result();
$count="SELECT COUNT(*) AS total FROM `items`";
$resul=mysqli_query($connection,$count);
$ro=mysqli_fetch_assoc($resul);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#0d0d0d">
<title>Blaze — Hot food, delivered fast</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>

<!-- ============ NAVBAR ============ -->
<header class="navbar" id="navbar">
  <div class="nav-inner container">
    <a href="index.php" class="logo">Blaze<span class="dot">.</span></a>

    <input type="checkbox" id="navToggle" class="nav-toggle-checkbox">

    <nav class="nav-links">
      <a href="#hero" class="nav-link active">Home</a>
      <a href="#menu" class="nav-link">Menu</a>
      <a href="#offer" class="nav-link">Offers</a>
      <a href="#contact" class="nav-link">Contact</a>
    </nav>

    <div class="nav-actions">
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" placeholder="Search dishes...">
      </div>
      <a href="#" class="icon-btn" id="cartOpen" aria-label="Cart">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <span class="cart-count" id="cartCount">0</span>
      </a>
      <a href="login.php" class="icon-btn hide-mobile" aria-label="Account">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
      </a>
      <label for="navToggle" class="hamburger" aria-label="Toggle menu"><span></span><span></span><span></span></label>
    </div>
  </div>
</header>


<section class="hero" id="hero">
  <div class="hero-banner">
    <img class="hero-banner-img" src="images/heroimage2.png" alt="Blaze burger, fries and a cold drink" fetchpriority="high">

    <div class="container hero-inner">
      <p class="status-tag"><span class="live-dot"></span>Open now — delivering to your area</p>

      <div class="hero-content">
        <h1 class="hero-title">FLAVOR<br><span class="highlight">
STARTS HERE.</span></h1>
        <p class="hero-sub">Craving something good? Order from Blaze and get it fresh, hot and at your door in under 30 minutes — no excuses.</p>
        <div class="hero-actions">
          <a href="#menu" class="btn btn-primary">Order now
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
          <a href="#menu" class="btn btn-ghost">View menu</a>
        </div>
      </div>
    </div>
  </div>

  <div class="hero-stats-bar">
    <div class="stat"><strong>4.9<span class="star">★</span></strong><span>Avg. rating</span></div>
    <div class="stat"><strong>25 min</strong><span>Avg. delivery</span></div>
    <div class="stat"><strong>10k+</strong><span>Orders served</span></div>
  </div>
</section>


<!-- ============ MENU ============ -->
<section class="menu" id="menu">
  <div class="container">
    <div class="section-head row">
      <div>
        <span class="eyebrow">The full menu</span>
        <h2>What are you craving?</h2>
        <p><span id="menuCount"><?php echo htmlspecialchars($ro['total'])  ?></span> dishes, made fresh to order</p>
      </div>
    </div>

  
    <div class="categories" id="categories">
      <div class="cat-row" id="catRow">
        <button class="cat-pill active" data-cat="all"><span>🍽️</span>All</button>
        <button class="cat-pill" data-cat="burgers"><span>🍔</span>Burgers</button>
        <button class="cat-pill" data-cat="pizza"><span>🍕</span>Pizza</button>
        <button class="cat-pill" data-cat="pasta"><span>🍝</span>Pasta</button>
        <button class="cat-pill" data-cat="shawarma"><span>	🥙</span>Shawarma</button>
        <button class="cat-pill" data-cat="fries"><span>🍟</span>Fries</button>
        <button class="cat-pill" data-cat="desserts"><span>🍰</span>Desserts</button>
        <button class="cat-pill" data-cat="drinks"><span>🥤</span>Drinks</button>
      </div>
    </div>

    <div class="menu-grid" id="menuGrid">

    <?php while($row=$result->fetch_assoc()){ ?>

<div class="menu-card"
     data-cat="<?php echo htmlspecialchars($row['category']); ?>"
     data-id="<?php echo htmlspecialchars($row['id']); ?>"
     data-name="<?php echo htmlspecialchars($row['name']); ?>"
     data-price="<?php echo htmlspecialchars($row['price']); ?>"
     data-img="<?php echo htmlspecialchars($row['image_url']); ?>"
     data-desc="<?php echo htmlspecialchars($row['description']); ?>">
    <div class="menu-img-wrap">
      <img class="menu-img" src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" loading="lazy" decoding="async">
    </div>
    <div class="card-body">
      <h3><?php echo htmlspecialchars($row['name']); ?></h3>
      <p class="desc"><?php echo htmlspecialchars($row['description']); ?></p>
      <div class="rating"><span class="star">★★★★</span>4.8 (240+)</div>
      <div class="price-row">
        <strong class="price">Rs. <?php echo htmlspecialchars($row['price']); ?></strong>
      </div>
      <button class="add-btn">
        Add to cart
      </button>
    </div>
</div>

<?php } ?>

    </div>
  </div>
</section>


<!-- ============ PROMO BANNER ============ -->
<section class="banner-section" id="offer">
  <div class="container">
    <div class="banner">
      <div class="banner-inner">
        <div class="banner-text">
          <p class="banner-label">Limited time only</p>
          <h2 class="banner-num">40<span>%</span></h2>
          <p class="banner-copy">off your first order — every single time, on us.</p>
          <div class="promo-code">Use code <strong>BLAZE40</strong> at checkout</div>
          <a href="#menu" class="btn btn-primary">Claim offer
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
        </div>
        <div class="banner-visual">
          <img src="images/bannerimage.avif" alt="Loaded cheeseburger with fries" class="banner-img" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1571091718767-18b5b1457add?auto=format&fit=crop&w=1000&q=80'">
          <div class="banner-badge"><strong>40%</strong><span>OFF TODAY</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ CONTACT ============ -->
<section class="contact" id="contact">
  <div class="container contact-inner">
    <div class="contact-info">
      <h2>Get in touch</h2>
      <p>Questions, feedback, or a catering order — we read every message.</p>
      <ul class="info-list">
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg><div><strong>Visit us</strong><span>42 Blaze Street, Rawalpindi</span></div></li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><div><strong>Call us</strong><span>+92 300 123 4567</span></div></li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg><div><strong>Email us</strong><span>hello@blazeeats.com</span></div></li>
        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><div><strong>Open daily</strong><span>10:00 AM – 1:00 AM</span></div></li>
      </ul>
    </div>
    <form class="contact-form" id="contactForm">
      <div class="form-row"><label for="cName">Name</label><input type="text" id="cName" placeholder="Your name" required></div>
      <div class="form-row"><label for="cEmail">Email</label><input type="email" id="cEmail" placeholder="you@example.com" required></div>
      <div class="form-row"><label for="cMsg">Message</label><textarea id="cMsg" rows="4" placeholder="How can we help?" required></textarea></div>
      <button type="submit" class="btn btn-primary full">Send message</button>
    </form>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="footer">
  <div class="container footer-top">
    <div class="footer-brand">
      <a href="index.php" class="logo">Blaze<span class="dot">.</span></a>
      <p>Fast. Fresh. Fired up.</p>
      <div class="app-badges">
        <a href="#" class="app-badge">📱 App Store</a>
        <a href="#" class="app-badge">▶ Google Play</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Explore</h4>
      <a href="#hero">Home</a>
      <a href="#menu">Menu</a>
      <a href="#offer">Offers</a>
      <a href="#contact">Contact</a>
    </div>
    <div class="footer-col">
      <h4>Categories</h4>
      <a href="#menu" data-scrollcat="burgers">Burgers</a>
      <a href="#menu" data-scrollcat="pizza">Pizza</a>
      <a href="#menu" data-scrollcat="desserts">Desserts</a>
      <a href="#menu" data-scrollcat="drinks">Drinks</a>
    </div>
    <div class="footer-col">
      <h4>Follow</h4>
      <div class="social-row">
        <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
        <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
        <a href="#" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom container"><p>© 2026 Blaze Eats. All rights reserved.</p></div>
</footer>


<!-- ============ CART DRAWER ============ -->
<div class="blz-overlay" id="blzOverlay"></div>

<aside class="cart-drawer" id="cartDrawer">
  <div class="cart-head">
    <div><h3>Your cart</h3><span id="cartCountText">0 items</span></div>
    <button class="cart-close" id="cartClose" aria-label="Close">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
  </div>
  <div class="cart-items" id="cartItems"></div>
  <div class="cart-foot">
    <div class="cart-line"><span>Subtotal</span><span id="cartSub">Rs. 0</span></div>
    <div class="cart-line"><span>Delivery</span><span id="cartDel">Rs. 0</span></div>
    <div class="cart-line total"><span>Total</span><span id="cartTotal">Rs. 0</span></div>
    <a href="checkout.html" class="btn btn-primary full big">Checkout</a>
  </div>
</aside>

<!-- ============ PRODUCT DETAIL POPUP ============ -->
<div class="detail-modal" id="detailModal">
  <button class="detail-close" id="detailClose" aria-label="Close">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
  </button>
  <div class="detail-grid">
    <img id="dImg" src="" alt="">
    <div class="detail-info">
      <p class="cat" id="dCat"></p>
      <h2 id="dName"></h2>
      <p class="desc" id="dDesc"></p>
      <strong class="price" id="dPrice"></strong>
      <div class="detail-row">
        <div class="qty"><button id="dMinus">-</button><span id="dQty">1</span><button id="dPlus">+</button></div>
        <button class="btn btn-primary" id="dAdd">Add to cart</button>
      </div>
    </div>
  </div>
</div>

<div class="blz-toast" id="blzToast"></div>

<script src="js/script.js"></script>
<script src="js/cart.js"></script>
</body>
</html>