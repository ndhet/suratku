<?php

include_once('helper/config.php');
include_once('helper/function.php');

$login = cekSession();
if($login == 0){
  redirect("login.php");
}

$user = $_SESSION['user'];

$sql = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
$data = mysqli_fetch_assoc($sql);


if (isset($_POST['change'])) {
    $curentpassword = md5(post('password'));

    $password = md5(post('newpassword'));
    $nomor = post('nomor');
    

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE password='$curentpassword'");
    if (mysqli_num_rows($sql) == 1) {
        $sql = mysqli_query($conn, "UPDATE users SET password='$password', nomor='$nomor' WHERE username='$user'");
        if ($sql) {
            toastr_set('success', 'Berhasil update profile');
            
        }else {
            toastr_set('error', 'Gagal update profile');
        }
    }else {
        toastr_set('error', 'Password awal tidak sama');
    }
    
}

?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>SURATKU | Cara cepat membuat macam macam surat adm sekolah</title>
    <link href="./vendor/css/tabler.min.css?1692870487" rel="stylesheet"/>
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
  <body >
    <script src="./vendor/js/demo-theme.min.js?1692870487"></script>
    <div class="page">
      <?php include './helper/navbar.php'; ?>
      <div class="page-wrapper">
      <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="row g-0">
                <div class="col-12 col-md-9 d-flex flex-column">
                  <div class="card-body">
                    <h2 class="mb-4">My Account</h2>
                    <?= toastr_show(); ?>
                    <h3 class="card-title">Profile Details</h3>
                    <div class="row align-items-center">
                      <div class="col-auto"><span class="avatar avatar-xl" style="background-image: url(./static/avatars/dedi.jpg)"></span>
                      </div>
                      <div class="col-auto mt-3 ms-0"><button href="" class="btn btn-sm btn-pill btn-outline-secondary">
                          Change
                        </button></div>
                      <div class="col-auto mt-3 ms-0"><button href="" class="btn btn-sm btn-pill btn-outline-danger">
                          Delete
                        </button></div>
                    </div>
                    <br>
                    <form class="form" method="POST" action="">
                    <div class="row g-3">
                        <div class="col-md">
                        <div class="form-label">Current Password</div>
                        <input name="password" type="password" class="form-control">
                      </div>
                      <div class="col-md">
                        <div class="form-label">New Password</div>
                        <input name="newpassword" type="password" class="form-control">
                      </div>
                      <div class="col-md">
                        <div class="form-label">No Telp</div>
                        <input name="nomor" type="text" class="form-control" value="<?= $data['nomor']?>">
                      </div>
                    </div>
                    <br><br>
                    <div class="btn-list justify-content-end">
                      <a href="./" class="btn btn-pill">
                        Back
                      </a>
                      <input type="submit" name="change" class="btn btn-pill btn-primary" value="Change">
                      </input>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include './helper/footer.php'; ?>
      </div>
    </div>
    <script src="./vendor/js/tabler.min.js?1692870487" defer></script>
    <script type="text/javascript">
        setTimeout(function(){
          $('.alert').fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
          });
        }, 1500);
    </script>
    <script src="./vendor/jquery/jquery.min.js"></script>
  </body>
</html>