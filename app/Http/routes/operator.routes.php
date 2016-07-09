<?php

Route::group(['prefix' => 'callcenter','middleware' => ['auth', 'operator'] ], function() {
    Route::get('/', ['as' => 'dashboard.index', 'uses' => 'Operator\OperatorController@index']);

    Route::get('sphere', ['as' => 'operator.sphere.index', 'uses' => 'Operator\SphereController@index']);

    //Route::get('sphere/create', ['as' => 'operator.sphere.create', 'uses' => 'Operator\SphereController@create']);
    //Route::post('sphere/store',['as'=>'operator.sphere.store', 'uses' => 'Operator\SphereController@store']);
    Route::get('sphere/{sphere}/lead/{id}/edit',['as'=>'operator.sphere.lead.edit', 'uses' => 'Operator\SphereController@edit']);
    Route::match(['put','post'],'sphere/{sphere}/lead/{id}',['as'=>'operator.sphere.lead.update', 'uses' => 'Operator\SphereController@update']);

    //Route::resource('customer/filter','Operator\CustomerFilterController@create');
});
?>