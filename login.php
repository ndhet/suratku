<?php

include_once('helper/config.php');
include_once('helper/function.php');

$login = cekSession();
if($login == 1){
  redirect("index.php");
}

if(isset($_POST['masuk'])){
    $user = post("username");
    $password = post("password");
    $login = login($user, $password);
    if($login == true){
        redirect('index.php');
    }else{
        toastr_set("error", "Email Atau Password Salah");
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>SURATKU | Masuk akun</title>
    <link href="./vendor/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./vendor/css/demo.min.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./vendor/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a class="text-decoration-none text-secondary fw-bold fs-1" href="./">
            <span class="d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 9l9 6l9 -6l-9 -6l-9 6" /><path d="M21 9v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 19l6 -6" /><path d="M15 13l6 6" /></svg>
            </span>
            <p>SURATKU</p>
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <?php toastr_show();?>
            <h2 class="h2 text-center mb-4">Masuk ke akun suratku</h2>
            <form action="" method="POST" autocomplete="off">
              <div class="mb-3">
                <label class="form-label">Username Akun</label>
                <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="on" required>
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                  <span class="form-label-description">
                    <a href="./forgot-password.php">Lupa password</a>
                  </span>
                </label>
                <div class="input-group input-group-flat">
                  <input name="password" type="password" class="form-control"  id="password" placeholder="Password Kamu"  autocomplete="off" required>
                  <span class="input-group-text">
                    <a href="#" id="togglePassword" class="link-secondary" title="Show Password" data-bs-tongle="tooltip">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                    </a>
                  </span>
                </div>
              </div>
              <div class="mt-3 mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input" name="ingat"/>
                  <span class="form-check-label">Ingat saya</span>
                </label>
              </div>
              <div class="form-footer">
                <input type="submit" name="masuk" value="Masuk" class="btn btn-primary w-100">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
      const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.classList.toggle("bi-eye");
        });
        
        setTimeout(function(){
          $('.alert').fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
          });
        }, 1500);
    </script>
    
  </body>
</html>