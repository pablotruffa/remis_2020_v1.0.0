<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('testing',[
    'uses' => 'TestingController@index',
    'as'   => 'testing.index'
]);

Route::get('login', [
    'as' => 'auth.login',
    'uses' => 'AuthController@formLogin'
])->middleware('guest');
Route::post('login', [
    'as' => 'auth.doLogin',
    'uses' => 'AuthController@doLogin'
])->middleware('guest');



Route::middleware(['auth'])->group(function(){
    
    Route::get('logout', [
        'as' => 'auth.logout',
        'uses' => 'AuthController@logout'
    ]);

    Route::get('/', [
        'uses' => 'HomeController@index',
        'as' => 'home'
    ]);

    Route::post('trips/toPdf', [
        'uses' => 'BalanceController@pdfTrips',
        'as' => 'pdfTrips'
    ]);
    
    Route::middleware(['driver'])->group(function(){

        Route::get('wallet', [
            'uses' => 'BalanceController@wallet',
            'as' => 'wallet'
        ]);
    
        Route::get('trips', [
            'uses' => 'BalanceController@trips',
            'as' => 'trips'
        ]);

        Route::get('profile', [
            'uses' => 'DriverController@profile',
            'as' => 'profile'
        ]);

        Route::get('trips/date', [
            'uses' => 'BalanceController@tripsByDate',
            'as' => 'trips.date'
        ]);

        Route::get('profile/edit_password', [
            'uses' => 'RemisUserController@formPassword',
            'as' => 'profile.password'
        ]);

        Route::put('profile/edit_password', [
            'uses' => 'RemisUserController@editPassword',
            'as' => 'profile.editPassword'
        ]);


    });

    Route::middleware(['root'])->group(function(){
        Route::get('users',[
            'uses'  =>'RemisUserController@index',
            'as'    =>'users.index'
        ]);

        Route::put('user/{id}/edit',[
            'uses'  =>'RemisUserController@edit',
            'as'    =>'users.edit'
        ]);

        Route::get('audit',[
            'uses'  =>'AuditController@index',
            'as'    =>'audit.index'
        ]);

        Route::get('audit/date',[
            'uses'  =>'AuditController@getAuditDate',
            'as'    =>'audit.date'
        ]);


    });

    Route::middleware(['admin'])->group(function(){
        
        /**
         ********** Car Brands ***********************************
        */
        Route::get('brands', [
            'uses' => 'CarBrandController@index',
            'as' => 'brands.index'
        ]);
        
        Route::get('brand/new', [
            'uses' => 'CarBrandController@formNew',
            'as' => 'brand.new'
        ]);
        
        Route::get('brand/{id}/edit', [
            'uses' => 'CarBrandController@formEdit',
            'as' => 'brand.formEdit'
        ]);
        
        Route::put('brand/{id}/edit', [
            'uses' => 'CarBrandController@edit',
            'as' => 'brand.edit'
        ]);
        
        Route::post('brand/new', [
            'uses' => 'CarBrandController@create',
            'as' => 'brand.create'
        ]);
        
        
        Route::delete('brand/{id}/delete', [
            'uses' => 'CarBrandController@delete',
            'as' => 'brand.delete'
        ]);
        
        
        
        /**
         ********************************* Car Colors ***********************************
        */
        
        Route::get('colors', [
            'uses' => 'CarColorController@index',
            'as' => 'colors.index'
        ]);
        
        Route::get('colors/new', [
            'uses' => 'CarColorController@formNew',
            'as' => 'color.new'
        ]);
        
        Route::post('color/new', [
            'uses' => 'CarColorController@create',
            'as' => 'color.create'
        ]);
        
        Route::get('color/{id}/edit', [
            'uses' => 'CarColorController@formEdit',
            'as' => 'color.formEdit'
        ]);
        
        Route::put('color/{id}/edit', [
            'uses' => 'CarColorController@edit',
            'as' => 'color.edit'
        ]);
        
        Route::delete('color/{id}/delete', [
            'uses' => 'CarColorController@delete',
            'as' => 'color.delete'
        ]);
        
        /**
         ********************************* Cancellation Reasons ***********************************
        */
        
        Route::get('cancellation_reasons', [
            'uses' => 'CancellationController@index',
            'as' => 'cancellation_reasons.index'
        ]);
        
        /**
         ********************************* Presenteeism ***********************************
        */
        
        Route::get('presenteeism', [
            'uses' => 'PresenteeismController@index',
            'as' => 'presenteeism.index'
        ]);
        
        Route::put('presenteeism', [
            'uses' => 'PresenteeismController@attendance',
            'as' => 'presenteeism.attendance'
        ]);
        
        /**
         ********************************* Clients ***********************************
        */
        
        
        Route::get('clients',[
            'uses' => 'ClientController@index',
            'as'   => 'clients.index'
        ]);
        
        Route::get('client/new',[
            'uses' => 'ClientController@formNew',
            'as'   => 'client.formNew'
        ]);
        
        Route::post('client/new',[
            'uses' => 'ClientController@create',
            'as'   => 'client.create'
        ]);
        
        Route::get('client/{id}/info',[
            'uses' => 'ClientController@info',
            'as'   => 'client.info'
        ]);

        Route::get('client_passport/info',[
            'uses' => 'ClientController@getClientByPassport',
            'as'   => 'client.passport'
        ]);
        
        Route::get('client/{id}/edit',[
            'uses' => 'ClientController@formEdit',
            'as'   => 'client.formEdit'
        ]);
        
        Route::put('client/{id}/edit',[
            'uses' => 'ClientController@edit',
            'as'   => 'client.edit'
        ]);

        Route::patch('client/{id}/restore',[
            'uses' => 'ClientController@restore',
            'as'   => 'client.restore'
        ]);
        
        Route::delete('client/{id}/delete',[
            'uses' => 'ClientController@delete',
            'as'   => 'client.delete'
        ]);
        
        /**
         ********************************* Drivers ***********************************
        */
        
        
        Route::get('drivers',[
            'uses' => 'DriverController@index',
            'as'   => 'drivers.index'
        ]);
        
        Route::get('driver/new',[
            'uses' => 'DriverController@formNew',
            'as'   => 'driver.formNew'
        ]);
        
        Route::post('driver/new',[
            'uses' => 'DriverController@create',
            'as'   => 'driver.create'
        ]);
        
        Route::get('driver/{id}/info',[
            'uses' => 'DriverController@info',
            'as'   => 'driver.info'
        ]);

        Route::get('driver_passport/info',[
            'uses' => 'DriverController@getDriverByPassport',
            'as'   => 'driver.passport'
        ]);
        
        Route::get('driver/{id}/assign_vehicle',[
            'uses' => 'DriverController@formAssignVehicle',
            'as'   => 'driver.form_assign_vehicle'
        ]);
        
        Route::put('driver/{id}/assign_vehicle',[
            'uses' => 'DriverController@assignVehicle',
            'as'   => 'driver.assign_vehicle'
        ]);
        
        Route::put('driver/{id}/unaassign_vehicle',[
            'uses' => 'DriverController@unassignVehicle',
            'as'   => 'driver.unassign_vehicle'
        ]);
        
        Route::get('driver/{id}/edit',[
            'uses' => 'DriverController@formEdit',
            'as'   => 'driver.formEdit'
        ]);
        
        Route::put('driver/{id}/edit',[
            'uses' => 'DriverController@edit',
            'as'   => 'driver.edit'
        ]);

        Route::patch('driver/{id}/restore',[
            'uses' => 'DriverController@restore',
            'as'   => 'driver.restore'
        ]);
        
        Route::delete('driver/{id}/delete',[
        'uses' => 'DriverController@delete',
        'as'   => 'driver.delete'
        ]);
        
        /**
         ********************************* Vehicles ***********************************
        */
        
        Route::get('vehicles',[
            'uses' => 'VehicleController@index',
            'as'   => 'vehicles.index'
        ]);
        
        Route::get('vehicle/new',[
            'uses' => 'VehicleController@formNew',
            'as'   => 'vehicle.formNew'
        ]);
        
        Route::post('vehicle/new',[
            'uses' => 'VehicleController@create',
            'as'   => 'vehicle.create'
        ]);
        
        Route::get('vehicle/{id}/info',[
            'uses' => 'VehicleController@info',
            'as'   => 'vehicle.info'
        ]);
        
        Route::get('vehicle/{id}/assign_driver',[
            'uses' => 'VehicleController@formAssignDriver',
            'as'   => 'vehicle.form_assign_driver'
        ]);
        
        Route::put('vehicle/{id}/assign_driver',[
            'uses' => 'VehicleController@assignDriver',
            'as'   => 'vehicle.assign_driver'
        ]);
        
        Route::put('vehicle/{id}/unaassign_driver',[
            'uses' => 'VehicleController@unassignDriver',
            'as'   => 'vehicle.unassign_driver'
        ]);
        
        
        Route::put('vehicle/{id}/edit',[
            'uses' => 'VehicleController@edit',
            'as'   => 'vehicle.edit'
        ]);
        
        Route::get('vehicle/{id}/edit',[
            'uses' => 'VehicleController@formEdit',
            'as'   => 'vehicle.formEdit'
        ]);
        
        Route::delete('vehicle/{id}/delete',[
            'uses' => 'VehicleController@delete',
            'as'   => 'vehicle.delete'
        ]);
        
        
        /**
         ********************************* Reservations ***********************************
        */
        
        Route::get('reservations',[
            'uses' => 'ReservationController@index',
            'as'   => 'reservations.index'
        ]);

        Route::post('reservation/search',[
            'uses' => 'ReservationController@searchConfirmation',
            'as'   => 'reservation.search'
        ]);

        Route::get('reservations/confirmed',[
            'uses' => 'ReservationController@getConfirmed',
            'as'   => 'reservations.confirmed'
        ]);

        Route::get('reservations/initiated',[
            'uses' => 'ReservationController@getInitiated',
            'as'   => 'reservations.initiated'
        ]);

        Route::get('reservations/postponed',[
            'uses' => 'ReservationController@getPostponed',
            'as'   => 'reservations.postponed'
        ]);

        Route::get('reservations/cancelled',[
            'uses' => 'ReservationController@getCancelled',
            'as'   => 'reservations.cancelled'
        ]);

        Route::get('reservations/completed',[
            'uses' => 'ReservationController@getCompleted',
            'as'   => 'reservations.completed'
        ]);
        
        Route::get('reservation/new',[
            'uses' => 'ReservationController@formNew',
            'as'   => 'reservation.formNew'
        ]);
        
        Route::post('reservation/new',[
            'uses' => 'ReservationController@create',
            'as'   => 'reservation.create'
        ]);
        
        Route::get('client/{id}/book',[
            'uses' => 'ReservationController@formNew',
            'as'   => 'client.book'
        ]);
        
        Route::get('reservation/{id}/info',[
            'uses' => 'ReservationController@info',
            'as'   => 'reservation.info'
        ]);
        
        Route::get('reservation/{id}/assign_driver',[
            'uses' => 'ReservationController@formAssignDriver',
            'as'   => 'reservation.formAssignDriver'
        ]);
        
        Route::put('reservation/{id}/start_reservation',[
            'uses' => 'ReservationController@startReservation',
            'as'   => 'reservation.startReservation'
        ]);
        
        Route::put('reservation/{id}/end_reservation',[
            'uses' => 'ReservationController@endReservation',
            'as'   => 'reservation.endReservation'
        ]);
        
        
        Route::get('reservation/date',[
            'uses' => 'ReservationController@reservationByDate',
            'as'   => 'reservation.date'
            ]);
            
        Route::get('reservation/{id}/edit',[
            'uses' => 'ReservationController@formEdit',
            'as'   => 'reservation.formEdit'
        ]);
                
        Route::get('reservation/{id}/switch_driver',[
            'uses' => 'ReservationController@formSwitchDriver',
            'as'   => 'reservation.formSwitchDriver'
        ]);

        Route::put('reservation/{id}/edit',[
            'uses' => 'ReservationController@edit',
            'as'   => 'reservation.edit'
        ]);
        
        Route::put('reservation/{id}/rollback_to_start',[
            'uses' => 'ReservationController@rollbackToStart',
            'as'   => 'reservation.rollbackToStart'
        ]);
        
        
        Route::put('reservation/{id}/switch_driver',[
            'uses' => 'ReservationController@switchDriver',
            'as'   => 'reservation.switchDriver'
        ]);
        
        Route::get('reservation/{id}/cancel',[
            'uses' => 'CancellationController@formCancellation',
            'as'   => 'reservation.formCancellation'
        ]);
        
        Route::put('reservation/{id}/cancel',[
            'uses' => 'CancellationController@cancelReservation',
            'as'   => 'reservation.cancel'
        ]);
        
        
    
    
    });//End admin middleware
    

    
   

}); //End auth middleware

