<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\Models\Lead;
//use App\Models\Customer;
use App\Models\SphereAttr;
use App\Models\SphereAttrOptions;
use App\Models\SphereMask;

class TestController extends Controller
{
    //
    public function index(){

        //$leads = Lead::all();
        //$leads = Lead::select('name')->get();
        //$customers = Customer::all();

        $leads = Lead::
            join('open_leads', 'leads.id', '=', 'open_leads.lead_id')
            ->join('customers', 'leads.customer_id', '=', 'customers.id')
            ->select('leads.*', 'customers.phone')
            ->get();


        foreach ($leads as &$lead){

            $lead['radio'] = SphereAttr::
                select('id', 'label')
                ->where('_type', '=', 'radio')
                ->first();

            $lead['checkbox'] = SphereAttr::
                select('id', 'label')
                ->where('_type', '=', 'checkbox')
                ->first();

            $sphere_id = Lead::select('sphere_id')->first()['sphere_id'];
            $sphere_bitmask = 'sphere_bitmask_'.$sphere_id;

            $lead['radio_value'] = SphereAttr::
                join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->join('sphere_attribute_options', function ($join){
                    $join->on('sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                        ->where('sphere_attribute_options.ctype', '=', 'agent');
                        /*
                        $sphere_mask = new SphereMask(Lead::select('sphere_id')->first()['sphere_id']);
                        $mask = 'fb_'.SphereAttr::select('id')->first()['id'].'_'.SphereAttrOptions::select('id')->first()['id'];
                        $fb = $sphere_mask->select($mask)->first();
                        if ($fb[$mask] = 1){}
                        unset($sphere_mask);
                        */
                })
                ->join($sphere_bitmask, function ($join){
                    $mask = 'fb_'.SphereAttr::select('id')->first()['id'].'_'.SphereAttrOptions::select('id')->first()['id'];
                    //echo '<pre>'; print_r($mask);die;
                    $join->on('user_id', '=', 'leads.id')
                        ->where($mask, '=', '1')
                        ->where('type', '=', 'lead');
                })

                ->select('value','sphere_attribute_options.id')
                ->first();

            $l = Lead::
                join('sphere_bitmask_'.$lead['sphere_id'], 'leads.id', '=', 'sphere_bitmask_'.$lead['sphere_id'].'.user_id')
                ->select('leads.*')
                ->get();

            //echo '<pre>'; print_r($l);
            /*
            $aaa = SphereMask::all();
            echo '<pre>'; print_r($aaa); die;

            /*
            $sphere_mask = new SphereMask($lead['sphere_id']);
            $mask = 'fb_'.$lead['radio']['id'].'_'.$lead['radio_value']['id'];
            $fb = $sphere_mask->
                select($mask)
                ->first();


            //echo '<pre>'; print_r($mask); die;
            //echo '<pre>'; print_r($a->$mask); die;

            /*
            $lead['radio_value'] = SphereAttrOptions::
                join('sphere_attributes','sphere_attribute_options.sphere_attr_id', '=', 'sphere_attributes.id')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->select('value')
                ->where('ctype', '=', 'agent')
                ->first();
*/
        }



        //echo '<pre>'; print_r($leads['1']); die;

        return view('test_page', ['leads' => $leads]);
    }
}
