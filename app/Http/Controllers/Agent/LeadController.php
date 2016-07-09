<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\AgentController;
use App\Models\SphereMask;
use Validator;
use App\Models\Agent;
use App\Models\Salesman;
use App\Models\Credits;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\Sphere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use App\Http\Requests\Admin\ArticleRequest;
use Datatables;

class LeadController extends AgentController {
     /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('agent.lead.index');
    }

    public function deposited(){
        $leads = $this->user->leads()->with('phone')->get();
        return view('agent.lead.deposited')->with('leads',$leads);
    }

    public function obtain(){
        $agent = $this->user;
        $mask=$this->mask;

        $list = $mask->obtain()->skip(0)->take(10);
        $leads = Lead::with('obtainedBy')->whereIn('id',$list->lists('user_id'))->get();
        $lead_attr = $agent->sphere()->leadAttr()->get();
        return view('agent.lead.obtain')
            ->with('leads',$leads)
            ->with('lead_attr',$lead_attr)
            ->with('filter',$list->get());
    }

    public function obtainData(Request $request)
    {
        $agent = $this->user;
        $mask=$this->mask;

        $list = $mask->obtain();
        $leads = Lead::whereIn('id', $list->lists('user_id'))
            ->where('leads.agent_id','<>',$this->uid)
            ->select(['leads.opened', 'leads.id', 'leads.updated_at', 'leads.name', 'leads.customer_id', 'leads.email']);
        if (count($request->only('filter'))) {
            $eFilter = $request->only('filter')['filter'];
            foreach ($eFilter as $eFKey => $eFVal) {
                switch($eFKey) {
                    case 'date':
                        if($eFVal=='2d') {
                            $date = new \DateTime();
                            $date->sub(new \DateInterval('P2D'));
                            $leads->where('leads.updated_at','>=',$date->format('Y-m-d'));
                        } elseif($eFVal=='1m') {
                            $date = new \DateTime();
                            $date->sub(new \DateInterval('P1M'));
                            $leads->where('leads.updated_at','>=',$date->format('Y-m-d'));
                        } else {

                        }
                        break;
                    default: ;
                }
            }
        }

        $datatable = Datatables::of($leads)
            ->edit_column('opened',function($model){
                return view('agent.lead.datatables.obtain_count',['opened'=>$model->opened]);
            })
            ->edit_column('id',function($model){
                return view('agent.lead.datatables.obtain_open',['lead'=>$model]);
            })
            ->edit_column('status',function($model){
                return '';
            })
            ->edit_column('customer_id',function($lead) use ($agent){
                return ($lead->obtainedBy($agent->id)->count())?$lead->phone->phone:trans('lead.hidden');
            })
            ->edit_column('email',function($lead) use ($agent){
                return ($lead->obtainedBy($agent->id)->count())?$lead->email:trans('lead.hidden');
            });
        $lead_attr = $agent->sphere()->leadAttr()->get();
        foreach($lead_attr as $key=>$l_attr){
           $datatable->add_column('a_'.$key,function($lead) use ($l_attr){
                $val = $lead->info()->where('key','=',$l_attr->id)->first();
                return view('agent.lead.datatables.obtain_data',['data'=>$val,'type'=>$l_attr->_type]);
           });
        }
        return $datatable->make();
    }

    public function openLead($id){
        $agent = $this->user;
        $agent->load('bill');
        $credit = Credits::where('agent_id','=',$this->uid)->sharedLock()->first();
        $balance = $credit->balance;

        $mask=$this->mask;
        $price = $mask->findMask()->sharedLock()->first()->lead_price;

        if($price > $balance) {
            return redirect()->route('agent.lead.obtain',[0]);
        }

        $lead = Lead::lockForUpdate()->find($id);
        if($lead->sphere->openLead > $lead->opened) {
            $lead->obtainedBy()->attach($this->uid);
            $lead->opened+=1;
            $credit->payment=$price;
            $credit->save();
            //$credit->history()->save(new CreditHistory());
        }
        $lead->save();

        return redirect()->route('agent.lead.obtain');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $spheres = Sphere::active()->lists('name','id');
        return view('agent.lead.create')->with('lead',[])->with('spheres',$spheres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/\(?([0-9]{3})\)?([\s.-])*([0-9]{3})([\s.-])*([0-9]{4})/',
            'name' => 'required'
        ]);
        $agent =  $this->user;

        if ($validator->fails() || !$agent->sphere()) {
            if($request->ajax()){
                return response()->json($validator);
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }


        $customer = Customer::firstOrCreate(['phone'=>preg_replace('/[^\d]/','',$request->input('phone'))]);

        $lead = new Lead($request->except('phone'));
        $lead->customer_id=$customer->id;
        $lead->date=date('Y-m-d');

        $agent->leads()->save($lead);

        if($request->ajax()){
            return response()->json();
        } else {
            return redirect()->route('agent.lead.index');
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
        $this->user->leads()->whereIn([$id])->delete();
        return response()->route('agent.lead.index');
    }



}
