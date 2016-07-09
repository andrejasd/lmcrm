<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\Models\Lead;
use App\Models\SphereAttr;
use App\Models\SphereAttrOptions;

class TestController extends Controller
{
    //
    public function index(){
        $leads = Lead::
            join('open_leads', 'leads.id', '=', 'open_leads.lead_id')
            ->join('customers', 'leads.customer_id', '=', 'customers.id')
            ->select('leads.*', 'customers.phone')
            ->get();


        foreach ($leads as &$lead){

            $sphere_id = Lead::select('sphere_id')->first()['sphere_id'];
            $sphere_bitmask = 'sphere_bitmask_'.$sphere_id;

            $lead['radio'] = SphereAttr::
                where('sphere_attributes._type', '=', 'radio')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->join('sphere_attribute_options', function ($join){
                    $join->on('sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                        ->where('sphere_attribute_options.ctype', '=', 'agent');
                })
                ->join($sphere_bitmask, function ($join){
                    $mask = 'fb_'.SphereAttr::select('id')->first()['id'].'_'.SphereAttrOptions::select('id')->first()['id'];
                    $join->on('user_id', '=', 'leads.id')
                        ->where($mask, '=', '1')
                        ->where('type', '=', 'lead');
                })
                ->select('sphere_attribute_options.value','label')
                ->first();

            $lead['checkbox'] = SphereAttr::
                where('sphere_attributes._type', '=', 'checkbox')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->join('sphere_attribute_options', function ($join){
                    $join->on('sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                        ->where('sphere_attribute_options.ctype', '=', 'agent');
                })
                ->join($sphere_bitmask, function ($join){
                    $mask = 'fb_'.SphereAttr::select('id')->first()['id'].'_'.SphereAttrOptions::select('id')->first()['id'];
                    //echo '<pre>'; print_r($mask); die;
                    $join->on('user_id', '=', 'leads.id')
                        ->where($mask, '=', '1')
                        ->where('type', '=', 'lead');
                })
                ->select('sphere_attribute_options.value', 'label')
                ->first();
        }

        //echo '<pre>'; print_r($leads['1']); die;

        return view('test_page', ['leads' => $leads]);
    }

    public function detail(){

        if ( $_GET ) {
            $id = $_GET['id'];
            $data = array(
                'id' => $id,
                'title' => 'title'
            );
            echo json_encode($data);
            die;
        }
    }

}
