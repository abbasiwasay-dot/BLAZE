<?php
session_start();
require "db.php";

if(isset($_POST['addtomenu'])){

  $name=$_POST['name'];
  $category=$_POST['category'];
  $price=$_POST['price'];
  $desc=$_POST['description'];

  $image=$_FILES['image_url'];

  $image_name=$image['name'];
  $image_tmp=$image['tmp_name'];

  $folder="uploads/";

  move_uploaded_file($image_tmp,$folder.$image_name);

  $image_path=$folder.$image_name;

  $insertion="INSERT INTO `items`(`name`,`category`,`price`,`description`,`image_url`) VALUES(?,?,?,?,?)";

  $prep=$connection->prepare($insertion);

  $prep->bind_param("ssdss",$name,$category,$price,$desc,$image_path);

  $prep->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
  exit();

  }

  if(isset($_POST['delete'])){

  $id = $_POST['id'];
  $deletion = "DELETE FROM `items` WHERE id=?";
  $prepDel = $connection->prepare($deletion);
  $prepDel->bind_param("i",$id);
  $prepDel->execute();

  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}

  if(isset($_POST['new_status'])){
  $u = $connection->prepare("UPDATE orders SET status=? WHERE id=?");
  $u->bind_param("si", $_POST['new_status'], $_POST['order_pk']);
  $u->execute();
  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}


  $select="SELECT * FROM `items`";
  $prepare=$connection->prepare($select);
  $prepare->execute();
  $result=$prepare->get_result();

  $ordSel = $connection->prepare("SELECT * FROM orders ORDER BY id DESC");
  $ordSel->execute();
  $ordRes = $ordSel->get_result();

$user_id=$_SESSION['user_id'];
  $select="SELECT * FROM `user` WHERE id=?";
  $prepare=$connection->prepare($select);
  $prepare->bind_param("i",$user_id);
  $prepare->execute();
  $res=$prepare->get_result();
  $row=$res->fetch_assoc();
