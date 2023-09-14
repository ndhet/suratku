<?php

include_once('helper/config.php');
include_once('helper/function.php');

$login = cekSession();
if($login == 0){
  redirect("login.php");
}

$spindah = count(glob("./data/surat-pindah/*"));
$saktif = count(glob("./data/surat-aktif/*"));
$sbaik = count(glob("./data/surat-baik/*"));

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
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Dashboard
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                       <div class="col-auto">
                         <span class="bg-success text-white avatar">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-square-rounded" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z"></path><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path><path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"></path></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            <?= mysqli_num_rows(getAllsiswa());?> Siswa
                          </div>
                          <div class="text-secondary">
                          <?= $spindah+$saktif+$sbaik ?> Surat
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                       <div class="col-auto">
                         <span class="bg-danger text-white avatar">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            <?= $spindah ?> Surat Pindah
                          </div>
                          <div class="text-secondary">
                          <?= $spindah ?> Surat telah dibuat
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                       <div class="col-auto">
                         <span class="bg-warning text-white avatar">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            <?= $sbaik ?> Surat kelakuan baik
                          </div>
                          <div class="text-secondary">
                          <?= $sbaik ?> Surat telah dibuat
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                       <div class="col-auto">
                         <span class="bg-primary text-white avatar">
                           <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                          </span>
                        </div>
                        <div class="col">
                          <div class="font-weight-medium">
                            <?= $saktif ?> Surat aktif
                          </div>
                          <div class="text-secondary">
                          <?= $saktif ?> Surat telah dibuat
                          </div>
                        </div>
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
  </body>
</html>