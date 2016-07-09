<?php

Route::group(['prefix' => 'agent','middleware' => ['auth', 'agent|salesman'] ], function() {
    Route::get('/', ['as' => 'agent.index', 'uses' => 'Agent\AgentController@index']);

    Route::get('lead', ['as' => 'agent.lead.index', 'uses' => 'Agent\LeadController@index']);
    Route::get('lead/depostited', ['as' => 'agent.lead.deposited', 'uses' => 'Agent\LeadController@deposited']);
    Route::get('lead/obtain', ['as' => 'agent.lead.obtain', 'uses' => 'Agent\LeadController@obtain']);
    Route::get('lead/obtain/data', ['as' => 'agent.lead.obtain.data', 'uses' => 'Agent\LeadController@obtainData']);
    Route::get('lead/open/{id}', ['as' => 'agent.lead.open', 'uses' => 'Agent\LeadController@openLead']);
    Route::get('lead/create', ['as' => 'agent.lead.create', 'uses' => 'Agent\LeadController@create']);
    Route::post('lead/store',['as'=>'agent.lead.store', 'uses' => 'Agent\LeadController@store']);
    #Route::get('lead/{id}/edit',['as'=>'agent.lead.edit', 'uses' => 'Agent\LeadController@edit']);
    #Route::match(['put','post'],'lead/{id}',['as'=>'agent.lead.update', 'uses' => 'Agent\LeadController@update']);
    //Route::resource('lead','Agent\LeadController@create');

    Route::group(['middleware'=>['agent']],function() {
        Route::get('sphere', ['as' => 'agent.sphere.index', 'uses' => 'Agent\SphereController@index']);
        Route::get('sphere/create', ['as' => 'agent.sphere.create', 'uses' => 'Agent\SphereController@create']);
        Route::post('sphere/store',['as'=>'agent.sphere.store', 'uses' => 'Agent\SphereController@store']);
        Route::get('sphere/{id}/edit',['as'=>'agent.sphere.edit', 'uses' => 'Agent\SphereController@edit']);
        Route::match(['put','post'],'sphere/{id}',['as'=>'agent.sphere.update', 'uses' => 'Agent\SphereController@update']);
        //Route::resource('customer/filter','Agent\CustomerFilterController');

        Route::get('salesman', ['as' => 'agent.salesman.index', 'uses' => 'Agent\SalesmanController@index']);
        Route::get('salesman/create', ['as' => 'agent.salesman.create', 'uses' => 'Agent\SalesmanController@create']);
        Route::post('salesman/store', ['as' => 'agent.salesman.store', 'uses' => 'Agent\SalesmanController@store']);
        Route::get('salesman/{id}/edit', ['as' => 'agent.salesman.edit', 'uses' => 'Agent\SalesmanController@edit']);
        Route::match(['put', 'post'], 'salesman/{id}', ['as' => 'agent.salesman.update', 'uses' => 'Agent\SalesmanController@update']);
        //Route::resource('salesman','Agent\SalesmanController');
    });
});
?>