<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Spatie\Analytics\Period;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function totalHitsOverview()
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

    public function weeklyHitsLineChart(Request $request)
    {
		$startDate = Carbon::now()->subDays(6);
		$endDate = Carbon::now();

		$ga = \Analytics::performQuery(
			Period::create($startDate, $endDate),
		    'ga:sessions',
		    [
		        'metrics' => 'ga:users, ga:sessions, ga:pageviews',
		        'dimensions' => 'ga:date'
		    ]
		);

		$ga = collect($ga['rows']);

		return [
			'date' => $ga->map(function ($item, $key) {
			    return Carbon::parse($item[0])->format('M j, Y');
			}),
			'users' => $ga->map(function ($item, $key) {
			    return $item[1];
			}),
			'sessions' => $ga->map(function ($item, $key) {
			    return $item[2];
			}),
			'pageViews' => $ga->map(function ($item, $key) {
			    return $item[3];
			})
		];
    }

    public function topCitiesBarChart(Request $request, $count = 5)
    {
		$startDate = Carbon::create(2018, 1, 1);
		$endDate = Carbon::now();

		$ga = \Analytics::performQuery(
			Period::create($startDate, $endDate),
		    'ga:sessions',
		    [
		        // 'metrics' => 'ga:sessions, ga:pageviews',
		        'dimensions' => 'ga:city'
		    ]
		);

		$ga = collect($ga['rows'])->map(function ($item, $key) {
			    return [
			    	'city' => $item[0],
			    	'sessions' => $item[1]
			    ];
			})
			->sortByDesc('sessions')
			->values()
			->take($count);

		$cities = $ga->map(function ($item, $key) {
			    return $item['city'];
			});

		$sessions = $ga->map(function ($item, $key) {
			    return $item['sessions'];
			});

		return [
			'cities' => $cities,
			'sessions' => $sessions
		];
    }
}
