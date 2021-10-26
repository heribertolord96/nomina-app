<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function index()
    {
        $employes = Employe::get();
        return $employes;
    }

    public function create(Request $request)
    {
        try {
            $employe = new Employe();
            $employe->name = $request->name;
            $employe->first_last_name = $request->first_last_name;
            $employe->second_lastname = $request->second_lastname;
            $employe->email = $request->email;
            $employe->code = $request->code;
            $employe->contract_type = $request->contract_type;
            $employe->active = $request->active;
            $employe->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function enable(Request $request)
    {
        $employe = Employe::findOrFail($request->id);
        $employe->active = true;
        $employe->save();
        return $employe;
    }
    public function disable(Request $request)
    {
        $employe = Employe::findOrFail($request->id);
        $employe->active = false;
        $employe->save();
        return response()->json("disabled");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employe  $employe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $employe = Employe::findOrFail($request->id);
            $employe->name            = $request->name;
            $employe->first_last_name = $request->first_last_name;
            $employe->second_lastname = $request->second_lastname;
            $employe->email           = $request->email;
            $employe->code            = $request->code;
            $employe->contract_type   = $request->contract_type;
            $employe->active          = $request->active;
            $employe->save();
            return response()->json($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
        $employe = Employe::findOrFail($request->id);
        $employe->active = true;
        $employe->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
