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
    
    public function update1(Request $request){
        $post = Post::find($request->id);

        $data = array(
            'title' => $request->title,
            'content' => $request->content,
        );
        
        $post->update($data);
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

    //dodati ono velikim slovima sve kao u companyDataControleru
    //vraca sve postove za username, tako sto uzme sve postove koji imaju istu kompaniju kao i taj user.
   public function getAllPostsForCompany(Request $request){
       $username = $request->username;
       
        $company_name = DB::table('company_data')
                ->where('company_data.username', $username)
                ->select('company_data.company_name')
                ->value('company_data.company_name');
        
       
       $data = DB::table('posts')->join('company_data','posts.user_id','=','company_data.user_id')
               ->where(DB::raw('upper(company_data.company_name)'),'like', strtoupper($company_name))
               ->select('posts.*')
               ->get();
       return $data;
       
   }
   
   public function getAllPostsForUser(Request $request){
       //vrati sve postove koje je napravio vraceni user 
       
       $user_id = $request->id;
       
       $data = DB::table('posts')
               ->where('posts.user_id', $user_id)
               ->select('posts.*')
               ->get();
       
       return $data;
   }
}
