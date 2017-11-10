<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Transaction;

use Exception;
use Validator;

class UserController extends Controller
{
    
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $currentUser = Auth::user();

    }

    public function create() {
    }

    public function store(Request $request) {

        $this->validate($request, [
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL|max:255',
            'active' => 'boolean',
            'password' => 'required|min:6|same:password_confirm|max:255'
        ]);

        $user = new User;

        $user->id = \Webpatser\Uuid\Uuid::generate(4);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect()->route('login');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();
        if ($user != $currentUser) {
            return redirect()->route('access_denied');
        }
        return view('user.account', ['user' => $user]);
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
    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();

        if (! $user->isSameAs($currentUser)) {
            return redirect()->route('access_denied');
        }

        $this->validate($request, [
            'email' => 'required|max:255',
            'active' => 'boolean',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        if ($user->isSameAs($currentUser)) {
            if ($request->email !== $user->email) {
                $this->validate($request, [
                    'email' => 'unique:users,email,NULL,id,deleted_at,NULL'
                ]);
            }
            $user->email  = $request->email;
        }
        $user->active     = !is_null($request->active);

        if ($user->isSameAs($currentUser)) {
            if ($request->password != '') {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:6|same:password_confirm|max:255'
                ]);

                if ($validator->fails()) {
                    return back()->withErrors($validator);
                }
                $user->password = bcrypt($request->password);
            }
        }

        $user->save();

        return view('user.account', ['user' => $user, 'message' => 'User successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        if ($user->isSameAs($currentUser)) {
            throw new Exception("Cannot delete; user is same as current user");
        }

        $user->delete();
        return "user deleted";
    }

    public function activate(Request $request, User $user) {
        $user->active = true;
        $user->save();
    }

    public function deactivate(Request $request, User $user) {
        $user->active = false;
        $user->save();
    }

    public function api_fetchTransactionData (Request $request, User $user) {

        return $user->transactions;

    }

}