$name=$row['name'];
$email=$row['email'];
  if(isset($_POST['logout'])){
  session_destroy();
  header("Location: login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard — Blaze</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body class="admin-body">

<div class="admin-layout">

  <!-- ============ SIDEBAR (drawer on screens <= 860px) ============ -->
  <aside class="admin-sidebar" id="adminSidebar">
    <a href="index.php" class="logo admin-logo">Blaze<span class="dot">.</span></a>

    <nav class="admin-nav">
      <button class="admin-nav-item active" data-view="products">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        Products
      </button>
      <button class="admin-nav-item" data-view="orders">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
        Orders
      </button>
    </nav>

    <div class="admin-sidebar-footer">
      <div class="admin-profile">
        <div class="admin-avatar"><?php echo substr($name,0,1)?></div>
        <div class="admin-profile-info"><strong><?php echo htmlspecialchars($name)?></strong><span><?php echo htmlspecialchars($email)?></span></div>
      </div>
     <form action="" method="POST">
<button type="submit" name="logout" class="admin-logout"><i class="fa fa-sign-out" aria-hidden="true"></i></button>
      </form>
        
      </a>
    </div>
  </aside>


  <div class="admin-backdrop" id="adminBackdrop"></div>

  <!-- ============ MAIN ============ -->
  <div class="admin-main">

    <header class="admin-topbar">
      <div class="admin-topbar-left">
 
        <button class="icon-btn admin-sidebar-toggle" id="adminMenuBtn" aria-label="Open menu" aria-expanded="false" aria-controls="adminSidebar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
        </button>
        <div>
          <h1 id="viewTitle">Products</h1>
          <p id="viewSubtitle">Manage your menu items</p>
        </div>
      </div>
      <div class="admin-topbar-actions">
        <div class="search-box admin-search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" placeholder="Search...">
        </div>
        <button class="icon-btn" aria-label="Notifications">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
          <span class="badge show">3</span>
        </button>
      </div>
    </header>

    <!-- ============ PRODUCTS ============ -->
    <section class="admin-view active" id="view-products">
      <div class="view-toolbar">
        <div class="search-box admin-search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <input type="text" id="productSearch" placeholder="Search products...">
        </div>
        <button class="btn btn-primary" id="addProductBtn">
          Add product
        </button>
      </div>
      <div class="admin-table-wrap">
        <div class="admin-table-head product-row">
          <span>Product</span><span>Category</span><span>Price</span><span>Description</span><span>Status</span>
        </div>
        <div id="productsTable">
<?php while($row=$result->fetch_assoc()){ ?>
          <div class="product-item product-row">
            <div class="product-cell">
              <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-thumb">
              <span><?php echo htmlspecialchars($row['name']); ?></span>
            </div>
            <span><?php echo htmlspecialchars($row['category']); ?></span>
            <strong>Rs. <?php echo number_format($row['price'],2); ?></strong>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <form class="item-delete" method="POST">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="delete" class="item-delete" aria-label="Delete item">
                <i class="fa-solid fa-trash"></i>
              </button>
            </form>
          </div>
<?php } ?>
        </div>
      </div>
    </section>

    <!-- ============ ORDERS ============ -->
    <section class="admin-view" id="view-orders">
      <div class="view-toolbar">
        <div class="status-filters" id="statusFilters">
          <button class="filter-pill active" data-status="all">All</button>
          <button class="filter-pill" data-status="Pending">Pending</button>
          <button class="filter-pill" data-status="Preparing">Preparing</button>
          <button class="filter-pill" data-status="Out for Delivery">Out for Delivery</button>
          <button class="filter-pill" data-status="Delivered">Delivered</button>
          <button class="filter-pill" data-status="Cancelled">Cancelled</button>
        </div>
      </div>
      <div class="admin-table-wrap">
        <div class="admin-table-head order-row-wide"><span>Order</span><span>Customer</span><span>Items</span><span>Total</span><span>Status</span><span>Date</span></div>
        <div id="ordersTable">
<?php while($o = $ordRes->fetch_assoc()):
        $items = json_decode($o['items'], true); ?>
          <div class="order-row-wide" data-status="<?php echo htmlspecialchars($o['status']); ?>">
            <span><?php echo htmlspecialchars($o['order_id']); ?></span>
            <span><?php echo htmlspecialchars($o['name']); ?></span>
            <span><?php echo is_array($items) ? count($items) : 0; ?> items</span>
            <span>Rs. <?php echo number_format($o['total'],2); ?></span>
            <form method="POST" class="status-form">
              <input type="hidden" name="order_pk" value="<?php echo $o['id']; ?>">
              <select name="new_status" onchange="this.form.submit()">
<?php foreach (["Pending","Preparing","Out for Delivery","Delivered","Cancelled"] as $s): ?>
                <option value="<?php echo $s; ?>" <?php echo $o['status']==$s?'selected':''; ?>><?php echo $s; ?></option>
<?php endforeach; ?>
              </select>
            </form>
            <span><?php echo htmlspecialchars($o['created_at']); ?></span>
          </div>
<?php endwhile; ?>
        </div>
      </div>
    </section>

  </div>
</div>

<!-- ============ ADD PRODUCT MODAL ============ -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-head">
      <h3>Add product</h3>
      <button id="closeModal" aria-label="Close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
      </button>
    </div>

    <form id="productForm" method="POST" enctype="multipart/form-data">

    <div class="form-row">
        <label for="pName">Item name</label>
        <input type="text" id="pName" name="name" placeholder="Smoky BBQ Burger" required>
    </div>

    <div class="form-row two-col">
        <div>
            <label for="pCategory">Category</label>
            <select id="pCategory" name="category" required>
                <option value="burgers">Burgers</option>
                <option value="pizza">Pizza</option>
                <option value="pasta">Pasta</option>
                <option value="shawarma">Shawarma</option>
                <option value="fries">Fries</option>
                <option value="desserts">Desserts</option>
                <option value="drinks">Drinks</option>
            </select>
        </div>

        <div>
            <label for="pPrice">Price (PKR)</label>
            <input type="number" id="pPrice" name="price" step="0.01" min="0" placeholder="Rs. 350" required>
        </div>
    </div>
    <div class="form-row">
        <label for="pEmoji">Description</label>
        <input type="text" id="pEmoji" name="description" placeholder="write about item" >
    </div>

    <div class="form-row">
        <label for="pImage">Product Image</label>
        <input type="file" id="pImage" name="image_url" accept="image/*" required>
    </div>


    <button type="submit" class="btn btn-primary full" name="addtomenu">
        Add to menu
    </button>

</form>
  </div>
</div>

<script src="js/admin.js"></script>


<script>
(function () {
  let sidebar  = document.getElementById('adminSidebar');
  let toggle   = document.getElementById('adminMenuBtn');
  let backdrop = document.getElementById('adminBackdrop');
  if (!sidebar || !toggle || !backdrop) return;

  function setOpen(open) {
    sidebar.classList.toggle('open', open);
    backdrop.classList.toggle('open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.style.overflow = open ? 'hidden' : '';
  }

  toggle.addEventListener('click', function () {
    setOpen(!sidebar.classList.contains('open'));
  });
  backdrop.addEventListener('click', function () { setOpen(false); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setOpen(false);
  });


  sidebar.querySelectorAll('.admin-nav-item').forEach(function (btn) {
    btn.addEventListener('click', function () { setOpen(false); });
  });

  window.matchMedia('(min-width: 861px)').addEventListener('change', function (e) {
    if (e.matches) setOpen(false);
  });
})();
</script>
</body>
</html>