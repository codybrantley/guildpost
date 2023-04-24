<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TreasuryController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\AdminController;

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

// Auth Pages
Auth::routes();

// Home Page
Route::get('/', function () {
    return view('welcome');
});

// Guild Selection
Route::get('/home', [Controller::class, 'index'])->name('home');

// Guild Pages
Route::group(['prefix' => '{name}'], function() {
    Route::get('/{news?}', array('as' => 'news', 'uses' => [PageController::class, 'news'], 'name' => 'news.index'))->where('news', 'news');
    Route::resource('/pages', PageController::class)->names(['index' => 'pages.articles']);
    Route::resource('/events', EventController::class);
    Route::get('/events/{month}/{year}', [EventController::class, 'index'])->name('events.next');
    Route::get('/treasury', [TreasuryController::class, 'index'])->name('treasury.index');
    Route::get('/treasury/contributors', [TreasuryController::class, 'contributors'])->name('treasury.contributors');
	Route::get('/treasury/contributors/{id}', [TreasuryController::class, 'contributor'])->name('treasury.contributor');
	Route::get('/lottery', [LotteryController::class, 'index'])->name('lottery.index');
    Route::get('/lottery/settings', [LotteryController::class, 'settings'])->name('lottery.settings');
    Route::resource('/admin', AdminController::class);
});

// Error Pages
Route::get("/guild/notfound", function() { return view("error.notfound"); })->name('error.notfound');
Route::get("/guild/{name}", function() { return view("error.notregistered"); })->name('error.notregistered');

// Cache Process
Route::prefix('cache')->group(function () {
	Route::get('/upgrades', function() {
		$client = new \GuzzleHttp\Client(['base_uri' => 'https://api.guildwars2.com/v2/']);

		// Get list of upgrades
		$request = $client->request('GET', 'guild/upgrades');
		$contents = json_decode($request->getBody(), true);

		// Split ids in chunks
		$ucA = array_chunk($contents, 199);
		$ucS = [];
		foreach($ucA as $c) {
			$s = "";
			foreach($c as $i) {
				$s .= $i . ',';
			}
			array_push($ucS, $s);
		}

		// Make requests for each chunk
		$urA = [];
		foreach($ucS as $a) {
			$r = $client->request('GET', 'guild/upgrades?ids=' . $a);
			$c = json_decode($r->getBody(), true);
			array_push($urA, $c);
		}

		// Merge all data in one array
		$udA = array_merge(...$urA);

		// Get item ids from each upgrade
		$iD = [];
		foreach($udA as $u) {
			foreach($u['costs'] as $cO) {
				if(isset($cO['item_id'])) {
					array_push($iD, $cO['item_id']);
				}
			}
		}

		// Split ids in chunks
		$icA = array_chunk($iD, 199);
		$icS = [];
		foreach($icA as $c) {
			$s = "";
			foreach($c as $i) {
				$s .= $i . ',';
			}
			array_push($icS, $s);
		}

		// Make requests for each chunk
		$irA = [];
		foreach($icS as $a) {
			$r = $client->request('GET', 'items?ids=' . $a);
			$c = json_decode($r->getBody(), true);
			array_push($irA, $c);
		}

		// Merge all data in one array
		$idA = array_merge(...$irA);

		// Encode data
		$udJ = json_encode($udA);
		$idJ = json_encode($idA);

		// Store data
		$uP = Storage::put('upgrades.cache', $udJ);
		$iP = Storage::put('items.cache', $idJ);
	});
});
