<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
//use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\BusTypeController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LesController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationBookingContinueController;
use App\Http\Controllers\RouteStationController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\TripDataController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\TripStationController;
use App\Http\Controllers\RunTripController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\TripSeatController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CouponTripController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookedPackageController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\MillageController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\EfficiencyFuelController;
use App\Http\Controllers\ManuallyFuelController;
use App\Http\Controllers\EmployeeJobController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MyEmployeeController;
use App\Http\Controllers\ReservationBookingRequestController;
use App\Http\Controllers\PaymentMethodController;



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

Auth::routes();
Route::group(['middleware'=>['guest']], function ()
{
    Route::get('/', [LoginController::class,'showLoginForm']);
});

define('page' , 100);


// ====================== admin login ======================
Route::group(['namespace' => 'Auth'], function () {
    Route::post('/login', [LoginController::class,'login'])->middleware('guest')->name('login.admin');
});


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth:admin']], function(){


// ====================== admin logout ======================
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/logout', [LoginController::class,'logout'])->middleware('auth:admin')->name('logout');
    });


    // ====================== admin ( employee ) ======================
    Route::group(['middleware'=>'auth:admin'], function () {
        Route::get('get/all/employees/{id}',[AdminController::class,'getAllAdmins'])->name('getAllEmployees');
        Route::get('create/employee/page',[AdminController::class,'create_employee_page'])->name('create_employee_page');
        Route::get('edit/employee/page/{id}',[AdminController::class,'edit_employee_page'])->name('edit_employee_page');
        Route::get('show/employee/page/{id}',[AdminController::class,'show_employee_page'])->name('show_employee_page');
        Route::post('create/employee',[AdminController::class,'create_employee'])->name('create.employee');
        Route::put('update/employee',[AdminController::class,'update_employee'])->name('update.employee');
        Route::post('delete/employee',[AdminController::class,'delete'])->name('delete.employee');
    });


    // ====================== admin ( manager ) ======================
    Route::group(['middleware'=>'auth:admin'], function () {
        Route::get('get/all/managers/{id}',[AdminController::class,'getAllAdmins'])->name('getAllManagers');
        Route::post('create/manager',[AdminController::class,'create'])->name('create.manager');
        Route::put('update/manager',[AdminController::class,'update'])->name('update.manager');
        Route::post('delete/manager',[AdminController::class,'delete'])->name('delete.manager');
    });


    // ====================== driver ======================
    Route::group(['middleware'=>'auth:admin'], function () {
        Route::get('get/all/drivers',[DriverController::class,'getAllDrivers'])->name('getAllDrivers');
        Route::post('create/driver',[DriverController::class,'create'])->name('create.driver');
        Route::get('create/driver/page',[DriverController::class,'create_driver_page'])->name('create_driver_page');
        Route::get('edit/driver/page/{id}',[DriverController::class,'edit_driver_page'])->name('edit_driver_page');
        Route::put('update/driver',[DriverController::class,'update'])->name('update.driver');
        Route::post('delete/driver',[DriverController::class,'delete'])->name('delete.driver');
        Route::get('show/driver/{id}',[DriverController::class,'show_driver'])->name('show_driver');

        Route::post('upload/file/driver', [DriverController::class,'Upload_driver_attachment'])->name('Upload_driver_attachment');
        Route::get('download/file/driver/{id}',[DriverController::class,'downloadFile_driver']);
        Route::get('soft/delete/file/driver',[DriverController::class,'soft_delete_driver_attachment'])->name('soft_delete_driver_attachment');
        Route::get('force/delete/file/driver',[DriverController::class,'force_delete_driver_attachment'])->name('force_delete_driver_attachment');
    });


