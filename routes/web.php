<?php

use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    return view('auth.login');
});


Route::group(['prefix' => 'user','middleware' => ['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');

    // verification email
    Route::get('verifymail/{activate_token}','UserController@verificationEmail')->name('verify-email');

    Route::get('/profile', 'UserController@index')->name('user-profile');
    Route::get('/profile/edit/{id}', 'UserController@edit')->name('user-profile-edit');
    Route::get('/profile/editreferal/{id}', 'UserController@editReferal')->name('user-profile-edit-referal');
    Route::post('/profile/update/{id}', 'UserController@update')->name('user-profile-update');
    Route::post('/profile/update/referal/{id}', 'UserController@updateReferalMember')->name('user-profile-update-referal');
    Route::post('/profile/update/myprofile/{id}', 'UserController@updateMyProfile')->name('user-myprofile-update');

    Route::get('/profile/create', 'UserController@create')->name('user-create-profile');
    Route::get('/profile/reveral', 'UserController@createReveral')->name('user-create-reveral');
    Route::post('/profile/reveral/store/{id}', 'UserController@storeReveral')->name('user-store-reveral');

    Route::get('/member/download','UserController@memberReportPdf')->name('user-member-downloadpdf');
    Route::get('/dashboarddistrict','HomeController@dashboardAdminDistrict')->name('member-dashboard');

    Route::group(['prefix' => 'member'], function(){
        Route::get('index','UserController@indexMember')->name('member-index');
        Route::get('create','UserController@createNewMember')->name('member-create');
        Route::post('/profile/store', 'UserController@store')->name('user-store-profile');
        Route::get('show/mymember/{id}','UserController@profileMyMember')->name('member-mymember');
        Route::get('member/card/download/{id}','UserController@downloadCard')->name('member-card-download');

        Route::get('/referal/undirect','UserController@memberByUnDirectReferal')->name('member-undirect-referal');
        Route::get('/referal/direct','UserController@memberByDirectReferal')->name('member-direct-referal');
        Route::get('/all/member/{district_id}','UserController@memberByAdminDistrict')->name('all-member-byadmin');

        Route::get('/registered/{id}','UserController@registeredNasdem');
        Route::get('/saved/{id}','UserController@savedNasdem');

        Route::get('/event','EventController@index')->name('member-event');
        Route::get('/event/absen/{event_detail_id}','EventController@storeAbsen')->name('member-event-absen');
        
        Route::get('/registered','UserController@memberRegister')->name('member-registered-user');
        

    });


});

Route::group(['prefix' => 'admin','namespace' => 'Admin'], function(){
    Route::get('/auth','LoginController@loginForm')->name('admin-login');
    Route::post('/login','LoginController@login')->name('post-admin-login');

    Route::group(['middleware' => 'admin'], function(){
        Route::post('logout','LoginController@logout')->name('admin-logout');
        Route::get('/dashboard/nation','DashboardController@index')->name('admin-dashboard');
        Route::get('/dashboard/province/{province_id}','DashboardController@province')->name('admin-dashboard-province');
        Route::get('/dashboard/regency/{regency_id}','DashboardController@regency')->name('admin-dashboard-regency');
        Route::get('/dashboard/regency/district/{district_id}','DashboardController@district')->name('admin-dashboard-district');
        Route::get('/dashboard/regency/district/village/{district_id}/{village_id}','DashboardController@village')->name('admin-dashboard-village');

        Route::get('/member','MemberController@index')->name('admin-member');
        Route::get('/member/create','MemberController@create')->name('admin-member-create');
        Route::get('/member/create/account/{id}','MemberController@createAccount')->name('admin-member-create-account');
        Route::post('/member/create/account/store/{id}','MemberController@storeAccount')->name('admin-member-create-account-store');
        Route::post('/member/store','MemberController@store')->name('admin-member-store');

        Route::get('/member/profile/{id}','MemberController@profileMember')->name('admin-profile-member');
        Route::get('/member/profile/edit/{id}','MemberController@editMember')->name('admin-profile-member-edit');
        Route::post('/member/profile/update/{id}','MemberController@updateMember')->name('admin-profile-member-update');

        Route::get('/member/card/download/{id}','MemberController@downloadCard')->name('admin-member-card-download');

        // Admin District
        Route::get('/admincontrol/district','AdminDistrictController@index')->name('admin-admincontroll-district');
        Route::get('/admincontrol/district/createadmin','AdminDistrictController@create')->name('admin-admincontroll-district-create');
        Route::get('/admincontrol/createadmin/district/save/{id}','AdminDistrictController@saveAdminDistrict')->name('admin-admincontroll-district-save');

        // Event
        Route::get('/event','EventController@index')->name('admin-event');
        Route::get('/event/create','EventController@create')->name('admin-event-create');
        Route::post('/event/store','EventController@store')->name('admin-event-store');
        Route::get('/event/add/member/{id}','EventController@addMemberEvent')->name('admin-event-addmember');
        Route::post('/event/add/member/store','EventController@storeAddMemberEvent')->name('admin-event-addmember-store');
        Route::get('/event/detail/{id}','EventController@evenDetials')->name('admin-event-addmember-detail');
        
        // Gallery Event
        Route::get('/event/gallery/{id}','EventGalleryController@index')->name('admin-event-gallery');
        Route::post('/event/gallery/store/{id}','EventGalleryController@store')->name('admin-event-gallery-store');
        Route::get('/event/gallery/detail/{id}','EventGalleryController@detailEventGallery');

         // report excel
        Route::get('/member/national/export','DashboardController@exportDataNationalExcel')->name('report-member-national-excel');
        Route::get('/member/province/export/{province_id}','DashboardController@exportDataProvinceExcel')->name('report-member-province-excel');
        Route::get('/member/regency/export/{regency_id}','DashboardController@exportDataRegencyExcel')->name('report-member-regency-excel');
        Route::get('/member/district/export/{district_id}','DashboardController@exportDataDistrictExcel')->name('report-member-district-excel');
        Route::get('/member/village/export/{village_id}','DashboardController@exportDataVillageExcel')->name('report-member-village-excel');

        // report profesi nasional
        Route::get('/member/jobs/national','DashboardController@exportJobsNationalExcel')->name('report-jobnational-excel');
        // report profesi province
        Route::get('/member/jobs/province/{province_id}','DashboardController@exportJobsProvinceExcel')->name('report-jobprovince-excel');
        // report profesi regency
        Route::get('/member/jobs/regency/{regency_id}','DashboardController@exportJobsRegencyExcel')->name('report-jobregency-excel');
        // report profesi district
        Route::get('/member/jobs/district/{district_id}','DashboardController@exportJobsDistrictExcel')->name('report-jobdistrict-excel');


    });
});

Auth::routes();


