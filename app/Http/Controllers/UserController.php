<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\ManagerUsers;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->type == 3) 
            abort(403, 'Unauthorized action.');

        if (Auth::user()->id == 1)
            $model = User::where('id', '<>', 1)->get();

        if (Auth::user()->type == 2){
            $hitmens = ManagerUsers::where('id_user_manager', Auth::user()->id)
                                ->pluck('id_user_hitmen')
                                ->toArray();
            
            $model = User::whereIn('id', $hitmens)->get();
        }

        $created = $request->created ? 'User Created' : null;
        $updated = $request->updated ? 'User Updated' : null;

        return view('users.index', compact('model', 'created', 'updated'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = User::find($id);

        if (Auth::user()->type == 3)
            abort(403, 'Unauthorized action.');

        $hitmens = ManagerUsers::where('id_user_manager', Auth::user()->id)
                                ->pluck('id_user_hitmen')
                                ->toArray();

        if (Auth::user()->type == 2){

            if(!in_array($model->id_user_assigned, $hitmens))
                abort(403, 'Unauthorized action.');
        }

        $managers = User::where('type', 2)->get();
        $manage = ManagerUsers::where('id_user_hitmen', $id)->first();
        $model->id_manager = is_null($manage) ? null :  $manage->id_user_manager;
        $lackeys = ManagerUsers::where('id_user_manager', $id)->get();

        
        return view('users.form', compact('model', "managers", 'lackeys'));
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
        $model = User::find($id);

        if ($model->active != 1)
            return redirect()->route('users.index', '');

        if (isset($request->id_user_manager)) {
            ManagerUsers::where('id_user_manager', '<>', $request->id_user_manager)
                                ->where('id_user_hitmen', $id)
                                ->delete();

            $exists = ManagerUsers::where('id_user_manager', $request->id_user_manager)
                                ->where('id_user_hitmen', $id)->exists();

            if (!$exists) {
                $managerUsers = new ManagerUsers();
                $managerUsers->id_user_manager = $request->id_user_manager;
                $managerUsers->id_user_hitmen = $id;

                $managerUsers->save();
            }
        }

        if (isset($request->active)) {
            $model->active = $request->active;
            $model->save();
        }

        return redirect()->route('users.index', ['updated' => true]);
    }
}