// ====================== user (client) ======================
    Route::group(['middleware'=>'auth:admin'], function () {
        Route::get('get/all/users',[UserController::class,'getAllUsers'])->name('getAllUsers');
        Route::post('create/user',[UserController::class,'create'])->name('create.user');
        Route::put('update/user',[UserController::class,'update'])->name('update.user');
        Route::post('delete/user',[UserController::class,'delete'])->name('delete.user');
    });





    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('countries','CountryController')->except('show','edit','create');

    Route::resource('states','StateController')->except('show','edit','create');

    Route::resource('busModels','BusModelController')->except('show','edit','create');

    Route::resource('banks','BankController')->except('show','edit','create');

    Route::resource('licences','LicenceController')->except('show','edit','create');

    Route::resource('employeeSituations','EmployeeSituationController')->except('show','edit','create');

    Route::resource('busOwners','BusOwnerController')->except('show','edit','create');

    Route::resource('insuranceCompanies','InsuranceCompanyController')->except('show','edit','create');

    Route::resource('cities','CityController');

    Route::resource('stations','StationController')->except('create','edit','show');

    Route::resource('offices','OfficeController');

    Route::resource('busTypes','BusTypeController')->except('create','edit','show');
    Route::get('show/busType/seats/{id}',[BusTypeController::class,'showBusTypeSeats'])->name('show.busType.seats');

    Route::resource('buses','BusController');
    Route::post('upload/file/bus', [BusController::class,'Upload_bus_attachment'])->name('Upload_bus_attachment');
    Route::get('download/file/bus/{id}',[BusController::class,'downloadFile']);
    Route::get('soft/delete/file/bus',[BusController::class,'soft_delete_bus_attachment'])->name('soft_delete_bus_attachment');
    Route::get('force/delete/file/bus',[BusController::class,'force_delete_bus_attachment'])->name('force_delete_bus_attachment');
    Route::get('show/bus/seats/{id}',[BusController::class,'showBusSeats'])->name('show.bus.seats');

    Route::resource('seats','SeatController')->except('update','edit');
    Route::post('update/seats',[SeatController::class,'update'])->name('update.seats');

    Route::resource('tripData','TripDataController')->except('create','edit','show');
    Route::post('tripPaymentMethods_update',[TripDataController::class,'update_paymentMethods'])->name('update_paymentMethods');

    // stations of trip
    Route::get('stations/of/trip/{id}',[TripStationController::class,'getStationsOfTrip'])->name('getStationsOfTrip');
    Route::resource('tripStations','TripStationController')->only('store','update','destroy');

    // Lines of trip
    Route::post('create/lines/of/trip',[LineController::class,'createLinesOfTrip'])->name('createLinesOfTrip');
    Route::get('get/undegreeded/lines/of/trip/{tripData_id}',[LineController::class,'getUndegreededLinesOfTrip'])->name('getUndegreededLines');
    Route::post('add/degrees/to/lines',[LineController::class,'addDegreesToLines'])->name('add.degrees.to.lines');
    Route::get('get/all/lines/of/trip/{tripData_id}',[LineController::class,'getAllLinesOfTrip'])->name('getAllLinesOfTrip');
    Route::post('update/lines',[LineController::class,'updateLines'])->name('updateLines');


    Route::resource('degrees','DegreeController')->except('create','edit','show');

    Route::resource('runTrips','RunTripController')->except('create','edit','show');


    // Seats design of Trip
    Route::get('show/busType/seats/of/trip/{id}',[TripSeatController::class,'showBusTypeSeatsOfTrip'])->name('showBusTypeSeatsOfTrip');
    Route::post('create/trip/seats',[TripSeatController::class,'createTripSeats'])->name('createTripSeats');
    Route::put('update/trip/seats',[TripSeatController::class,'updateTripSeats'])->name('updateTripSeats');


    Route::resource('coupons','CouponController')->except('show');
    Route::resource('couponTrips','CouponTripController')->except('create','edit','show');
    Route::resource('packages','PackageController')->except('create','edit','show');
    Route::resource('bookedPackages','BookedPackageController')->except('create','show');
    Route::resource('customerTypes','CustomerTypeController')->except('create','show','edit');
    Route::resource('millages','MillageController')->except('create','show','edit');
    Route::resource('vendors','VendorController')->except('create','show','edit');
    Route::resource('categories','CategoryController')->except('create','show','edit');
    Route::resource('issues','IssueController')->except('create','show','edit');
    Route::resource('efficiencyFuels','EfficiencyFuelController')->except('create','show','edit');
    Route::resource('manuallyFuels','ManuallyFuelController')->except('create','show','edit');
    Route::resource('employeeJobs','EmployeeJobController')->except('create','show','edit');
    Route::resource('departments','DepartmentController')->except('create','show','edit');
    Route::resource('settings','SettingsController')->except('create','show','edit');
    Route::resource('paymentMethods','PaymentMethodController')->except('create','show','edit');
    Route::resource('shippings','ShippingController')->except('show','edit','index');
    Route::get('shippings/edit/{shipping_id}/{tripData_id}',[ShippingController::class,'edit'])->name('shippings.edit');
    Route::get('shippings/createNewUser',[ShippingController::class,'createNewUser'])->name('shippings.createNewUser');
    Route::resource('myEmployees','MyEmployeeController')->except('show');
    Route::resource('reservationBookingRequests','ReservationBookingRequestController')->except('show','edit','update');
    Route::get('reservationBookingRequests/edit/page',[ReservationBookingRequestController::class,'editPage'])->name('reservationBookingRequests.editPage');
    Route::get('reservationBookingRequests/change/seats',[ReservationBookingRequestController::class,'changeSeats'])->name('reservationBookingRequests.changeSeats');
    Route::get('reservationBookingRequests/searchLines',[ReservationBookingRequestController::class,'searchLines'])->name('reservationBookingRequests.searchLines');
    Route::get('reservationBookingRequests/ticket_road',[ReservationBookingRequestController::class,'ticket_road'])->name('reservationBookingRequests.ticket_road');
    Route::get('reservationBookingRequests/bookingPage',[ReservationBookingRequestController::class,'bookingPage'])->name('reservationBookingRequests.bookingPage');
