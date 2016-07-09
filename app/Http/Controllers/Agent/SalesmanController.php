<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\AgentController;
use App\Models\SphereMask;
use Validator;
use App\Models\Agent;
use App\Models\Salesman;
use App\Models\SalesmanInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\AdminUsersEditFormRequest;
use Datatables;

class SalesmanController extends AgentController {
     /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        $salesmen = Agent::find($this->uid)->salesmen()->get();
        return view('agent.salesman.index')->with('salesmen',$salesmen);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('agent.salesman.create')->with('salesman',NULL);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(AdminUsersEditFormRequest $request)
    {
        $agent = Agent::with('sphereLink','bill')->findOrFail($this->uid);

        $salesman=\Sentinel::registerAndActivate($request->except('password_confirmation','sphere'));
        $salesman->update(['password'=>\Hash::make($request->input('password'))]);
        $role = \Sentinel::findRoleBySlug('salesman');
        $salesman->roles()->attach($role);

        $salesman = Salesman::find($salesman->id);

        $salesman->info()->save(new SalesmanInfo([
            'agent_id'=>$agent->id,
            'sphere_id'=>$agent->sphereLink->sphere_id,
            'bill_id'=>$agent->bill->id,
        ]));

        return redirect()->route('agent.salesman.edit',[$salesman->id]);
    }

    public function edit($id)
    {
        $salesman = Salesman::findOrFail($id);
        return view('agent.salesman.create')->with('salesman',$salesman);
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
        return response()->route('agent.salesman.index');
    }



}
