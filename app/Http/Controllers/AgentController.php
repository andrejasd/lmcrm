<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Salesman;
use App\Models\SphereMask;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Sentinel;


class AgentController extends BaseController
{
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->uid = Sentinel::getUser()->id;
        $this->user = NULL;
        if(Sentinel::inRole('agent')) {
            $agent = Agent::findOrFail($this->uid);
            $this->user = $agent;
            $this->userClass = 'Agent';
            $bill=$agent->bill()->first();
            $sphere_id=$agent->sphere()->id;
        } elseif(Sentinel::inRole('salesman')) {
            $salesman = Salesman::findOrFail($this->uid);
            $this->user = $salesman;
            $this->userClass = 'Salesman';
            $bill=$salesman->bill()->first();
            $sphere_id=$salesman->sphere()->id;
        } else {
            return redirect()->route('login');
        }

        $this->mask = new SphereMask($sphere_id,$this->uid);
        $price = $this->mask->getPrice();
        $price = ($price && $price->lead_price)?floor($bill->balance/$price->lead_price):0;
        view()->share('balance', [0,$price]);
    }
}
