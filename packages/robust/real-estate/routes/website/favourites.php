<?php
Route::group([
    'prefix' => config('real-estate.frw.website'),
    'as' => 'website.realestate.leads.',
    'group' => 'Favourites'],
    function () {
        Route::get('/leads/favourites/{id}', [
            'name' => 'Lead Favourites',
            'as' => 'favourites',
            'uses' => 'Robust\RealEstate\Controllers\Website\Leads\FavouritesController@store'
        ]);
        Route::get('/leads/map', [
            'name' => 'Listings on Map',
            'as' => 'map',
            'uses' => 'Robust\RealEstate\Controllers\Website\Leads\FavouritesController@showListingsOnMap'
        ]);
    });
