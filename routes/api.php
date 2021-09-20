<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('jobs','Auth\RegisterController@jobs')->name('api-jobs');
Route::get('educations','Auth\RegisterController@educations')->name('api-educations');
Route::get('register/check', 'Auth\RegisterController@check')->name('api-register-check');
Route::get('provinces', 'API\LocationController@provinces')->name('api-provinces');
Route::get('regencies/{province_id}', 'API\LocationController@regencies')->name('api-regencies');
Route::get('districts/{regency_id}', 'API\LocationController@districts')->name('api-districts');
Route::get('villages/{district_id}', 'API\LocationController@villages')->name('api-villages');
Route::get('typeagricultur','API\TypeOfAgriculturController@typeofagricultur')->name('api-typeofagricultur');
Route::get('nik/check', 'Auth\RegisterController@nik')->name('api-nik-check');
Route::get('register/check', 'Auth\RegisterController@check')->name('api-register-check');
Route::get('reveral/check', 'Auth\RegisterController@reveral')->name('api-reveral-check');
Route::get('reveral/name/{code}', 'Auth\RegisterController@reveralName');

Route::get('member/nation/{daterange}','API\DashboardController@memberReportPerMountNation');
Route::get('member/province/{daterange}/{provinceID}','API\DashboardController@memberReportPerMountProvince');
Route::get('member/regency/{daterange}/{regencyID}','API\DashboardController@memberReportPerMountRegency');
Route::get('member/district/{daterange}/{districtID}','API\DashboardController@memberReportPerMountDistrict');
Route::get('member/village/{daterange}/{villageID}','API\DashboardController@memberReportPerMountVillage');

// cahrt anggota terdaftar province
Route::get('member/rergister/province','API\DashboardController@getMemberProvince');
Route::get('member/totalprovince','API\DashboardController@getTotalMemberProvince');
Route::get('membervsterget/province','API\DashboardController@getMemberVsTarget');
Route::get('member/gender/province','API\DashboardController@getGenderProvince');
Route::get('member/jobs/province','API\DashboardController@getJobsProvince');