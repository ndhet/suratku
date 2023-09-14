<?php

include_once('helper/config.php');
include_once('helper/function.php');
include_once('helper/phpexcel.php');

$login = cekSession();
if($login == 0){
  toastr_set("error", "Silahkan login terlebih dahulu !"); 
  redirect("login.php");
}elseif ($_SESSION['user'] != "admin") {
  redirect("login.php");
}

if(get("a") == "h"){
    $id = get("id");
    try{
        $result = mysqli_query($conn,"DELETE FROM siswa WHERE id=$id");
        if ($result) {
          toastr_set("success", "Berhasil menghapus data");
        }else {
          toastr_set("error", "Apakah Anda Sudah Gila ?"); 
        }
    }catch (mysqli_sql_exception $e) {
        toastr_set("error", "Service Error"); 
     }
}

if(isset($_POST['tambah'])){
    $nama = post("nama");
    $jk = post("jk");
    $nis = post("nis");
    $nisn = post("nisn");
    $kelas = post("kelas");
    $tmplahir = post("tmplahir");
    $tgllahir = post("tgllahir");
    $alamat = post("alamat");
    $nayah = post("nayah");
    $pekerjaan = post("pekerjaan");
    $nibu = post("nibu");

    try{
      $sql = mysqli_query($conn, "INSERT INTO siswa(`nama`, `nis`,`nisn`,`kelas`,`jk`,`tmp_lahir`,`tgl_lahir`,`alamat`,`n_ayah`,`pekerjaan`,`n_ibu`) VALUES('$nama','$nis','$nisn','$kelas','$jk','$tmplahir','$tgllahir','$alamat','$nayah','$pekerjaan','$nibu')");
      if (!$sql) {
        toastr_set("error", "Gagal menambahkan data"); 
      }else {
        toastr_set("success", "Berhasil menambahkan data");
      }
    }catch(mysqli_sql_exception $e) {
      toastr_set("error", "Service Error"); 
     }
        
}
if(isset($_POST['update'])){
    $id = post("id");
    $nama = post("nama");
    $jk = post("jk");
    $nis = post("nis");
    $nisn = post("nisn");
    $kelas = post("kelas");
    $tmplahir = post("tmplahir");
    $tgllahir = post("tgllahir");
    $alamat = post("alamat");
    $nayah = post("nayah");
    $pekerjaan = post("pekerjaan");
    $nibu = post("nibu");

    try{
      $sql = mysqli_query($conn, "UPDATE siswa SET nama='$nama', nis='$nis', nisn='$nisn', kelas='$kelas', jk='$jk', tmp_lahir='$tmplahir', tgl_lahir='$tgllahir', alamat='$alamat', n_ayah='$nayah', pekerjaan='$pekerjaan', n_ibu='$nibu' WHERE id='$id'");
      if (!$sql) {
        toastr_set("error", "Gagal update data"); 
      }else {
        toastr_set("success", "Berhasil update data");
      }
    }catch(mysqli_sql_exception $e) {
      toastr_set("error", "Service Error"); 
     }
        
}

