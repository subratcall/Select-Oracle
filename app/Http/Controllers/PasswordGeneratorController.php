<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasswordGeneratorController extends Controller
{
    public function index(){
        $cabang = $_SESSION['kodeigr'];
        return view('PasswordGeneratorIndex')->with(compact(['cabang']));
    }

    public static function generate(Request $request){
        $cabang = $_SESSION['kodeigr'];
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

        return $pass;
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
}
