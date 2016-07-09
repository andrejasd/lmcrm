<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\AgentController;
use Validator;
use App\Models\Sphere;
use App\Models\SphereMask;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use App\Http\Requests\Admin\ArticleRequest;

class SphereController extends AgentController {
     /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $spheres = Sphere::active()->get();
        $mask=new SphereMask();
        $mask->setUserID($this->uid);

        return view('agent.sphere.index')
            ->with('spheres',$spheres)
            ->with('mask',$mask);
    }

    /**
     * Show the form to edit resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        $data = Sphere::findOrFail($id);
        $data->load('attributes.options');
        $mask = new SphereMask($data->id,$this->uid);
        $mask = $mask->findShortMask();
        return view('agent.sphere.edit')->with('sphere',$data)->with('mask',$mask);
    }

    /**
     * Store the resource in storage.
     *
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'options.*' => 'integer',
        ]);
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $sphere = Sphere::findOrFail($id);
        $mask = new SphereMask($sphere->id,$this->uid);

        $options=array();
        if ($request->has('options')) {
            $options=$request->only('options')['options'];
        }
        $mask->setAttr($options);
        $mask->setType('agent');
        $mask->setStatus(0);

        if($request->ajax()){
            return response()->json();
        } else {
            return redirect()->route('agent.sphere.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        Agent::findOrFail($this->uid)->leads()->whereIn([$id])->delete();
        return response()->route('agent.lead.index');
    }


}
