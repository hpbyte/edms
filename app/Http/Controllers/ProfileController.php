<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
use App\User;
// to determine if the current user is logged in
use Illuminate\Support\Facades\Auth;
use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
      return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
          // The user is logged in
          $user = Auth::user();
          return view('pages.profile')->with('acc',$user);
        }
        return view('/');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('/profile')->with('success','Profile Updated');
    }

    public function changePassword(Request $request) {
        $this->validate($request,[
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed'
        ]);

        $user = Auth::getUser();
        if (Hash::check($request->get('current_password'), $user->password)) {
            // if the current password is correct
            $user->password = $request->input('new_password');
            $user->save();

            return redirect('/profile')->with('success','Password Successfully Changed');
        } else {
            return redirect()->back()->withErrors('Current Password is incorrect!');
        }
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
