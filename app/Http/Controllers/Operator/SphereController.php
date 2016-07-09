<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Agent;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\LeadInfoEAV;
use App\Models\Sphere;
use App\Models\SphereMask;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use App\Http\Requests\Admin\ArticleRequest;

class SphereController extends Controller {

    public function __construct()
    {
        view()->share('type', 'article');
    }
     /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $spheres = Sphere::with('leads')->active()->get();
        return view('sphere.lead.list')->with('spheres',$spheres);
    }

    /**
     * Show the form to edit resource.
     *
     * @return Response
     */
    public function edit($sphere,$id)
    {
        $data = Sphere::findOrFail($sphere);
        $data->load('attributes.options','leadAttr.options','leadAttr.validators');
        $mask = new SphereMask($data->id);
        $mask = $mask->findShortMask($id);

        $lead = Lead::with('phone')->find($id);
        $lead_info=$lead->info()->lists('value','lead_attr_id');
        return view('sphere.lead.edit')
            ->with('sphere',$data)
            ->with('mask',$mask)
            ->with('lead',$lead)
            ->with('leadInfo',$lead_info);
    }

    /**
     * Store the resource in storage.
     *
     * @return Response
     */
    public function update(Request $request,$sphere_id,$lead_id)
    {
        $validator = Validator::make($request->except('info'), [
            'options.*' => 'integer',
        ]);
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $sphere = Sphere::findOrFail($sphere_id);
        $mask = new SphereMask($sphere->id);
        $options=array();
        if ($request->has('options')) {
            $options=$request->only('options')['options'];
        }
        $mask->setAttr($options,$lead_id);
        $mask->setType('lead',$lead_id);

        $lead = Lead::find($lead_id);

        $lead->name=$request->input('name');
        $lead->email=$request->input('email');
        $lead->comment=$request->input('comment');
        $customer = Customer::firstOrCreate(['phone'=>preg_replace('/[^\d]/','',$request->input('phone'))]);
        $lead->customer_id=$customer->id;
        $lead->save();


        $lead->info()->delete();
        if(count($request->only('info')['info'])) {
            $save_arr = array();
            foreach ($request->only('info')['info'] as $key => $val) {
                $save_arr[] = new LeadInfoEAV(['lead_attr_id' => $key, 'value' => $val]);
            }
            $lead->info()->saveMany($save_arr);
            unset($save_arr);
        }

        if($request->ajax()){
            return response()->json();
        } else {
            return redirect()->route('operator.sphere.index');
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
        Agent::findOrFail(\Sentinel::getUser()->id)->leads()->whereIn([$id])->delete();
        return response()->route('agent.lead.index');
    }


}
