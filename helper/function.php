<?php

include_once('config.php');
session_start();


function get($param){
    global $conn;
    $d = isset($_GET[$param]) ? $_GET[$param] : NULL;
    $d = mysqli_real_escape_string($conn, $d);
    $d = htmlspecialchars($d);
    return $d;
}

function post($param){
    global $conn;
    $d = isset($_POST[$param]) ? $_POST[$param] : NULL;
    $d = mysqli_real_escape_string($conn, $d);
    $d = htmlspecialchars($d);
    return $d;
}

function redirect($target){
    echo '
    <script>
    window.location = "'.$target.'";
    </script>
    ';
    exit;
}

function login($u, $p){
    global $conn;
    $p = md5($p);
    $q = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");

    if(mysqli_num_rows($q)){
        $_SESSION['login'] = true;
        $_SESSION['user'] = $u;
        
        if ($_SESSION['user'] == 'admin') {
            $_SESSION['desc'] = 'Dedi Humaedi';
        }else {
            $_SESSION['desc'] = 'Jabatan Operator';
        }
        return true;
    }else{
        return false;
    }
}

function cekSession(){
    $login = isset($_SESSION['login']) ? $_SESSION['login'] : null;
    if($login == true){
        return 1;
    }else{
        return 0;
    }
}

function toastr_set($status, $msg){
    $_SESSION['toastr'] = true;
    $_SESSION['toastr_status'] = $status;
    $_SESSION['toastr_msg'] = $msg;
}

function toastr_show(){
    $t = isset($_SESSION['toastr']) ? $_SESSION['toastr'] : null;
    $t_s = isset($_SESSION['toastr_status']) ? $_SESSION['toastr_status'] : null;
    $t_m = isset($_SESSION['toastr_msg']) ? $_SESSION['toastr_msg'] : null;
    if($t == true){
        if($t_s == "success"){
            echo '<div class="alert alert-important alert-success alert-dismissible" role="alert"><div class="d-flex"><div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"></svg></div><div>'.$t_m.'</div></div><a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a></div>';
        }

        if($t_s == "error"){
            echo '<div class="alert alert-important alert-danger alert-dismissible" role="alert"><div class="d-flex"><div><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon icon-tabler-alert-triangle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg></div><div> '.$t_m.'</div></div><a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a></div>';
        }

        unset($_SESSION['toastr']);
        unset($_SESSION['toastr_status']);
        unset($_SESSION['toastr_msg']);
    }
}

function getAllsiswa(){
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM siswa");
    return $sql;
}

function tanggal_indonesia($tanggal){
        $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
        );
        
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tahun
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tanggal
 
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
    
function getRomawi($bln){

          switch ($bln){

                    case 1:

                        return "I";

                        break;

                    case 2:

                        return "II";

                        break;

                    case 3:

                        return "III";
                        break;

                    case 4:

                        return "IV";

                        break;

                    case 5:

                        return "V";

                        break;

                    case 6:

                        return "VI";

                        break;

                    case 7:

                        return "VII";

                        break;

                    case 8:

                        return "VIII";

                        break;

                    case 9:

                        return "IX";

                        break;

                    case 10:

                        return "X";

                        break;

                    case 11:

                        return "XI";

                        break;

                    case 12:

                        return "XII";

                        break;

              }

       }
       
function getBilang($kelas){
    switch ($kelas){
        case 7 :
            return "Tujuh";
        break;
        case 8 :
            return "Delapan";
        break;
        case 9 :
            return "Sembilan";
        break;
   }         
}

?>