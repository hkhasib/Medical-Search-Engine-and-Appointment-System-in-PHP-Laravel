<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\dashboard\ClinicController;
use App\Http\Controllers\dashboard\dashboardController;
use App\Http\Controllers\dashboard\EmployeeController;
use App\Http\Controllers\dashboard\locationController;
use App\Http\Controllers\dashboard\RoutineController;
use App\Http\Controllers\dashboard\userController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

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


Route::get('/',[FrontController::class,'index'])->name('home');
//Route::get('/search',[FrontController::class,'searchIndex'])->name('search.index');

Route::get('/search',[SearchController::class,'search'])->name('search.action');

Route::get('doctor/{id}',[FrontController::class,'doctorProfile']);
Route::get('/login',[AuthController::class,'index'])->name('auth.login');
Route::get('/register',[AuthController::class,'registration'])->name('auth.register');
Route::post('/login-action',[AuthController::class,'verifyLogin'])->name('auth.verify');
Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');

Route::get('/get-time/{clinic_id}/{doctor_id}/{date}',[FrontController::class,'getTimes']);
Route::get('/get-routine/{clinic_id}/{doctor_id}',[FrontController::class,'getRoutines']);

Route::get('/register-user-info',[AuthController::class,'completeUserInfo'])->name('auth.user-info');
Route::post('/store-registration',[AuthController::class,'registrationAction'])->name('store.registration');
Route::post('/complete-registration',[AuthController::class,'completeRegistration'])->name('store.complete.registration');

Route::get('/reset',[AuthController::class,'reset'])->name('auth.reset');
Route::post('/request-reset',[\App\Http\Controllers\MailController::class,'passwordResetMail'])->name('auth.request.reset');
Route::get('/reset-password',[AuthController::class,'resetPassword']);
Route::post('/store-reset-password',[AuthController::class,'storeResetPassword'])->name('auth.store.reset');
Route::get('/get-states/{country_id}',[LocationController::class,'getStates'])->name('get.states.secret');
Route::get('/get-cities/{state_id}',[LocationController::class,'getCities'])->name('get.cities.secret');
Route::group(['middleware'=>['verifyUserAccess']],function (){

    Route::get('/get-zones/{city_id}',[LocationController::class,'getZones'])->name('get.zones.secret');
    Route::get('/get-area-list/{zone_id}',[LocationController::class,'getLocalArea'])->name('get.area-list.secret');

    Route::get('/get-department-list/{clinic_id}',[ClinicController::class,'getDepartments'])->name('get.clinic-list.secret');

    Route::group(['middleware'=>['verifyUserLogin']],function (){

        Route::get('/profile-settings-edit',[UserController::class,'editUserSelf'])->name('profile.settings');
        Route::get('/change-password',[UserController::class,'passwordChanger'])->name('password.changer');
        Route::post('/store-password-change',[UserController::class,'storePasswordChange'])->name('store.password.change');
        Route::get('/custom-appointment-list',[AppointmentController::class,'customList'])->name('appointments.custom.list');
        Route::post('get-custom-appointment-data',[AppointmentController::class,'getCustomAppointments'])->name('appointments.custom');

        Route::get('/billing-list',[BillingController::class,'viewBills'])->name('billing.list');

        Route::get('/all-appointments',[AppointmentController::class,'index'])->name('appointments');

        Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

        Route::post('/store-appointment',[AppointmentController::class,'store'])->name('store.appointment');

        Route::get('/update-appointment/{id}',[AppointmentController::class,'edit']);

        Route::post('/store-appointment-update',[AppointmentController::class,'update'])->name('store.appointment.update');

        Route::get('/prescription-list',[PrescriptionController::class,'index'])->name('prescription.list');

        Route::get('/view-invoice/{id}',[BillingController::class,'viewInvoice']);

        Route::get('view-prescription/{id}',[PrescriptionController::class,'viewPrescription']);

        Route::group(['middleware'=>['verifyFrontDesk']],function (){
            Route::get('/prescriptions-billing',[PrescriptionController::class,'prescriptionListBilling'])->name('billing.prescriptions');
            Route::post('/complete-payment',[BillingController::class,'completePayment'])->name('complete.payment');
        });



        Route::get('/create-bill/{prescription_id}/{appointment_id}/{user_id}/{doctor_id}',[BillingController::class,'createBill']);

        Route::post('/store-invoice',[BillingController::class,'store'])->name('store.invoice');

        Route::group(['middleware'=>['verifyDoctor']],function (){
            Route::get('/create-prescription',[PrescriptionController::class,'editor']);
            Route::post('/store-prescription',[PrescriptionController::class,'store'])->name('store.prescription');
            Route::get('/routine-editor',[RoutineController::class,'addRoutine'])->name('routine.editor');
            Route::post('store-routine',[RoutineController::class,'storeRoutine'])->name('store.routine');
        });

        Route::group(['middleware'=>['verifyBusiness']],function (){
            Route::get('/view-employees',[EmployeeController::class,'employeeList'])->name('employee.list');
            Route::get('/edit-employee/{employee_id}',[EmployeeController::class,'editEmployee'])->name('edit.employee');

            Route::post('/store-employee-edit',[EmployeeController::class,'storeEditEmployee'])->name('store.edit.employee');

            Route::get('/add-users',[UserController::class,'addUser'])->name('user.new');
            Route::post('/store-user',[UserController::class,'storeUser'])->name('store.user');
            Route::get('/view-users',[UserController::class,'index'])->name('user.view');
            Route::get('/edit-user/{id}',[UserController::class,'editUserView'])->name('edit.user.view');
            Route::post('/store-user-edit',[UserController::class,'editUser'])->name('store.user.edit');

            Route::get('/add-clinic',[ClinicController::class,'addClinic'])->name('clinic.new');
            Route::get('/view-clinic',[ClinicController::class,'index'])->name('clinic.view');
            Route::post('/store-clinic',[ClinicController::class,'storeClinic'])->name('store.clinic');

            Route::get('/add-department',[ClinicController::class,'addDepartment'])->name('clinic.department');
            Route::post('/store-department',[ClinicController::class,'storeDepartment'])->name('store.department');

            Route::get('/add-people',[EmployeeController::class,'addPeople'])->name('clinic.add.people');
            Route::post('/store-employee',[EmployeeController::class,'storeEmployee'])->name('store.employee');

            Route::group(['middleware'=>['verifyAdmin']],function (){

                Route::get('/locations',[LocationController::class,'index'])->name('location.view');
                Route::get('/countries',[LocationController::class,'addCountry'])->name('location.country');
                Route::get('/states',[LocationController::class,'addState'])->name('location.state');
                Route::get('/cities',[LocationController::class,'addCity'])->name('location.city');
                Route::get('/zones',[LocationController::class,'addZone'])->name('location.zone');
                Route::get('/areas',[LocationController::class,'addArea'])->name('location.area');

                Route::post('/store-country',[LocationController::class,'storeCountry'])->name('store.location.country');
                Route::post('/store-state',[LocationController::class,'storeState'])->name('store.location.state');
                Route::post('/store-city',[LocationController::class,'storeCity'])->name('store.location.city');
                Route::post('/store-zone',[LocationController::class,'storeZone'])->name('store.location.zone');
                Route::post('/store-area',[LocationController::class,'storeArea'])->name('store.location.area');


                Route::get('/authorized-users',[UserController::class,'userAuthList'])->name('user.auth.list');
                Route::post('/store-user-authorization/{user_id}',[UserController::class,'storeUserAuthorization']);


                Route::post('/delete-user',[UserController::class,'deleteUser'])->name('delete.user');

            });
        });


    });

});




