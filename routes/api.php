<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;
use App\Models\User;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // add unread messages count to user object
    $user = $request->user();
    $user->unreadMsgCount = $user->totalUnreadMessages();

    return $user;
});

Route::get('/notify', function () {
  broadcast(new \App\Events\UserNotification(\App\Models\User::find(5)));
});

Route::post('/register', [ 'as' => 'register', 'uses' => 'RegisterController@register']);
Route::post('password/email', 'ForgotPasswordController@forgot')->name('password.forgot');
Route::post('password/reset', 'ForgotPasswordController@reset')->name('password.reset');
Route::get('login/{provider}', 'LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback');
Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@login']);
Route::post('logout', [ 'as' => 'logout', 'uses' => 'LoginController@logout']);
Route::post('password/change', 'ProfileController@changePassword');
Route::post('profile/update', 'ProfileController@changeProfile');
//Cashier Routes
Route::get('get-plans', 'StripeController@getPlans');
Route::get('get-current-subscription', 'StripeController@getCurrentSubscription')->middleware(['auth:sanctum']);
Route::get('get-intent', 'StripeController@getIntent')->middleware(['auth:sanctum']);
Route::post('subscribe', 'StripeController@subscribe')->middleware(['auth:sanctum']);
Route::post('unsubscribe', 'StripeController@unsubscribe')->middleware(['auth:sanctum']);
Route::post('webhook', 'StripeController@webhook')->middleware([VerifyWebhookSignature::class]);
// Roles and Permissions
Route::resource('roles', 'RoleController')->middleware(['auth:sanctum']);
Route::get('getrolepermission/{id}', 'RoleController@getRolePermission')->middleware(['auth:sanctum']);

// Wikitree

Route::get('wikitree/get-authcode', 'WikitreeController@getAuthCode');
Route::get('wikitree/clientLoginResponse', 'WikitreeController@getAuthCodeCallBack');
Route::get('wikitree/search-person', 'WikitreeController@searchPerson');

// OpenArch
Route::prefix('open-arch')->group(function () {
    Route::get('/search-person', 'OpenArchController@searchPerson');
});


Route::get('getroles', 'RoleController@getRole')->middleware(['auth:sanctum']);
Route::get('permissions', 'PermissionController@index')->middleware(['auth:sanctum']);
Route::get('getpermissions', 'PermissionController@getPermission')->middleware(['auth:sanctum']);
Route::get('/email-verification',  'VerificationController@verify')->name('verification.verify');
Route::post('/email/verification-notification', 'VerificationController@resendVerificatonEmail')->name('verification.send');
Route::middleware('tenant')->group(function () {
    Route::resource('addr', 'AddrController');
    Route::resource('author', 'AuthorController');
    Route::resource('chan', 'ChanController');
    Route::resource('citation', 'CitationController');
    Route::resource('dashboard', 'DashboardController');
    Route::get('trial', 'DashboardController@trial');
    Route::get('get_companies', 'DashboardController@getCompany');
    Route::get('get_tree', 'DashboardController@getTree');
    Route::post('changedb', 'DashboardController@changedb');
    Route::resource('event', 'EventController');
    Route::resource('family', 'FamilyController');
    Route::resource('familyevent', 'FamilyEventController');
    Route::resource('familyslgs', 'FamilySlgsController');
    Route::resource('gedcom', 'GedcomController');
    Route::post('gedcom-export', 'GedcomController@gedcomExport');
//    Route::get('gedcom-download', 'GedcomController@gedcomDownload');
    Route::post('check-gedcom-export', 'GedcomController@checkGedcomExport');
    Route::resource('mediaobject', 'MediaObjectController');
    Route::resource('mediaobjectfile', 'MediaObjectFileController');
    Route::resource('note', 'NoteController');
    Route::resource('pedigree', 'PedigreeController');
    Route::resource('person', 'PersonController');
    Route::resource('personalia', 'PersonAliaController');
    Route::resource('personanci', 'PersonAnciController');
    Route::resource('personasso', 'PersonAssoController');
    Route::resource('persondesi', 'PersonDesiController');
    Route::resource('personevent', 'PersonEventController');
    Route::resource('personlds', 'PersonLdsController');
    Route::resource('personname', 'PersonNameController');
    Route::resource('personnamefone', 'PersonNameFoneController');
    Route::resource('personnameromn', 'PersonNameRomnController');
    Route::resource('personsubm', 'PersonSubmController');
    Route::resource('place', 'PlaceController');
    Route::resource('publication', 'PublicationController');
    Route::resource('refn', 'RefnController');
    Route::resource('repository', 'RepositoryController');
    Route::resource('source', 'SourceController');
    Route::resource('sourcedata', 'SourceDataController');
    Route::resource('sourcedataeven', 'SourceDataEvenController');
    Route::resource('sourceref', 'SourceRefController');
    Route::resource('sourcerefeven', 'SourceRefEvenController');
    Route::resource('sourcerepo', 'SourceRepoController');
    Route::resource('subm', 'SubmController');
    Route::resource('subn', 'SubnController');
    Route::resource('dnaupload', 'DnaController');
    Route::resource('dnamatching', 'DnaMatchingController');
    Route::resource('company', 'CompanyController');
    Route::resource('tree', 'TreeController');
    Route::resource('chats', 'ChatController');
    Route::resource('chatmessages', 'ChatMessageController');
    Route::resource('forumcategory', 'ForumCategoryController');
    Route::resource('forumtopic', 'ForumTopicController');
    Route::resource('forumpost', 'ForumPostController');
    Route::resource('calendar_event', 'CalendarEventController');
    Route::get('allfamily', 'FamilyEventController@get');
    Route::get('allplaces', 'PlaceController@get');
    Route::get('addrname', 'AddrController@get');
    Route::get('allrepository', 'RepositoryController@get');
    Route::get('allauthor', 'AuthorController@get');
    Route::get('alltype', 'SourceController@get');
    Route::get('allpublication', 'SourceController@getdata');
    Route::get('/scraper/openArch', 'ScrapingController@scrapOpenArch');
    //search chat user
    Route::get('/chat/user/search', 'ChatController@searchUser');  
    Route::get('/chats/{id}/messages', 'ChatController@chatMessages');  
});
