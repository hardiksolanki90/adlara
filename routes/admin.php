<?php
Route::group(['prefix' => 'authority'], function () {
    Route::group(['middleware' => ['admins']], function () {
      Route::get('dashboard', 'AdminControllers\DashboardController@initContent');
      Route::get('employee/list', 'AdminControllers\EmployeeController@initListing');

      //COnfiguration
      Route::get('configuration', 'AdminControllers\ConfigurationController@initContentCreate');
      Route::post('configuration', 'AdminControllers\ConfigurationController@initProcessCreate');

      //Clear Cache
      Route::get('clear/cache', 'AdminControllers\ConfigurationController@initProcessClearCache');

      //Media
      Route::get('media', 'AdminControllers\MediaController@initListing');
      Route::post('media', 'AdminControllers\MediaController@initCreating');
      Route::post('media/save/embeded', 'AdminControllers\MediaController@initCreatingSaveEmbeded');
      Route::post('media/save/cropped/{id_media}', 'AdminControllers\MediaController@initCreatingSaveCropped');
      Route::post('media/save/{id_media}', 'AdminControllers\MediaController@initCreatingSave');
      Route::get('media/library', 'AdminControllers\MediaController@initGetLibrary');
      Route::get('media/library/{type}', 'AdminControllers\MediaController@initGetLibrary');
      Route::get('media/delete/{id_media}', 'AdminControllers\MediaController@initDeleting');

    });

    Route::get('login', 'AdminControllers\LoginController@initContent');
    Route::post('login', 'AdminControllers\LoginController@login');
    Route::get('logout', 'AdminControllers\LoginController@logout');

    Route::get('employee/create', 'AdminControllers\EmployeeController@initContentCreate');
    Route::post('employee/create', 'AdminControllers\EmployeeController@initProcessCreate');
    Route::get('employee/edit/{id}', 'AdminControllers\EmployeeController@initContentCreate');
    Route::post('employee/edit/{id}', 'AdminControllers\EmployeeController@initProcessCreate');
});
