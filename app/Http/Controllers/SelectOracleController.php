<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SelectOracleController extends Controller
{
    public function login(Request $request){
        $database = $request->database;
        $cabang = '22';
        $username = $request->username;
        $password = $request->password;

        session_start();

        $_SESSION['database'] = $database;

        if($database == 'postgre'){
            if($username == 'LEO'){
                if($password == PasswordGeneratorController::get($cabang)){
                    $_SESSION['login'] = true;
                    $_SESSION['kodeigr'] = $cabang;
                    $_SESSION['user'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['connection'] = 'semarang';
                    $_SESSION['status'] = 'select';

                    return 'success';
                }
                else{
                    $status = 'failed';
                    $message = 'Username atau password salah!';

                    return compact(['status','message']);
                }
            }
            else{
                $status = 'failed';
                $message = 'Username atau password salah!';

                return compact(['status','message']);
            }
        }
        else if($database == 'oracle'){
            if($username == 'EDP'){
                $_SESSION['kodeigr'] = $cabang;

                if($password != PasswordGeneratorController::get($cabang)){
                    $status = 'failed';
                    $message = 'Username atau password salah!';

                    return compact(['status','message']);
                }
                else{
                    $_SESSION['connection'] = 'simsmg';
                    $_SESSION['login'] = true;
                    $_SESSION['user'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['status'] = 'select';

                    return 'success';
                }
            }
            else{
                $status = 'failed';
                $message = 'User tidak memiliki akses!';

                return compact(['status','message']);
            }
        }
    }

    public function logout(){
        session_destroy();

        return redirect('/select-oracle/login');
    }

    public function index(){
        $now = Carbon::now();
        $now = $now->toDateTimeString();

        if($_SESSION['database'] == 'postgre'){
            $q1 = "SELECT table_name FROM information_schema.tables WHERE table_schema='".$_SESSION['connection']."' AND table_type='BASE TABLE' ORDER BY table_name ASC";
        }
        else{
            $q1 = "SELECT object_name as table_name FROM user_objects WHERE object_type = 'TABLE' ORDER BY object_name";
        }

        $tablelist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($q1));

        $connection = $_SESSION['connection'];

        return view('SelectOracleIndex')->with(compact(['tablelist','connection','now']));
    }

    public function getColumnList(Request $request){
        if($_SESSION['database'] == 'postgre'){
            $query = "SELECT column_name,
                        case
                            when data_type='character varying' THEN 'varchar('||character_maximum_length||')'
                            when data_type='character' THEN 'varchar('||character_maximum_length||')'
                            else data_type
                        end as data_type,
                        character_maximum_length as data_length
                    FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema ='".$_SESSION['connection']."' AND table_name ='".$request->table."'";
        }
        else{
            $query = "SELECT column_name,
                        case
                            when data_type='VARCHAR2' THEN 'VARCHAR2('||data_length||')'
                            else data_type
                        end as data_type,
                        data_length
                        FROM USER_TAB_COLUMNS WHERE table_name = '".$request->table."'
                        ORDER BY column_id";
        }

        $columnlist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($query));

        return $columnlist;
    }

    public function execute(Request $request){
        $result = '';
        $table = $request->table;
        $where = '';
        $user = $_SESSION['user'];

        $query = $request->data;

        $arr = explode(' ',trim($query));

        $ok = false;
        $tipe = $arr[0];

        if(strtolower($arr[0]) != 'select'){
            $status = 'error';
            $message = 'Hanya query SELECT yang diperbolehkan!';

            return compact(['status','message']);
        }


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
        $arrResult = '';

        try{
            DB::CONNECTION($_SESSION['connection'])->beginTransaction();

            if(strtolower($tipe) == 'select'){
                $result = DB::CONNECTION($_SESSION['connection'])->SELECT(DB::RAW($query));
                $arrResult = (Array) $result;
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
                        ->table('TBHISTORY_LOGDATA')
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

//            return compact(['status','message','result']);
            return response()->json(['status' => $status, 'message' => $message, 'result' => $arrResult]);
        }
    }
}
