<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

if(!isset($_SESSION)){
    session_start();
}

class PasswordGeneratorController extends Controller
{
    public function login(Request $request){
        $database = $request->database;
        $username = $request->username;
        $password = $request->password;


        $_SESSION['database'] = $database;

        if($database == 'postgre'){
            if($username == 'ABC' && $password == '123'){
                $_SESSION['login'] = true;
                $_SESSION['kodeigr'] = '22';
                $_SESSION['user'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['connection'] = 'semarang';
                $_SESSION['status'] = 'generator';

                return 'success';
            }
            else{
                $status = 'failed';
                $message = 'Username atau password salah!';

                return compact(['status','message']);
            }
        }
        else if($database == 'oracle'){
            if($username == 'ABC' && $password == '123'){
                $_SESSION['login'] = true;
                $_SESSION['kodeigr'] = '22';
                $_SESSION['user'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['connection'] = 'simsmg';
                $_SESSION['status'] = 'generator';

                return 'success';
            }
            else{
                $status = 'failed';
                $message = 'Username atau password salah!';

                return compact(['status','message']);
            }
        }
    }

    public function logout(){
        session_destroy();

        return redirect('/password-generator/login');
    }

    public function index(){
        if(isset($_SESSION['login']) && $_SESSION['login'] == true)
            return view('PasswordGeneratorIndex');
        else return redirect('/password-generator/logout');
    }

    public static function generate(Request $request){
        $cabang = $request->cabang;
        $jam = $request->jam;
        $tanggal = $request->tanggal;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        if($jam < $cabang)
            $c1 = $jam * $cabang;
        else $c1 = $jam;

        $c2 = abs($cabang - $jam);

        $c3 = abs(24 + $cabang - $tanggal);

        if($bulan >= 5)
            $c4 = Self::factorial($bulan);
        else $c4 = Self::factorial(10 - $bulan);

        $c5 = Self::cek($c1,$jam) * Self::cek($c2,$jam) * Self::cek($c3,$jam) * Self::cek($c4,$jam);

        $pass = $cabang + $jam + $tanggal + $bulan + $tahun + $c1 + $c2 + $c3 + $c4 + $c5;

        if(strlen($pass) > 6)
            $pass = substr($pass,-6);
        else if(strlen($pass) < 6){
            for($i=strlen($pass);$i<6;$i++){
                $pass .= 0;
            }
        }

        try{
            if($_SESSION['database'] == 'postgre'){
                DB::connection($_SESSION['connection'])
                    ->table('log_otp')
                    ->insert([
                        'otp_kodeigr' => $_SESSION['kodeigr'],
                        'otp_tanggal' => $tanggal.'/'.$bulan.'/'.$tahun,
                        'otp_jam' => $jam,
                        'otp_kode' => $pass,
                        'otp_user' => $request->user,
                        'otp_keterangan' => $request->keterangan,
                        'otp_create_by' => $_SESSION['user'],
                        'otp_create_dt' => DB::RAW("NOW()")
                    ]);
            }
            else{
                DB::connection($_SESSION['connection'])
                    ->table('log_otp')
                    ->insert([
                        'otp_kodeigr' => $_SESSION['kodeigr'],
                        'otp_tanggal' => $tanggal.'/'.$bulan.'/'.$tahun,
                        'otp_jam' => $jam,
                        'otp_kode' => $pass,
                        'otp_user' => $request->user,
                        'otp_keterangan' => $request->keterangan,
                        'otp_create_by' => $_SESSION['user'],
                        'otp_create_dt' => DB::RAW("SYSDATE")
                    ]);
            }
        }
        catch(QueryException $e){
            $status = 'error';
            $title = 'Gagal generate password!';
            $message = $e->getMessage();

            return compact(['status','title','message']);
        }
        finally{
            $status = 'success';
            $title = 'OTP berhasil digenerate!';

            return compact(['status','title','pass']);
        }
    }

    public static function get($cabang){
        $jam = Carbon::now()->hour;
        $tanggal = Carbon::now()->day;
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        if($jam < $cabang)
            $c1 = $jam * $cabang;
        else $c1 = $jam;

        $c2 = abs($cabang - $jam);

        $c3 = abs(24 + $cabang - $tanggal);

        if($bulan >= 5)
            $c4 = Self::factorial($bulan);
        else $c4 = Self::factorial(10 - $bulan);

        $c5 = Self::cek($c1,$jam) * Self::cek($c2,$jam) * Self::cek($c3,$jam) * Self::cek($c4,$jam);

        $pass = $cabang + $jam + $tanggal + $bulan + $tahun + $c1 + $c2 + $c3 + $c4 + $c5;

        if(strlen($pass) > 6)
            $pass = substr($pass,-6);
        else if(strlen($pass) < 6){
            for($i=strlen($pass);$i<6;$i++){
                $pass .= 0;
            }
        }

        return $pass;
    }

    public static function factorial($number){
        $result = 1;
        for ($i=1; $i <= $number; $i++) {
            $result = $result * $i;
        }
        return $result;
    }

    public static function cek($a, $b){
        if($a > 0)
            return $a;
        else return $b;
    }

    public function report(){
        $tanggal = $_GET['tanggal'];
        $data = '';

        if(strlen($tanggal) != '10')
            return '<h1 style="text-align: center">Record Password Generator tidak ditemukan!</h1>';

        if($_SESSION['database'] == 'postgre') {
            $data = DB::connection($_SESSION['connection'])
                ->table('log_otp')
                ->select('*')
                ->where('otp_create_dt','>=',DB::RAW("to_timestamp('".$tanggal."','dd-mm-yyyy')"))
                ->where('otp_create_dt','<=',DB::RAW("to_timestamp('".$tanggal." 23:59:59','dd-mm-yyyy hh24:mi:ss')"))
                ->orderBy('otp_create_dt', 'asc')
                ->get();
        }
        else{
            $data = DB::connection($_SESSION['connection'])
                ->table('log_otp')
                ->select('*')
                ->whereRaw("trunc(otp_create_dt) = to_date('".$tanggal."','dd-mm-yyyy')")
                ->orderBy('otp_create_dt', 'asc')
                ->get();
        }

        if(count($data) == 0)
            return '<h1 style="text-align: center">Record Password Generator tidak ditemukan!</h1>';
        else{
            $bulan = array(
                'Januari', 'Februri', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );

            $periode = substr($tanggal, 0, 2) . ' ' . $bulan[(int)substr($tanggal, 3, 2) - 1] . ' ' . substr($tanggal, 5, 4);

            $data = [
                'tanggal' => $tanggal,
                'record' => $data
            ];

            $now = Carbon::now('Asia/Jakarta');
            $now = date_format($now, 'd-m-Y H-i-s');

            $dompdf = new PDF();

//            dd($data);

            $pdf = PDF::loadview('PasswordGeneratorReportView', $data);

            error_reporting(E_ALL ^ E_DEPRECATED);

            $pdf->output();
            $dompdf = $pdf->getDomPDF()->set_option("enable_php", true);

            $canvas = $dompdf ->get_canvas();
            $canvas->page_text(1000, 10, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 8, array(0, 0, 0));

            $dompdf = $pdf;

            // (Optional) Setup the paper size and orientation
            //        $dompdf->setPaper('a4', 'landscape');

            // Render the HTML as PDF
            return $dompdf->stream('Report' . $now . '.pdf');
        }
    }
}
