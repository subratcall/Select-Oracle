<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DataTables;

use SoulDoit\DataTable\SSP;
use App\TableBigData;

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

        return view('SelectOracleIndexTest')->with(compact(['tablelist','connection','now']));
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

        if($request->mode == 'manual'){
            if(strtolower($arr[0]) != 'select') {
                $status = 'error';
                $message = 'Hanya query SELECT yang diperbolehkan!';

                return compact(['status', 'message']);
            }
            else{
                for($i=0;$i<count($arr);$i++){
                    if(strtolower($arr[$i]) == 'from'){
                        $table = $arr[$i+1];
                    }
                }

                if($_SESSION['database'] == 'postgre'){
                    $queryGetColumn = "SELECT column_name
                    FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema ='".$_SESSION['connection']."' AND table_name ='".$table."'";
                }
                else{
                    $queryGetColumn = "SELECT column_name
                        FROM USER_TAB_COLUMNS WHERE table_name = '".strtoupper($table)."'
                        ORDER BY column_id";
                }

                $columnlist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($queryGetColumn));

                $column = [];
                foreach($columnlist as $c){
                    array_push($column,$c->column_name);
                }
            }
        }
        else{
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
        }

//        dd($query);

        $status = '';
        $message = '';

        try{
            DB::CONNECTION($_SESSION['connection'])->beginTransaction();

            if(strtolower($tipe) == 'insert'){
                $result = DB::CONNECTION($_SESSION['connection'])->INSERT($query);
            }
            else if(strtolower($tipe) == 'update'){
                $result = DB::CONNECTION($_SESSION['connection'])->UPDATE($query);
            }
            else if(strtolower($tipe) == 'delete'){
                $result = DB::CONNECTION($_SESSION['connection'])->DELETE($query);
            }

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
        catch(QueryException $e){
            DB::CONNECTION($_SESSION['connection'])->rollBack();

            $status = 'error';
            $message = $e->getMessage();

            return compact(['status','message']);
        }
        finally {
            DB::CONNECTION($_SESSION['connection'])->commit();

            if($status == 'error'){
                return compact(['status','message']);
            }

            $status = 'success';

            if($result > 0){
                $message = 'Ada data yang terupdate!';
            }
            else $message = 'Tidak ada data yang terupdate!';

            return response()->json(['status' => $status, 'message' => $message]);
        }
    }

    public function getData(Request $request){
        session_start();
        $query = $_SESSION['query'];
//        $result = DB::connection($_SESSION['connection'])->select($query);

        return DataTables::of(DB::connection($_SESSION['connection'])->select($query))->make(true);


//        $array = str_replace(',', '',explode(' ',$_SESSION['query']));
//
//        $table = '';
//        $column = [];
//
//        for($i=0;$i<count($array);$i++){
//            if(strtolower($array[$i]) == 'from'){
//                $table = $array[$i+1];
//                break;
//            }
//            if(strtolower($array[$i]) != 'select' && strtolower($array[$i]) != 'from' && $array[$i] != ''){
//                $c['db'] = strtolower($array[$i]);
//                array_push($column,$c);
//            }
//        }
//
//        if($column[0]['db'] == '*'){
//            if($_SESSION['database'] == 'postgre'){
//                $query = "SELECT column_name as data
//                    FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema ='".$_SESSION['connection']."' AND table_name ='".$table."'";
//            }
//            else{
//                $query = "SELECT column_name as data
//                        FROM USER_TAB_COLUMNS WHERE table_name = '".strtoupper($table)."'
//                        ORDER BY column_id";
//            }
//
//            $columnlist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($query));
//
//            $column = [];
//
//            foreach($columnlist as $c){
//                $x['db'] = strtolower($c->data);
//                array_push($column,$x);
//            }
//        }
//
//        $my_ssp = new SSP('semarang.table_big_data',$column);
//
//        return $my_ssp->getDtArr();
    }

    public function select(Request $request){
        session_start();

        $querySelect = $request['query'];

        $array = str_replace(',', '',explode(' ',$querySelect));

        $table = '';
        $column = [];
        $where = false;
        $limit = false;

        if(strtolower($array[0]) != 'select'){
            $status = 'error';
            return compact(['status']);
        }

        for($i=0;$i<count($array);$i++){
            if(strtolower($array[$i]) == 'from'){
                $table = $array[$i+1];
            }
            if(strtolower($array[$i]) != 'select' && strtolower($array[$i]) != 'from' && $array[$i] != ''){
                $c['data'] = strtolower($array[$i]);
                $c['class'] = 'nowrap';
                array_push($column,$c);
            }
            if(strtolower($array[$i]) == 'where')
                $where = true;
            if(strtolower($array[$i]) == 'limit' || strtolower($array[$i]) == 'rownum')
                $limit = true;
        }

        if($where){
            if(!$limit){
                if($_SESSION['database'] == 'oracle')
                    $querySelect .= ' AND ROWNUM <= 100';
                else{
                    $querySelect .= ' LIMIT 100';
                }
            }
        }
        else{
            if(!$limit){
                if($_SESSION['database'] == 'oracle')
                    $querySelect .= ' WHERE ROWNUM <= 100';
                else{
                    $querySelect .= ' LIMIT 100';
                }
            }
        }

        $_SESSION['query'] = $querySelect;

        dd($querySelect);

        if($column[0]['data'] == '*'){
            if($_SESSION['database'] == 'postgre'){
                $query = "SELECT column_name as data
                    FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema ='".$_SESSION['connection']."' AND table_name ='".$table."'";
            }
            else{
                $query = "SELECT column_name as data
                        FROM USER_TAB_COLUMNS WHERE table_name = '".strtoupper($table)."'
                        ORDER BY column_id";
            }

            $columnlist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($query));

            $column = [];

            foreach($columnlist as $c){
                $x['class'] = 'nowrap';
                $x['data'] = strtolower($c->data);
                array_push($column,$x);
            }

            return $column;
        }
        else return $column;
    }

    public function insertBigData(){
        session_start();

//        $result = DB::connection($_SESSION['connection'])->select('select * from table_big_data limit 1100000');
//
//        dd(count($result));


//        dd(TableBigData::all());

        $insert = [];

        for($i=0;$i<1000;$i++){
            $in['column_a'] = $i.'AAAAAAA';
            $in['column_b'] = $i.'BBBBBBB';
            $in['column_c'] = $i.'CCCCCCC';
            $in['column_d'] = $i.'DDDDDDD';
            $in['column_e'] = $i.'EEEEEEE';
            $in['column_f'] = $i.'FFFFFFF';
            $in['column_g'] = $i.'GGGGGGG';

            array_push($insert,$in);
        }

        for($i=0;$i<100;$i++){
            DB::connection($_SESSION['connection'])
                ->table('table_big_data')
                ->insert($insert);
        }
    }

    public function test(){
//        $a = DB::table('log_otp')->select('*')->get();
//
//        dd($a);

        session_start();
        $query = 'select * from table_big_data';
//        $result = DB::connection($_SESSION['connection'])->select($query);

//        return DataTables::of(DB::connection($_SESSION['connection'])->select($query))->make(true);


        $array = str_replace(',', '',explode(' ',$_SESSION['query']));

        $table = '';
        $column = [];

        for($i=0;$i<count($array);$i++){
            if(strtolower($array[$i]) == 'from'){
                $table = $array[$i+1];
                break;
            }
            if(strtolower($array[$i]) != 'select' && strtolower($array[$i]) != 'from' && $array[$i] != ''){
                $c['db'] = strtolower($array[$i]);
                array_push($column,$c);
            }
        }

        if($column[0]['db'] == '*'){
            if($_SESSION['database'] == 'postgre'){
                $query = "SELECT column_name as data
                    FROM INFORMATION_SCHEMA.COLUMNS WHERE table_schema ='".$_SESSION['connection']."' AND table_name ='".$table."'";
            }
            else{
                $query = "SELECT column_name as data
                        FROM USER_TAB_COLUMNS WHERE table_name = '".strtoupper($table)."'
                        ORDER BY column_id";
            }

            $columnlist = DB::connection($_SESSION['connection'])->SELECT(DB::RAW($query));

            $column = [];

            foreach($columnlist as $c){
                $x['db'] = strtolower($c->data);
                array_push($column,$x);
            }
        }

//        dd($column);
        $dt = [
            ['db'=>'column_a','dt'=>0],
            ['db'=>'column_b','dt'=>1],
            ['db'=>'column_c','dt'=>2],
            ['db'=>'column_d','dt'=>3],
            ['db'=>'column_e','dt'=>4],
            ['db'=>'column_f','dt'=>5],
            ['db'=>'column_g','dt'=>6],
        ];
        $my_ssp = (new SSP('table_big_data',$dt));
        dd($my_ssp->getNormalData());

        $my_ssp = ('\App\TableBigData')::select(['table_big_data.column_a']);
        $my_ssp = $my_ssp->get();

        dd($my_ssp);
    }
}
