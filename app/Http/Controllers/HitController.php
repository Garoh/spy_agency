<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\Hit;
use App\ManagerUsers;
use App\User;

class HitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->id == 1)
            $model = Hit::all();

        if (Auth::user()->type == 2){
            $hitmens = ManagerUsers::where('id_user_manager', Auth::user()->id)
                                ->pluck('id_user_hitmen')
                                ->toArray();

            array_push($hitmens, Auth::user()->id);

            $model = Hit::whereIn('id_user_assigned', $hitmens)->get();
        }

        if (Auth::user()->type == 3)
            $model = Hit::where('id_user_assigned', Auth::user()->id)->get();

        $created = $request->created ? 'Hit Created' : null;
        $updated = $request->updated ? 'Hit Updated' : null;

        return view('hits.index', compact('model', 'created', 'updated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->type == 3) 
            abort(403, 'Unauthorized action.');

        $model = new Hit();
        $title = 'Create';
        $readonly = '';

        if (Auth::user()->id == 1)
            $hitmens = User::where('id', '<>', 1)
                            ->where('active', 1)
                            ->get();

        if (Auth::user()->type == 2){
            $hitmens = ManagerUsers::where('id_user_manager', Auth::user()->id)
                                ->pluck('id_user_hitmen')
                                ->toArray();

            $hitmens = User::whereIn('id', $hitmens)
                            ->where('active', 1)
                            ->get();
        }
        
        return view('hits.form', compact('model', 'title', 'readonly', 'hitmens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->type == 3) 
            abort(403, 'Unauthorized action.');

        $validator = Validator::make($request->all(), [
            'id_user_assigned' => 'required',
            'description' => 'required',
            'target' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('hits.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $model = new Hit();
        $model->fill($request->all());
        $model->status = 0;
        $model->id_user_creator = Auth::user()->id;

        $model->save();

        return redirect()->route('hits.index', ['created' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Hit::find($id);
        $title = 'Show';
        $readonly = 'readonly';


        if (Auth::user()->type == 3 && $model->id_user_assigned != Auth::user()->id)
            abort(403, 'Unauthorized action.');

        $hitmens = ManagerUsers::where('id_user_manager', Auth::user()->id)
                                ->pluck('id_user_hitmen')
                                ->toArray();

        if (Auth::user()->type == 2){

            if(!in_array($model->id_user_assigned, $hitmens))
                abort(403, 'Unauthorized action.');

            $hitmens = User::whereIn('id', $hitmens)
                            ->where('active', 1)
                            ->get();
        }


        if (Auth::user()->id == 1)
            $hitmens = User::where('id', '<>', 1)
                            ->where('active', 1)
                            ->get();

        
        return view('hits.form', compact('model', 'title', 'readonly', 'hitmens'));
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
        $model = Hit::find($id);

        if ($model->status != 0)
            return redirect()->route('hits.index', '');

        $validator = Validator::make($request->all(), [
            'id_user_assigned' => 'required',
            'description' => 'required',
            'target' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('hits.show', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($model->status == 0) {
            
            if (Auth::user()->type != 3)
                $model->id_user_assigned = $request->id_user_assigned;

            if (Auth::user()->type == 3)
                $model->status = $request->status;

            $model->save();
        }


        return redirect()->route('hits.index', ['updated' => true]);
    }
}
