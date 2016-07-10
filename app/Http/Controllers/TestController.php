<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\SphereAttr;
use App\Models\SphereAttrOptions;
use App\Models\SphereMask;

class TestController extends Controller
{
    //
    public function index(){
        $leads = Lead::
            join('open_leads', 'leads.id', '=', 'open_leads.lead_id')
            ->join('customers', 'leads.customer_id', '=', 'customers.id')
            ->select('leads.*', 'customers.phone')
            ->get();

/*
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
*/

        $id = 7;
/*
        $sphere_id = Lead::
             select('sphere_id')
            ->where('id', '=', $id)
            ->first()['sphere_id'];
        $sphere_bitmask = 'sphere_bitmask_'.$sphere_id;
*/
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

        $sphere_bitmask = 'sphere_bitmask_'.$checkbox['sphere_id'];
        $AID = $checkbox['attr_id'];
        $OID = $checkbox['attr_opt_id'];
        $mask = 'fb_'.$AID.'_'.$OID;

/*
        $fb_aid_oid = new SphereMask($checkbox['sphere_id']);
        $fb_aid_oid
            ->select($mask)
            ->where('user_id', '=', $checkbox['leads_id'])
            ->where('type', '=', 'lead')
            ->first()
            ;
*/
        $a = DB::table($sphere_bitmask)
                ->select($mask)
                ->where('user_id', '=', $checkbox['leads_id'])
                ->where('type', '=', 'lead')
                ->first()
            ;

        echo '<pre>'; var_dump($a->$mask); die;
        /*
         *             ->join($sphere_bitmask, function ($join){

                //echo '<pre>'; print_r($mask); die;
                $join->on('user_id', '=', 'leads.id')
                    ->where($mask, '=', '1')
                    ->where('type', '=', 'lead');
            })
         */


        return view('test_page', ['leads' => $leads]);
    }

    public function detail(){

        if ( $_GET ) {
            $id = $_GET['id'];

            $sphere_id = Lead::
                select('sphere_id')
                ->where('id', '=', $id)
                ->first()['sphere_id'];
            $sphere_bitmask = 'sphere_bitmask_'.$sphere_id;

            $radio = SphereAttr::
                where('sphere_attributes._type', '=', 'radio')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->where('leads.id', '=', $id)
                ->join('sphere_attribute_options', function ($join){
                    $join->on('sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                        ->where('sphere_attribute_options.ctype', '=', 'agent');
                })
                ->join($sphere_bitmask, function ($join){
                    $AID = SphereAttr::select('id')->first()['id'];
                    $OID = SphereAttrOptions::select('id')->first()['id'];
                    $mask = 'fb_'.$AID.'_'.$OID;
                    $join->on('user_id', '=', 'leads.id')
                        ->where($mask, '=', '1')
                        ->where('type', '=', 'lead');
                })
                ->select('sphere_attribute_options.value','label')
                ->first();

            $checkbox = SphereAttr::
                where('sphere_attributes._type', '=', 'checkbox')
                ->join ('leads', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                ->where('leads.id', '=', $id)
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


            $data = array(
                'id' => $id,
                'radio_label' => $radio->label,
                'radio_value' => $radio->value,
                'checkbox_label' => $checkbox->label,
                'checkbox_value' => $checkbox->value,
            );

            echo json_encode($data);
        }
    }

}
