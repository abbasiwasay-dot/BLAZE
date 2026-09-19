<?php
session_start();
require "db.php";
$user_id=$_SESSION['user_id'];
  $select="SELECT * FROM `user` WHERE id=?";
  $prepare=$connection->prepare($select);
  $prepare->bind_param("i",$user_id);
  $prepare->execute();
  $result=$prepare->get_result();
  $row=$result->fetch_assoc();
$userName=$row['name'];
$userMail=$row['email'];

$orders = [];
$stmt = $connection->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) { $orders[] = $row; }

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
<title>My Orders — Blaze</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
  <div class="nav-inner container">
    <a href="index.php" class="logo">Blaze<span class="dot">.</span></a>

    <input type="checkbox" id="navToggle" class="nav-toggle-checkbox">

    <nav class="nav-links">
      <a href="index.php" class="nav-link">Home</a>
      <a href="index.php#menu" class="nav-link">Menu</a>
      <a href="dashboard.php" class="nav-link active">My orders</a>
    </nav>

    <div class="nav-actions">
      <form action="" method="POST">
<button type="submit" name="logout" class="btn btn-ghost">Log out</button>
      </form>
      <label for="navToggle" class="hamburger" aria-label="Toggle menu"><span></span><span></span><span></span></label>
    </div>
  </div>
</header>

<main class="db-wrap">
  <div class="container">
    <div class="db-top">
      <div class="db-user">
        <div class="db-avatar"><?php echo strtoupper(substr($userName,0,1)); ?></div>
        <div>
          <strong><?php echo htmlspecialchars($userName); ?></strong>
          <span><?php echo htmlspecialchars($userMail); ?></span>
        </div>
      </div>
      <a href="index.php#menu" class="btn btn-primary">Order again</a>
    </div>

    <div class="section-head" style="text-align:left"><h2>Your orders</h2></div>

    <div id="ordersList">
<?php if (empty($orders)): ?>
      <div class="order-card" style="text-align:center;color:var(--gray)">
        <strong style="color:var(--white);display:block;margin-bottom:6px">NO Orders Yet</strong>
        Go To Menu 
      </div>
<?php else: foreach ($orders as $o):
        $items = json_decode($o['items'], true); ?>
      <div class="order-card">
        <div class="oc-head">
          <div>
            <strong><?php echo htmlspecialchars($o['order_id']); ?></strong>
            <small><?php echo htmlspecialchars($o['created_at']); ?> · <?php echo htmlspecialchars($o['payment']); ?></small>
          </div>
          <span class="pill"><?php echo htmlspecialchars($o['status']); ?></span>
        </div>
        <div class="oc-items">
<?php foreach ($items as $i): ?>
          <div class="oc-line"><span><?php echo htmlspecialchars($i['name']); ?> × <?php echo $i['qty']; ?></span><span>Rs. <?php echo $i['price'] * $i['qty']; ?></span></div>
<?php endforeach; ?>
        </div>
        <div class="oc-line" style="margin-bottom:10px">📍 <?php echo htmlspecialchars($o['address']); ?></div>
        <div class="oc-foot"><span style="color:var(--gray)">Total</span><b>Rs. <?php echo number_format($o['total'],2); ?></b></div>
      </div>
<?php endforeach; endif; ?>
    </div>

  </div>
</main>

</body>
</html>