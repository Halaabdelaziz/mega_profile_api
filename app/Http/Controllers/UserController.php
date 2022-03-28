<?php

namespace App\Http\Controllers;
use  App\Models\User;
use  App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
// use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        if(Auth::user()){
            $id = Auth::user()->id;
            $user= User::find($id);
            return $user;
        }else{
            return "not authorized";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if(Auth::user()){
            $id = Auth::user()->id;
            $user= User::find($id);

            if(!$request->image){
                return 'image is required';
            }else{
                $user->image=$request->image;
            }
            if($request->input('name') == false){
                $user->name =  Auth::user()->name;
            }else{
                $user->name = $request->name;
            }
            if($request->input('email') == false){
                $user->email =  Auth::user()->email;
            }else{
                $user->email = $request->email;
            }
            $user->password = Hash::make($request->password);
            if(!$request->phone){
                $user->phone =  Auth::user()->phone;
            }else{
                $user->phone = $request->phone;
            }
            if(!$request->job_title){
                return 'job_title is required';
            }else{
                $user->job_title=$request->job_title;
            }
            $user->save();
            return $user;
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
