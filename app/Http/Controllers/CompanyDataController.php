<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Arr;

class CompanyDataController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return CompanyData::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return CompanyData::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return CompanyData::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $compData = CompanyData::find($id);
        $compData->update($request->all());
        return $compData;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $compData = CompanyData::find($id);
        $compData->destroy($id);
    }

//    public function userDetail($username) {
//        $user = array();
//        if ($username != "") {
//            //  $user = DB::select('select * from users u, company_data cd where cd.username = ?', $username);
//            $user = CompanyData::where("username", $username)->first();
//            return $user;
//        } else
//            return 'greska';
//
//    }
//    public function joinDetails($username) {
//       
//        
//        $data = DB::table('users')->join('company_data','users.id','=','company_data.user_id')
//                ->where('company_data.username', $username)
//                ->get();
//        //$data = DB::table('company_data')->get();
//        return $data;
//    }
    public function joinDetails($username) {


        $data = DB::table('users')->join('company_data', 'users.id', '=', 'company_data.user_id')
                ->where('company_data.username', $username)
                ->get();
        //$data = DB::table('company_data')->get();
        return $data;
    }

    private $status_code = 200;

    public function userLogin(Request $request) {

        $validator = Validator::make($request->all(),
                        [
                            "username" => "required",
                            "password" => "required"
                        ]
        );

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "validation_error" => $validator->errors()]);
        }


        // postoji li username u bazi
        $username_status = CompanyData::where("username", $request->username)->first();


        // ako user postoji proveravamo pass za taj username
        //eventualno dodati neku enkripciju na password

        if (!is_null($username_status)) {
            $password_status = CompanyData::where("username", $request->username)->where("password", $request->password)->first();

            // ako je pass dobar...
            if (!is_null($password_status)) {
                $user = $this->joinDetails($request->username);

                return response()->json(["status" => $this->status_code, "success" => true, "message" => "You have logged in successfully", "data" => $user]);
            } else {
                return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. Incorrect password."]);
            }
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Unable to login. Username doesn't exist."]);
        }
    }

    public function getAllUserDetails(Request $request) {

        $username = $request->username; //ubogdanovic
//        if(is_null($username)){
//            return response()->json(["status" => "failed", "success" => false, "message" => "User with that username does not exists"]);
//        }

        $company_name = DB::table('company_data')
                ->where('company_data.username', $username)
                ->select('company_data.company_name')
                ->value('company_data.company_name');

        $company_names = DB::table('company_data')
                ->select('company_data.company_name')
                ->get();

        $array = [];
        $count = 0;
        foreach ($company_names as $post) {
            if (strtoupper($company_name) == strtoupper($post->company_name)) {
                array_push($array, strtoupper($post->company_name));
                $count++;
            }
            if ($count > 0) {
                break;
            }
        }

//        $compay_names->each(function($post) // foreach($posts as $post) { }
//        {
//            $nesto
//        }

        $company = strtoupper($company_name);
//        $company = $company_name->company_name;
//        return $company;
        //$company_name = strtoupper($company_name); //TELENOR
        $column = 'company_data.company_name';
        $data = DB::table('users')->join('company_data', 'users.id', '=', 'company_data.user_id')
                ->where(DB::raw('upper(company_data.company_name)'), 'like', '%' . $company . '%')
                ->select('company_data.id', 'company_data.company_phone_number', 'company_data.job_type',
                        'company_data.user_id', 'users.name', 'users.surname', 'users.picture_url')
                ->get();
        //$data = DB::table('company_data')->get();
        return $data;
    }

    public function registration(Request $request) {
        $validator = Validator::make($request->all(), [
                    "username" => "required",
                    "password" => "required",
                    "name" => "required",
                    "surname" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }

//        $name                   =       $request->name;
//        $name                   =       explode(" ", $name);
//        $first_name             =       $name[0];
//        $last_name              =       "";
//
//        if(isset($name[1])) {
//            $last_name          =       $name[1];
//        }

        $userDataArray = array(
            "phone_number" => $request->phone_number,
            "name" => $request->name,
            "surname" => $request->surname,
            "picture_url" => $request->picture_url,
            "birth_date" => $request->birth_date
        );
        
      
        
        $user_status = DB::table('users')
                ->join('company_data','company_data.user_id','=','users.id')
                ->where("company_data.username", $request->username)
                ->get();
//        $id_user             = DB::table('users')
//                ->where("username", $request->username)
//                ->value("id");
//        
//        $company_data_status = CompanyData::where("user_id", $id_user)->first();
        
        if (!empty($user_status)) {
            return response()->json(["status" => "failed", "success" => false, "message" => "Whoops! username already registered"]);
        }
        //return 'stigao ovde';
        $user = User::create($userDataArray);
        
        if (!is_null($user)) {
             $companyDataArray = array(
                "username" => $request->username,
                "password" => $request->password,
                "company_name" => $request->company_name,
                "company_phone_number" => $request->company_phone_number,
                "job_type" =>$request->job_type,
                "id" => $user->id
            );
            
            $company_data = CompanyData::create($companyDataArray);
            
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Registration completed successfully", "data" => array($user,$company_data)]);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "failed to register"]);
        }
    }

}
