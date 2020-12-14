<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;

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
    return $request->user();
});

Route::post('/register', 'RegisterController@register');
Route::post('password/email', 'ForgotPasswordController@forgot');
Route::post('password/reset', 'ForgotPasswordController@reset')->name('password.reset');
Route::get('login/{provider}', 'LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback');
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
Route::get('roles', 'RoleController@index')->middleware(['auth:sanctum']);
Route::get('permissions', 'PermissionController@index')->middleware(['auth:sanctum']);

Route::middleware('tenant')->group(function() {
    Route::resource('addr', 'AddrController');
	Route::resource('author', 'AuthorController');
	Route::resource('chan', 'ChanController');
	Route::resource('citation', 'CitationController');
	Route::resource('event', 'EventController');
	Route::resource('family', 'FamilyController');
	Route::resource('familyevent', 'FamilyEventController');
	Route::resource('familyslgs', 'FamilySlgsController');
	Route::resource('gedcom', 'GedcomController');
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
        Route::resource('tree', 'TreeController');
        Route::resource('chats', 'ChatController');
        Route::resource('chatmessages', 'ChatMessageController');
        Route::resource('forumcategory', 'ForumCategoryController');
        Route::resource('forumtopic', 'ForumTopicController');
        Route::resource('forumpost', 'ForumPostController');
});
