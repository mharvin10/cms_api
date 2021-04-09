<?php

namespace App\Http\Controllers\Website;

use Carbon\Carbon;
use Spatie\Analytics\Period;
use App\Http\Resources\navigations\MainMenuPublicBasicWithCollectionResource;
use App\Http\Resources\page_nodes\PageNodePublicBasicWithCollectionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function mainMenu()
    {
    	$mainMenu = \App\Navigation::where('type', 'main')
    		->where('page_node_id', '<>', NULL)
    		->where('hidden', 0)
    		->get();

    	return MainMenuPublicBasicWithCollectionResource::collection($mainMenu);
    }

    public function auxiliaryMenu()
    {
    	$mainMenu = \App\Navigation::where('type', 'main')
    		->where('page_node_id', '<>', NULL)
    		->get();

    	$auxiliaryMenu = \App\PageNode::whereNotIn('id', $mainMenu->map(function ($item, $key) {
	    		return $item->page_node_id;
	    	}))
    		->withDepth()
    		->having('depth', 1)
    		->defaultOrder()
    		->get();

    	return PageNodePublicBasicWithCollectionResource::collection($auxiliaryMenu);
    }

    public function analyticsOverview()
  	{
  		$startDate = Carbon::create(2018, 1, 1);
  		$endDate = Carbon::now();

  		$users = \Analytics::performQuery(
  			Period::create($startDate, $endDate),
  		    'ga:users'
  		)['rows'];

  		$sessions = \Analytics::performQuery(
  			Period::create($startDate, $endDate),
  		    'ga:sessions'
  		)['rows'];

  		$pageViews = \Analytics::performQuery(
  			Period::create($startDate, $endDate),
  		    'ga:pageViews'
  		)['rows'];

  		$sessionsPerUser = \Analytics::performQuery(
  			Period::create($startDate, $endDate),
  		    'ga:sessionsPerUser'
  		)['rows'];

  		$avgSessionDuration = \Analytics::performQuery(
  			Period::create($startDate, $endDate),
  		    'ga:avgSessionDuration'
  		)['rows'];

  		$pageviewsPerSession = \Analytics::performQuery(
  			Period::create($startDate, $endDate),
  		    'ga:pageviewsPerSession'
  		)['rows'];

  		return [
  			'users' => $users[0][0],
  			'sessions' => $sessions[0][0],
  			'pageViews' => $pageViews[0][0],
  			'sessionsPerUser' => number_format(round($sessionsPerUser[0][0], 3), 3),
  			'avgSessionDuration' => gmdate("H:i:s", $avgSessionDuration[0][0]),
  			'pageviewsPerSession' => number_format(round($pageviewsPerSession[0][0], 3), 3)
  		];
  	}
}
