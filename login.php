<?php
session_start();
require "db.php";
if(isset($_POST['register'])){
 $name=$_POST['name'];
 $mail=$_POST['email'];
 $pass=$_POST['password'];
 
 $hashed_pass=password_hash($pass,PASSWORD_DEFAULT);
 $insertion='INSERT INTO `user` (`name`,`email`,`password`) VALUES (?,?,?)';
 $prep=$connection->prepare($insertion);
 $prep->bind_param("sss",$name,$mail,$hashed_pass);
 $prep->execute();
 }
 if(isset($_POST['login'])){
   
   $mail=$_POST['email'];
   $pass=$_POST['password'];

 $select="SELECT * FROM `user` WHERE email=? ";
 $prep=$connection->prepare($select);
 $prep->bind_param("s",$mail);
 $prep->execute();
$result=$prep->get_result();
$user=$result->fetch_assoc();
if($user){
    if(password_verify($pass,$user['password'])){
 $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];
    
      if($user['role']==="admin"){
        header('location:admin_dashboard.php');
      exit();
      
      }
      else{
        header('location:index.php');
      exit();

      }
    }
  }
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Blaze</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head>
<body class="auth-body">

<a href="" class="auth-logo-link"><span class="logo">Blaze<span class="dot">.</span></span></a>

<main class="auth-wrap">
  <div class="auth-card">

    <!-- ============ LEFT: BRAND PANEL ============ -->
    <div class="auth-brand">
      <div class="auth-glow" aria-hidden="true"></div>
      <div class="auth-brand-content">
       
        <h1>Good food is<br>just a <span class="highlight">login away.</span></h1>
        <p>Save your addresses, track orders, and reorder your favourites in one tap.</p>
      </div>
      <div class="auth-brand-img">
        <img src="images/heroimage2.png">
      </div>
    </div>

    <!-- ============ RIGHT: FORMS ============ -->
    <div class="auth-panel">
      <div class="auth-tabs" id="authTabs">
        <button type="button" class="auth-tab active" data-target="loginForm">Login</button>
        <button type="button" class="auth-tab" data-target="registerForm">Register</button>
        <span class="auth-tab-indicator" aria-hidden="true"></span>
      </div>

      <!-- LOGIN FORM -->
      <form class="auth-form active" id="loginForm" method="POST">
        <div class="form-row">
          <label for="loginEmail">Email</label>
          <input type="email" id="loginEmail" placeholder="you@example.com" required name="email">
        </div>

        <div class="form-row">
          <label for="loginPassword">Password</label>
          <div class="password-field">
            <input type="password" id="loginPassword" placeholder="••••••••" required name="password">
            <button type="button" class="toggle-password" aria-label="Show password">
              <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            </button>
          </div>
        </div>

        <div class="auth-row">
          <label class="checkbox-row"><input type="checkbox"> Remember me</label>
          <a href="#" class="auth-link">Forgot password?</a>
        </div>


        <button type="submit" class="btn btn-primary full big" name="login">Log in</button>
        <p class="auth-switch">Don't have an account? <a href="#" data-target="registerForm" class="auth-switch-link">Register</a></p>
        <p class="auth-note" data-note></p>
      </form>

      <!-- REGISTER FORM -->
      <form class="auth-form" id="registerForm" method="POST">
        <div class="form-row">
          <label for="regName">Full name</label>
          <input type="text" id="regName" placeholder="Your name" required name="name">
        </div>

        <div class="form-row">
          <label for="regEmail">Email</label>
          <input type="email" id="regEmail" placeholder="you@example.com" required name="email">
        </div>

        <div class="form-row">
          <label for="regPassword">Password</label>
          <div class="password-field">
            <input type="password" id="regPassword" placeholder="••••••••" required minlength="6" name="password">
            <button type="button" class="toggle-password" aria-label="Show password">
              <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            </button>
          </div>
        </div>

        <div class="form-row">
          <label for="regConfirm">Confirm password</label>
          <div class="password-field">
            <input type="password" id="regConfirm" placeholder="••••••••" required>
            <button type="button" class="toggle-password" aria-label="Show password">
              <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
              <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
            </button>
          </div>
          <span class="match-hint" id="matchHint"></span>
        </div>

        <label class="checkbox-row"><input type="checkbox" required> I agree to the Terms &amp; Privacy Policy</label>

        <button type="submit" class="btn btn-primary full big" name="register">Create account</button>
        <p class="auth-switch">Already have an account? <a href="#" data-target="loginForm" class="auth-switch-link">Login</a></p>
        <p class="auth-note" data-note></p>
      </form>

    </div>
  </div>
</main>

<script src="js/login.js"></script>
</body>
</html>