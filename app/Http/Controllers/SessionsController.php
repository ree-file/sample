<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
    public function create()
    {
        return view('sessions.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|max:255',
            'password' => 'required'
        ]);
        $credentials =[
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($credentials,$request->has('remember'))) {
            # code...
            session()->flash('success','欢迎回来!');
            return redirect()->intended(route('users.show',[Auth::user()]));
        }else {
            # code...
            session()->flash('danger',"你的邮箱和密码不匹配!");
            return redirect()->back();
        }
    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已经成功退出!');
        return redirect('login');
    }
}
