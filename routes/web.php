<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeekScheduleController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\MatchScheduleController;
use App\Http\Controllers\HistoricDataController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\WeekBetController;
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
    return view('welcome');
});

////////////////////// Match Schedule pge //////////////////////////////////////
Route::view('/matchschedule',                       'matchschedule.matchschedule') ->middleware("auth");
Route::get('/matchlist',                            [MatchScheduleController::class,'showMatchTable']);
Route::get('/eachMatch/{id}',                       [MatchScheduleController::class ,'eachMatch']);
Route::get('/odd/{id}',                             [MatchScheduleController::class ,'showOddEachMatch'] );
Route::get('/teamnews/{id}',                        [MatchScheduleController::class, 'showTeamPage']);
Route::post("/showTeamNewsDataonPage",              [MatchScheduleController::class ,'showTeamNewsDataonPage']);


////////////////////// week page ////////////////////////////////////////////////
Route::get('/weekschedule',                         [WeekScheduleController::class, 'showMatchOfWeekPage']);
Route::get("/showMatchsOfThisWeek_MO",              [WeekScheduleController::class ,"showAllMatchesOfWeek_MO"]);
Route::get("/showMatchsOfThisWeek_OU",              [WeekScheduleController::class , "showAllMatchesOfWeek_OU"]);
Route::get('/showMatchsOfThisWeek_AH',              [WeekScheduleController::class ,"showAllMatchesOfWeek_AH"]);

////////////////////// week bet pages ////////////////////////////////////////////////
Route::get('/matchodds',                            [WeekBetController::class, 'showMatchOddsSelctionPage']);
Route::get('/weekMOBet',                            [WeekBetController::class, 'weekMOBet']);
Route::get("/ahodds",                               [WeekBetController::class ,"showAHoddSelectionPage"]);
Route::get("/weekAHBet",                            [WeekBetController::class ,"weekAHBet"]);

//////////////// players data page ///////////////////////
Route::view('/players',                             'players.playerlist')  ->middleware("auth");
Route::get('/players/{league_id}/{season_id}',      [PlayersController::class, 'showplayerScoreTable']);
Route::get('/eachPlayer/{player_id}',               [PlayersController::class, 'showEachPlayer']);
Route::get('/eachPlayer/showWholeCareer/{id}',      [PlayersController::class, 'showWholeCareer' ]);
Route::get('/eachPlayer/showEachCareer/{id}',       [PlayersController::class, 'showEachCareer'] );

//////////////// Historic page ///////////////////////
Route::post('/showDynamnicRanking_MO',                [HistoricDataController::class, 'showFullRankingTable_MO']);
Route::post('/showDynamnicRanking_OU',                [HistoricDataController::class, 'showFullRankingTable_OU']);
Route::post('/showDynamnicRanking_AH',                [HistoricDataController::class, 'showFullRankingTable_AH']);
Route::view("/history",                                "history.historydata") ->middleware("auth");

//////////////// real_price page //////////////////////
Route::view("/real_price",                                "price.pricedata") ->middleware("auth");
Route::post('show_MO_price',                           [PriceController::class , 'show_MO_price']);
Route::post('show_AH_price',                           [PriceController::class, 'show_AH_price']);
Auth::routes(['register'=> false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
