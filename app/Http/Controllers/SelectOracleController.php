<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SelectOracleController extends Controller
{
    public function login(Request $request){
        $database = $request->database;
        $cabang = $request->cabang;
        $username = $request->username;
        $password = $request->password;

        session_start();

        $_SESSION['database'] = $database;

        if($database == 'postgre'){
            if($username == 'LEO' && $password == '123'){
                $_SESSION['login'] = true;
                $_SESSION['kodeigr'] = $cabang;
                $_SESSION['user'] = $username;

                if($_SESSION['kodeigr'] == 22){
                    //POSTGRESQL
                    $_SESSION['connection'] = 'semarang';
                }
                else if($_SESSION['kodeigr'] == 34){
                    //POSTGRESQL
                    $_SESSION['connection'] = 'ciputat';
                }
                else{
                    //POSTGRESQL
                    $_SESSION['connection'] = 'logquery';
                }

                return 'success';
            }
            else{
                $status = 'failed';
                $message = 'Username atau password salah!';

                return compact(['status','message']);
            }
        }
        else if($database == 'oracle'){
            $_SESSION['kodeigr'] = $cabang;

            if($_SESSION['kodeigr'] == 22){
                //ORACLE
                $_SESSION['connection'] = 'simsmg';
            }
            else if($_SESSION['kodeigr'] == 34){
                //ORACLE
                $_SESSION['connection'] = 'simcpt';
            }
            else{
                //ORACLE
                $_SESSION['connection'] = 'simsmg';
            }

            $user = DB::connection($_SESSION['connection'])->table('tbmaster_user')
                ->select('encryptpwd')
                ->whereRaw("nvl(recordid, '0') <> '1'")
                ->where('userid', $username)
                ->first();

            if (!$user) {
                $status = 'failed';
                $message = 'Username tidak ditemukan!';

                return compact(['status','message']);
            }else{
                if($user->encryptpwd != md5($request->password)){
                    $status = 'failed';
                    $message = 'Username atau password salah!';

                    return compact(['status','message']);
                }
                else{
                    $_SESSION['login'] = true;
                    $_SESSION['user'] = $username;

                    return 'success';
                }
            }
        }
    }

    public function logout(){
        session_start();
        session_destroy();

        return redirect('/select-oracle/login');
    }

    public function index(){
        session_start();

//        dd($_SESSION['kodeigr']);

        if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
            return view('SelectOracleLogin');
        }
//        $q = "INSERT INTO barang(brg_kode, brg_nama, brg_qty, brg_masuk_dt, brg_masuk_by) VALUES('FAST9999', 'FASTFOOD 99', '2923', '2020-04-20 16:34:50', 'LEO')";
//
//        $x = DB::insert($q);
//        dd($x);

        if($_SESSION['database'] == 'postgre'){
            $q1 = "SELECT table_name FROM information_schema.tables WHERE table_schema='".$_SESSION['connection']."' AND table_type='BASE TABLE'";
        }
        else{
            $q1 = "SELECT DISTINCT table_name FROM all_tables;";
        }

        $tablelist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($q1));

        return view('SelectOracleIndex')->with(compact(['tablelist']));
    }

    public function getColumnList(Request $request){
        session_start();
        if($_SESSION['database'] == 'postgre'){
            $query = "SELECT column_name,
                        case
                            when data_type='character varying' THEN 'varchar('||character_maximum_length||')'
                            when data_type='character' THEN 'varchar('||character_maximum_length||')'
                            else data_type
                        end as data_type
                    FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema ='".$_SESSION['connection']."' AND table_name ='".$request->table."'";
        }
        else{
            $query = "SELECT column_name,
                        case
                            when data_type='VARCHAR2' THEN 'VARCHAR2('||data_length||')'
                            else data_type
                        end as data_type
                        FROM USER_TAB_COLUMNS WHERE table_name = '".$request->table."'";
        }

        $columnlist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($query));

        return $columnlist;
    }

    public function execute(Request $request){
        session_start();
        $result = '';
        $table = $request->table;
        $where = '';
        $user = $_SESSION['user'];

        $query = $request->data;

        $arr = explode(' ',trim($query));

        $ok = false;
        $tipe = $arr[0];


        for($i=0;$i<count($arr);$i++){
            if(strtolower($arr[$i]) == 'group' || strtolower($arr[$i]) == 'order'){
                $ok = false;
            }
            if($ok){
                $where .= $arr[$i].' ';
            }
            if(strtolower($arr[$i]) == 'where'){
                $ok = true;
            }
        }

//        dd($query);

        $status = '';
        $message = '';
        try{
            DB::CONNECTION($_SESSION['connection'])->beginTransaction();

            if(strtolower($tipe) == 'select'){
                $result = DB::CONNECTION($_SESSION['connection'])->SELECT(DB::RAW($query));
            }
            else if(strtolower($tipe) == 'insert'){
                $result = DB::CONNECTION($_SESSION['connection'])->INSERT($query);
            }
            else if(strtolower($tipe) == 'update'){
                $result = DB::CONNECTION($_SESSION['connection'])->UPDATE($query);
            }
            else if(strtolower($tipe) == 'delete'){
                $result = DB::CONNECTION($_SESSION['connection'])->DELETE($query);
            }

            if(strtolower($tipe) != 'select'){
                if($_SESSION['database'] == 'postgre'){
                    DB::CONNECTION($_SESSION['connection'])
                        ->table('log')
                        ->insert([
                            'log_table' => strtoupper($table),
                            'log_query' => $query,
                            'log_where' => $where,
                            'log_date' => DB::RAW("NOW()"),
                            'log_user' => $user,
                            'log_kodeigr' => $_SESSION['kodeigr']
                        ]);
                }
                else{
                    DB::CONNECTION($_SESSION['connection'])
                        ->table('log')
                        ->insert([
                            'log_table' => strtoupper($table),
                            'log_query' => $query,
                            'log_where' => $where,
                            'log_date' => DB::RAW("SYSDATE"),
                            'log_user' => $user,
                            'log_kodeigr' => $_SESSION['kodeigr']
                        ]);
                }
            }
        }
        catch(QueryException $e){
            DB::CONNECTION($_SESSION['connection'])->rollBack();

            $status = 'error';
            $message = $e->getMessage();

//            dd($message);
//            return $e->getMessage();
            return compact(['status','message']);
        }
        finally {
            DB::CONNECTION($_SESSION['connection'])->commit();

            if($status == 'error'){
                return compact(['status','message']);
            }

            $status = 'success';
            if(strtolower($tipe) != 'select'){
                if($result > 0){
                    $message = 'Ada data yang terupdate!';
                }
                else $message = 'Tidak ada data yang terupdate!';
            }
            else{
                $message = 'Ditemukan '.count($result).' data!';
            }

            return compact(['status','message','result']);
        }
    }
}