if(isset($_POST['save'])){
    $target = basename($_FILES['fileexcel']['name']) ;
    move_uploaded_file($_FILES['fileexcel']['tmp_name'], $target);
    chmod($_FILES['fileexcel']['name'],0777);
            
    $data = new Spreadsheet_Excel_Reader($_FILES['fileexcel']['name'],false);
    $jumlah_baris = $data->rowcount($sheet_index=0);
            
    for ($i=2; $i<=$jumlah_baris; $i++){
      $nama 		  = strtoupper(mysqli_real_escape_string($conn, $data->val($i, 1)));
    	$nis 		    = $data->val($i, 2);
    	$nisn 		  = $data->val($i, 3);
    	$kelas 		  = $data->val($i, 4);
      $jk			    = strtoupper($data->val($i, 5));
    	$tmplahir 	= ucfirst(strtolower($data->val($i, 6)));
    	$tgllahir 	= $data->val($i, 7);
    	$alamat 	  = ucwords(strtolower($data->val($i, 8)));
   	 	$nayah 		  = strtoupper(mysqli_real_escape_string($conn, $data->val($i, 9)));
    	$pekerjaan 	= $data->val($i, 10);
    	$nibu 		  = strtoupper(mysqli_real_escape_string($conn, $data->val($i, 11)));


        if($nama != "" && $nis != ""){
          try{
            $sql = mysqli_query($conn, "INSERT INTO siswa(`nama`, `nis`,`nisn`,`kelas`,`jk`,`tmp_lahir`,`tgl_lahir`,`alamat`,`n_ayah`,`pekerjaan`,`n_ibu`) VALUES('$nama','$nis','$nisn','$kelas','$jk','$tmplahir','$tgllahir','$alamat','$nayah','$pekerjaan','$nibu')");
    			  if (!$sql) {
              redirect("datasiswa.php");
              toastr_set("error", "Gagal Menyimpan data excel"); 
            }else {
              toastr_set("success", "Berhasil Menyimpan data excel");
            }
          }catch(mysqli_sql_exception $e) {
        		toastr_set("error", "Service Error"); 
     		  }
        }
    }
    
    unlink($_FILES['fileexcel']['name']);            
}
?>

