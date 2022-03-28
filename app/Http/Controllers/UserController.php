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
        //
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // event(new Registered($user));

        // Auth::login($user);
        // $user=new User();
        // $user->phone=$request->phone;
        // if($request->hasFile('image')){
        //     $compliteFileName = $request->file('image')->getClientOriginalName();
        //     // $filaNameOnly = pathinfo($compliteFileName , PATHINFO_FILENAME);
        //     $extension = $request->file('image')->getClientOriginalExtension();
        //     $comPic = str_replace(' ' , '' , $compliteFileName).'-'.rand() . ''.time(). '.'.$extension;
        //     $path = $request->file('image')->storeAs('public/images' , $comPic);
        //     $user->image=$request->$comPic;
        // }
        // $user->save();
        // redirect to route and return response

        
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
        //
        dd(Auth::user());
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
            if($request->hasFile('image')){
                $compliteFileName = $request->file('image')->getClientOriginalName();
                $filaNameOnly = pathinfo($compliteFileName , PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $comPic = str_replace(' ' , '' , $filaNameOnly).'-'.rand() . ''.time(). '.'.$extension;
                $path = $request->file('image')->storeAs('public/images' , $comPic);
                $user->image=$comPic;
            }
            $user->name = $request->name;
            if($request->input('email') == false){
                $user->email =  Auth::user()->email;
            }else{
                $user->email = $request->email;
            }
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->job_title=$request->job_title;
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
