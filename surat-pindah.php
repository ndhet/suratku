<?php

include_once('helper/config.php');
include_once('helper/function.php');
require 'vendor/autoload.php';

$login = cekSession();
if($login == 0){
  toastr_set("error", "Silahkan login terlebih dahulu !"); 
  redirect("login.php");
}

if(isset($_POST['buat'])){
    $siswa = post("nama");
    $nosu = post("nosu");
    $sql = mysqli_query($conn, "SELECT * FROM siswa WHERE nama='$siswa'");
    $data = mysqli_fetch_assoc($sql);
    
    $p = [
      'nosu' => $nosu,
      'bulan' => getRomawi(date('m')),
      'tahun' => date('Y'),
      'nama' => $data['nama'],
      'kelas' => getRomawi($data['kelas']),
      'kls' => getBilang($data['kelas']),
      'tmplahir' => $data['tmp_lahir'],
      'tgllahir' => tanggal_indonesia($data['tgl_lahir']),
      'jk' => $data['jk'] == 'P' ? 'Perempuan' : 'Laki Laki',
      'nis' => $data['nis'],
      'nisn' => $data['nisn'],
      'alamat' => $data['alamat'],
      'nayah' => $data['n_ayah'],
      'pekerjaan' => $data['pekerjaan'],
      'tglttd' => tanggal_indonesia(date('Y-m-d'))
    ];
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('data/TemplatePindah.docx');
    
    $templateProcessor->setValues($p);
    $surat = 'SURAT_PINDAH_'.$siswa.'.docx';
    header("location: ./data/surat-pindah/$surat");
    $templateProcessor->saveAs('./data/surat-pindah/'.$surat);
    
    $no = $p['nosu'];
    $bulan = $p['bulan'];
    $tahun = $p['tahun'];
    $sql = mysqli_query($conn, "UPDATE suratpindah SET nomor='$no', bulan='$bulan', tahun='$tahun'");
}

?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>SURATKU | Surat Pindah</title>
    
    <link href="./vendor/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./vendor/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>

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
                  Surat Pindah
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="card">
              <div class="col-12 p-4">
                <div class="mb-3">
                  <form method="POST" action="">
                    <label class="form-label">Pilih Siswa</label>
                    <select name="nama" class="form-select" id="select-optgroups">
                      <optgroup label="Siswa">
                        <?php
                        $sql = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama ASC");
                        while($data = mysqli_fetch_assoc($sql)){
                        ?>
                        <option value="<?= $data['nama']?>"><?= $data['nama']?>
                        <?php
                         }
                         ?>
                      </optgroup>
                    </select>
                    <?php 
                      $sql = mysqli_query($conn, "SELECT * FROM suratpindah WHERE id='1'");
                      $data = mysqli_fetch_assoc($sql);
                    ?>
                    <input class="mt-3 form-control" type="text" value="NO SURAT : <?= $data['nomor'] + 1?>/YPIA/SMPI Al-M/<?= $data['bulan']?>/<?= $data['tahun'] ?>" disabled>
                    <input type="hidden" name="nosu" value="<?= $data['nomor'] + 1?>">
                    <input class="mt-4 ps-4 pe-4 btn btn-pill btn-primary" type="submit" name="buat" value="Buat">
                   </form>
                 </div>
               </div>
             </div>
           </div>
         </div>
        <?php include './helper/footer.php'; ?>
      </div>
    </div>
    <script src="./vendor/libs/tom-select/dist/js/tom-select.base.min.js?1692870487" defer></script>
    <script src="./vendor/js/tabler.min.js?1692870487" defer></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.TomSelect && (new TomSelect(el = document.getElementById('select-optgroups'), {
    		copyClassesToDropdown: false,
    		dropdownParent: 'body',
    		controlInput: '<input>',
    		render:{
    			item: function(data,escape) {
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    			option: function(data,escape){
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    		},
    	}));
    });
  </script>
  </body>
</html>