<html lang="id">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>SURATKU | Data siswa.</title>
    <link href="./vendor/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                  Data Siswa
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
          <?= toastr_show()?>
            <div class="card">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <a class="btn btn-pill btn-primary text-right" data-bs-toggle="modal" data-bs-target="#modal-tambah" href=""><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M9 12h6"></path><path d="M12 9v6"></path></svg> Tambah data</a>
                    <a class="ms-3 btn btn-pill btn-success text-right" data-bs-toggle="modal" data-bs-target="#modal-import" href=""><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-import" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M5 13v-8a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5.5m-9.5 -2h7m-3 -3l3 3l-3 3"></path></svg> Import Excel</a>
                  </div>
                  <div class="card-header">
                    <span>
                    <a class="badge badge-pill bg-azure-lt m-1 text-decoration-none">Pilih Kelas</a>
                    <a id="tujuh" class="badge badge-pill bg-azure m-1 text-decoration-none" href="datasiswa.php?k=7">7</a>
                    <a id="delapan" class="badge badge-pill bg-azure m-1 text-decoration-none" href="datasiswa.php?k=8">8</a>
                    <a id="sembilan" class="badge badge-pill bg-azure m-1 text-decoration-none" href="datasiswa.php?k=9">9</a>
                    </span>
                  </div>
                  <div class="m-3 table-responsive">
                   <table class="table card-table table-vcenter text-nowrap datatable" id="dataTable">
                    <thead>
                    <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>NIS</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Alamat</th>
                    <th>Ayah</th>
                    <th>Pekerjaan</th>
                    <th>Ibu</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = get("k");
                    $sql = mysqli_query($conn, "SELECT * FROM siswa WHERE kelas='$k' ORDER BY nama ASC");
                    $no = 1;
                    while($data = mysqli_fetch_array($sql)){
                    ?>
                        <tr>
                        <td class="fs-6 c text-center"><span class="text-secondary"><?= $no++ ?></span></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["nama"] ?></td>
                        <td class="fs-6 m-0 p-0 text-center"><?= $data["jk"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["nis"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["nisn"] ?></td>
                        <td class="fs-6 m-0 p-0 text-center"><?= getRomawi($data["kelas"]) ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["tmp_lahir"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["tgl_lahir"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["alamat"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["n_ayah"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["pekerjaan"] ?></td>
                        <td class="fs-6 ms-1 me-1 pe-1 ps-1"><?= $data["n_ibu"] ?></td>
                        <td class="fs-6 m-0 p-0"><a onClick="confirm_modal('datasiswa.php?k=<?= $data['kelas'] ?>&a=h&id=<?= $data['id'] ?>')" class="pe-2 btn btn-pill btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" href=""><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg></a>
                             <a class="pe-2 btn btn-pill btn-primary" data-bs-toggle="modal" data-bs-target="#modal-<?= $data['id'] ?>" href=""><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg></a>
                             <div class="modal modal-blur fade" id="modal-<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Update Siswa <?= $data["nama"] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                  <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?= $data["id"] ?>">
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $data["nama"] ?>">
                                    </div>
                                    <div class="mb-2">
                                    <select class="form-select" name="jk" value="<?= $data["jk"] ?>">
                                      <option value="">Pilih Jenis Kelamin</option>
                                      <option value="L">Laki Laki</option>
                                      <option value="P">Perempuan</option>
                                    </select>
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="nis" placeholder="NIS" value="<?= $data["nis"] ?>">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="nisn" placeholder="NISN" value="<?= $data["nisn"] ?>">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="kelas" placeholder="Kelas" value="<?= $data["kelas"] ?>">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="tmplahir" placeholder="Tempat Lahir" value="<?= $data["tmp_lahir"] ?>">
                                    </div>
                                    <div class="mb-2">
                                    <input type="date" value="<?= $data["tgl_lahir"] ?>" name="tgllahir" class="form-control mb-2">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?= $data["alamat"] ?>">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="nayah" placeholder="Nama Ayah" value="<?= $data["n_ayah"] ?>">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="pekerjaan" placeholder="Pekerjaan" value="<?= $data["pekerjaan"] ?>">
                                    </div>
                                    <div class="mb-2">
                                      <input type="text" class="form-control" name="nibu" placeholder="Nama Ibu" value="<?= $data["n_ibu"] ?>">
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                      Cancel
                                    </a>
                                    <input type="submit" name="update" class="btn btn-primary ms-auto" value="Update">
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                   </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php include './helper/footer.php'; ?>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header justify-content-center">
            <a class="fs-3 m-3 btn btn-pill btn-outline-success text-right fs-6" href="./data/excel.xls"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M14 3v4a1 1 0 0 0 1 1h4"></path><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path><path d="M12 17v-6"></path><path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path></svg> Download Format Excel</a>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mt-2">
               <form method="post" enctype="multipart/form-data">
                <input class="form-control" name="fileexcel" type="file" required="required">
            </div> 
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>            
              <input class="btn btn-primary ms-auto" type="submit" name="save" value="Simpan">
                </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Siswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form method="POST" action="">
            <div class="mb-2">
              <input type="text" class="form-control" name="nama" placeholder="Nama siswa">
            </div>
            <div class="mb-2">
            <select class="form-select" name="jk" >
              <option value="">Pilih Jenis Kelamin</option>
              <option value="L">Laki Laki</option>
              <option value="P">Perempuan</option>
            </select>
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="nis" placeholder="NIS">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="nisn" placeholder="NISN">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="kelas" placeholder="Kelas">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="tmplahir" placeholder="Tempat Lahir">
            </div>
            <div class="mb-2">
            <input type="date" value="2023-09-19" name="tgllahir" class="form-control mb-2">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="alamat" placeholder="Alamat">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="nayah" placeholder="Nama Ayah">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="pekerjaan" placeholder="Pekerjaan Ayah">
            </div>
            <div class="mb-2">
              <input type="text" class="form-control" name="nibu" placeholder="Nama Ibu">
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <input type="submit" name="tambah" class="btn btn-primary ms-auto" value="Tambah">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-danger"></div>
          <div class="modal-body text-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" /><path d="M12 9v4" /><path d="M12 17h.01" /></svg>
            <h3>Apakah Anda yakin?</h3>
            <div class="text-secondary">Ingin menghapus siswa ini </div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    Cancel
                  </a></div>
                <div class="col">
                <a href="" class="btn btn-danger w-100" id="delete_link">
                    Delete
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      function confirm_modal(delete_url){
        document.getElementById('delete_link').setAttribute('href' , delete_url);
      }

      function update(id){

      }
        setTimeout(function(){
          $('.alert').fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
          });
        }, 1500);
    </script>
    <script src="./vendor/js/tabler.min.js?1692870487" defer></script>
    <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="./vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./vendor/datatables/datatables-demo.js"></script>
    </script>
  </body>
</html>