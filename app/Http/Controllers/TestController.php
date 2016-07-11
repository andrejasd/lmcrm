<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\SphereAttr;
use Sentinel;

class TestController extends Controller
{
    //
    public function index(){

        $user = Sentinel::getUser();
        if (!is_null($user)){
            $id = $user->id;
            $leads = Lead::
                where('leads.agent_id', '=', $id)
                ->join('open_leads', 'leads.id', '=', 'open_leads.lead_id')
                ->join('customers', 'leads.customer_id', '=', 'customers.id')
                ->select('leads.*', 'customers.phone')
                ->first();
            return view('test_page', ['leads' => $leads]);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function detail(){

        $user = Sentinel::getUser();

        if ( !is_null($user)) {
            
            $id = Lead::
                where('leads.agent_id', '=', $user->id)
                ->join('open_leads', 'leads.id', '=', 'open_leads.lead_id')
                ->select('leads.id')
                ->first()
                ->id;

            $leads = Lead::
                where ('leads.id', '=', $id)
                ->join('customers', 'leads.customer_id', '=', 'customers.id')
                ->select('leads.date', 'leads.name', 'leads.email', 'customers.phone')
                ->first();

            $radio = SphereAttr::
                where('sphere_attributes._type', '=', 'radio')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->where('leads.id', '=', $id)
                ->join('sphere_attribute_options', function ($join){
                    $join->on('sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                        ->where('sphere_attribute_options.ctype', '=', 'agent');
                })
                ->select('sphere_attributes.id as attr_id', 'sphere_attribute_options.id as attr_opt_id', 'sphere_attribute_options.value',
                    'sphere_attributes.label', 'leads.id as leads_id', 'leads.sphere_id')
                ->first();

            $checkbox = SphereAttr::
              where('sphere_attributes._type', '=', 'checkbox')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->where('leads.id', '=', $id)
                ->join('sphere_attribute_options', function ($join){
                    $join->on('sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                        ->where('sphere_attribute_options.ctype', '=', 'agent');
                })
                ->select('sphere_attributes.id as attr_id', 'sphere_attribute_options.id as attr_opt_id', 'sphere_attribute_options.value',
                    'sphere_attributes.label', 'leads.id as leads_id', 'leads.sphere_id')
                ->first();

            $data = array(
                'id' => $id,
                'date' => $leads->date,
                'name' => $leads->name,
                'email' => $leads->email,
                'phone' => $leads->phone,
                'radio_label' => $radio->label,
                'radio_value' => '',
                'checkbox_label' => $checkbox->label,
                'checkbox_value' => ''
            );

            $sphere_bitmask = 'sphere_bitmask_'.$radio['sphere_id'];
            $AID = $radio['attr_id'];
            $OID = $radio['attr_opt_id'];
            $mask = 'fb_'.$AID.'_'.$OID;
            $fb_aid_oid = DB::table($sphere_bitmask)
                ->select($mask)
                ->where('user_id', '=', $radio['leads_id'])
                ->where('type', '=', 'lead')
                ->first()
            ;
            $data['radio_value'] = ($fb_aid_oid->$mask === 1) ? $radio->value : '';

            $sphere_bitmask = 'sphere_bitmask_'.$checkbox['sphere_id'];
            $AID = $checkbox['attr_id'];
            $OID = $checkbox['attr_opt_id'];
            $mask = 'fb_'.$AID.'_'.$OID;
            $fb_aid_oid = DB::table($sphere_bitmask)
                ->select($mask)
                ->where('user_id', '=', $checkbox['leads_id'])
                ->where('type', '=', 'lead')
                ->first()
            ;
            $data['checkbox_value'] = ($fb_aid_oid->$mask === 1) ? $checkbox->value : '';

            echo json_encode($data);
        }
    }

}
