<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\CompanyData;

class PostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //create all post

        $request->validate([
            'title' => 'required',
        ]);

        return Post::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //show posts...
        return Post::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //update post
        $post = Post::find($id);
        $post->update($request->all());
        return $post;
    }

    public function update1(Request $request) {
        $remember_token = $this->getRememberToken($request->username);

        if ($remember_token == $request->token) {
            $post = Post::find($request->id);
            //var_dump("USAO OVDE");
            $data = array(
                'title' => $request->title,
                'content' => $request->content,
            );

            $post->update($data);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Unauthorized"]);
        }
    }

    public function create(Request $request) {
        $remember_token = $this->getRememberToken($request->username);
        $request->validate([
            'title' => 'required',
        ]);


        if ($remember_token == $request->token) {

            $data = array(
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user_id,
            );

            return Post::create($data);
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Unauthorized"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //delete post
            $post = Post::find($id);
            $post->destroy($id);
        }
    
     public function delete(Request $request) {
        //delete post
        $remember_token = $this->getRememberToken($request->username);

        if ($remember_token == $request->token) {
            $post = Post::find($request->$id);
            $post->destroy($request->$id);
            
            return "USPESNO BRISANJE!!!!!!!!!!";
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Unauthorized"]);
        }
    }

    //dodati ono velikim slovima sve kao u companyDataControleru
    //vraca sve postove za username, tako sto uzme sve postove koji imaju istu kompaniju kao i taj user.
    public function getAllPostsForCompany(Request $request) {

        $remember_token = $this->getRememberToken($request->username);

        if ($remember_token == $request->token) {
            $username = $request->username;

            $company_name = DB::table('company_data')
                    ->where('company_data.username', $username)
                    ->select('company_data.company_name')
                    ->value('company_data.company_name');


            $data = DB::table('posts')->join('company_data', 'posts.user_id', '=', 'company_data.user_id')
                    ->where(DB::raw('upper(company_data.company_name)'), 'like', strtoupper($company_name))
                    ->select('posts.*')
                    ->get();
            return $data;
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Unauthorized"]);
        }
    }

    public function getAllPostsForUser(Request $request) {
        //vrati sve postove koje je napravio vraceni user 
//       try{
//           $user = auth()->userOrFail();
//       }catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
//           return response()->json(['error'=>$e->getMessage()]);
//       }
//       
//       return $user;
        $remember_token = $this->getRememberToken($request->input('username'));

        if ($remember_token == $request->input('token')) {

            $user_id = $request->id;

            $data = DB::table('posts')
                    ->where('posts.user_id', $user_id)
                    ->select('posts.*')
                    ->get();

            return $data;
        } else {
            return response()->json(["status" => "failed", "success" => false, "message" => "Unauthorized"]);
        }
    }

    public function getRememberToken($username) {
        $remember_token = DB::table('users')
                ->where("username", $username)
                ->value('remember_token');

        return $remember_token;
    }

    public function getRememberTokenId($id) {
        $remember_token = DB::table('users')
                ->where("id", $id)
                ->value('remember_token');

        return $remember_token;
    }

}