//    Route::get('reservationBookingRequests/print_tabloh_page',[ReservationBookingRequestController::class,'print_tabloh_page'])->name('reservationBookingRequests.print_tabloh_page');
    Route::get('reservationBookingRequests/print_tabloh',[ReservationBookingRequestController::class,'print_tabloh'])->name('reservationBookingRequests.print_tabloh');
    Route::get('reservationBookingRequests/print_noulon',[ReservationBookingRequestController::class,'print_noulon'])->name('reservationBookingRequests.print_noulon');
    Route::get('reservationBookingRequests/search/tickets/instead/of/missed',[ReservationBookingContinueController::class,'search_tickets_instead'])->name('reservationBookingRequests.search_tickets_instead');
    Route::get('reservationBookingRequests/print/ticket/instead/of/missed',[ReservationBookingContinueController::class,'print_ticket_instead'])->name('reservationBookingRequests.print_ticket_instead');
    Route::get('reservationBookingRequests/searchUserPhone',[ReservationBookingRequestController::class,'searchUserPhone'])->name('reservationBookingRequests.searchUserPhone');
    Route::get('reservationBookingRequests/createNewUser',[ReservationBookingRequestController::class,'createNewUser'])->name('reservationBookingRequests.createNewUser');
    Route::post('reservationBookingRequests/save_data',[ReservationBookingRequestController::class,'saveData'])->name('reservationBookingRequests.saveData');
    Route::get('reservationBookingRequests/calc_booking',[ReservationBookingRequestController::class,'calc_booking'])->name('reservationBookingRequests.calc_booking');
    Route::get('reservationBookingRequests/ticket_back/{ticket_id?}',[ReservationBookingRequestController::class,'ticket_back'])->name('reservationBookingRequests.ticket_back');
    Route::get('reservationBookingRequests/ticket_back/choose/seats',[ReservationBookingRequestController::class,'chooseSeats_ticketBack'])->name('reservationBookingRequests.chooseSeats_ticketBack');
    Route::post('reservationBookingRequests/calc/ticket/back',[ReservationBookingRequestController::class,'calc_ticket_back'])->name('reservationBookingRequests.calc_ticket_back');
    Route::post('reservationBookingRequests/save/ticket/back',[ReservationBookingRequestController::class,'save_ticket_back'])->name('reservationBookingRequests.save_ticket_back');
    Route::post('reservationBookingRequests/save/ticket/road',[ReservationBookingRequestController::class,'save_ticket_road'])->name('reservationBookingRequests.save_ticket_road');
    Route::get('reservationBookingRequests/ticket_back/closed/choose/seats',[ReservationBookingRequestController::class,'chooseSeats_ticketBack_closed'])->name('reservationBookingRequests.chooseSeats_ticketBack_closed');
    Route::post('reservationBookingRequests/calc/ticket/back/closed',[ReservationBookingRequestController::class,'calc_ticket_back_closed'])->name('reservationBookingRequests.calc_ticket_back_closed');
    Route::post('reservationBookingRequests/save/ticket/back/closed',[ReservationBookingRequestController::class,'save_ticket_back_closed'])->name('reservationBookingRequests.save_ticket_back_closed');

    Route::post('reservationBookingRequests/new/booking/after/change/seats',[ReservationBookingRequestController::class,'newBookingAfterChangeSeats'])->name('reservationBookingRequests.newBookingAfterChangeSeats');
    Route::post('reservationBookingRequests/new/booking/after/change/seats/new/trip',[ReservationBookingRequestController::class,'newBookingAfterChangeSeatsNewTrip'])->name('reservationBookingRequests.newBookingAfterChangeSeatsNewTrip');
    Route::post('reservationBookingRequests/cancel/booking',[ReservationBookingRequestController::class,'cancelBooking'])->name('reservationBookingRequests.cancelBooking');
    Route::get('reservationBookingRequests/ticket/design/{reservationBookingRequest_id?}/{runTripBack_id?}',[ReservationBookingRequestController::class,'getTicketDesign'])->name('reservationBookingRequests.getTicketDesign');
    Route::get('get/les/money/page',[LesController::class,'getLesMoney'])->name('getLesMoney');



    // استيراد بيانات الموظفين
    Route::get('get/excel',[MyEmployeeController::class,'getExcel'])->name('getExcel.excelEmployee');
    Route::post('import/excel',[MyEmployeeController::class,'import'])->name('import.excelEmployee');

    Route::get('store/employees/data',[RouteStationController::class,'operation1'])->name('store.employees.data');
    Route::get('add/bus/to/booking/request',[RouteStationController::class,'operation2'])->name('add_bus.to.booking_request');


    // move trip seats (نقل مقاعد رحلة)
    Route::get('move/trip/seats/page',[TripSeatController::class,'move_trip_seats_page'])->name('move_trip_seats_page');
    Route::get('search/for/old/runTrip',[TripSeatController::class,'search_for_old_run_trip'])->name('search_for_old_run_trip');
    Route::get('search/for/new/runTrip',[TripSeatController::class,'search_for_new_run_trip'])->name('search_for_new_run_trip');
    Route::post('create/new/runTrip',[TripSeatController::class,'create_new_run_trip'])->name('create_new_run_trip');
    Route::get('return/page/of/move/tripSeats/{new_runTrip_id}/{old_runTrip_id}',[TripSeatController::class,'return_page_of_move_tripSeats'])->name('return_page_of_move_tripSeats');
    Route::post('make/movement/of/trip/seats',[TripSeatController::class,'make_movements_of_tripSeats'])->name('make_movements_of_tripSeats');

    /* ربط رحلات الذهاب والعودة */
    Route::get('connect/runTrips/page',[ReservationBookingContinueController::class,'get_connect_runTrip_page'])->name('get_connect_runTrip_page');
    Route::get('get/go/trips',[ReservationBookingContinueController::class,'get_go_trips'])->name('get_go_trips');
    Route::get('get/back/trips',[ReservationBookingContinueController::class,'get_back_trips'])->name('get_back_trips');
    Route::post('connect/runTrips',[ReservationBookingContinueController::class,'connect_runTrip'])->name('connect_runTrip');


    /* reports */
    Route::get('search/for/station',[BookingRequestController::class,'searchForStation'])->name('searchForStation');
    // get_search_tickets_page
    Route::get('get/search/tickets/page',[ReportController::class,'get_search_tickets_page'])->name('get_search_tickets_page');
    Route::get('search/tickets/by/date/office',[ReportController::class,'search_tickets_by_date_office'])->name('search_tickets_by_date_office');
    // get_search_les_page
    Route::get('get/search/les/page',[ReportController::class,'get_search_les_page'])->name('get_search_les_page');
    Route::get('search/les/by/date/office',[ReportController::class,'search_les_by_date_office'])->name('search_les_by_date_office');
    // get_search_all_tickets_page
    Route::get('get/search/all/tickets/page',[ReportController::class,'get_search_all_tickets_page'])->name('get_search_all_tickets_page');


}); //end of routes
