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

// chart dashboard nasional
Route::get('member/rergister/national','API\DashboardController@getMemberNational');
Route::get('member/totalnational','API\DashboardController@getTotalMemberNational');
Route::get('membervsterget/national','API\DashboardController@getMemberVsTargetNational');
Route::get('member/gender/national','API\DashboardController@getGenderNational');
Route::get('member/jobs/national','API\DashboardController@getJobsNational');
Route::get('member/agegroup/national','API\DashboardController@getAgeGroupNational');
Route::get('member/genage/national','API\DashboardController@genAgeNational');
Route::get('member/inputer/national','API\DashboardController@getInputerNational');
Route::get('member/referal/national','API\DashboardController@getRegefalNational');

// chart dashboard province
Route::get('member/totalprovince/{province_id}','API\DashboardController@getTotalMemberProvince');
Route::get('member/rergister/province/{province_id}','API\DashboardController@getMemberProvince');
Route::get('membervsterget/province/{province_id}','API\DashboardController@getMemberVsTargetProvince');
Route::get('member/gender/province/{province_id}','API\DashboardController@getGenderProvince');
Route::get('member/jobs/province/{province_id}','API\DashboardController@getJobsProvince');
Route::get('member/agegroup/province/{province_id}','API\DashboardController@getAgeGroupProvince');
Route::get('member/genage/province/{province_id}','API\DashboardController@genAgeProvince');
Route::get('member/inputer/province/{province_id}','API\DashboardController@getInputerProvince');
Route::get('member/referal/province/{province_id}','API\DashboardController@getRegefalProvince');

// chart dashboard regency
Route::get('member/rergister/regency/{regency_id}','API\DashboardController@getMemberRegency');
Route::get('member/totalregency/{regency_id}','API\DashboardController@getTotalMemberRegency');
Route::get('membervsterget/regency/{regency_id}','API\DashboardController@getMemberVsTargetRegency');
Route::get('member/gender/regency/{regency_id}','API\DashboardController@getGenderRegency');
Route::get('member/jobs/regency/{regency_id}','API\DashboardController@getJobsRegency');
Route::get('member/agegroup/regency/{regency_id}','API\DashboardController@getAgeGroupRegency');
Route::get('member/genage/regency/{regency_id}','API\DashboardController@genAgeRegency');
Route::get('member/inputer/regency/{regency_id}','API\DashboardController@getInputerRegency');
Route::get('member/referal/regency/{regency_id}','API\DashboardController@getRegefalRegency');

// chart dashboard district
Route::get('member/totaldistrict/{district_id}','API\DashboardController@getTotalMemberDistrict');
Route::get('member/rergister/district/{district_id}','API\DashboardController@getMemberDistrict');
Route::get('membervsterget/district/{district_id}','API\DashboardController@getMemberVsTargetDistrict');
Route::get('member/gender/district/{district_id}','API\DashboardController@getGenderDistrict');
Route::get('member/jobs/district/{district_id}','API\DashboardController@getJobsDistrict');
Route::get('member/agegroup/district/{district_id}','API\DashboardController@getAgeGroupDistrict');
Route::get('member/genage/district/{district_id}','API\DashboardController@genAgeDistrtict');
Route::get('member/inputer/district/{district_id}','API\DashboardController@getInputerDistrict');
Route::get('member/referal/district/{district_id}','API\DashboardController@getRegefalDistrict');

// chart dashboard district
Route::get('member/totalvillage/{district_id}/{village_id}','API\DashboardController@getTotalMemberVillage');
Route::get('member/gender/village/{village_id}','API\DashboardController@getGenderVillage');
Route::get('member/jobs/village/{village_id}','API\DashboardController@getJobsVillage');
Route::get('member/agegroup/village/{village_id}','API\DashboardController@getAgeGroupVillage');
Route::get('member/genage/village/{village_id}','API\DashboardController@genAgeVillage');
Route::get('member/inputer/village/{village_id}','API\DashboardController@getInputerVillage');
Route::get('member/referal/village/{village_id}','API\DashboardController@getRegefalVillage');
