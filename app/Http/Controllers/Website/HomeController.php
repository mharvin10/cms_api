<?php

namespace App\Http\Controllers\Website;

use App\Http\Resources\carousel_images\CarouselImagesPublicBasicResource;
use App\Http\Resources\news\NewsPublicBasicResource;
use App\Http\Resources\announcements\AnnouncementPublicBasicResource;
use App\Http\Resources\calendar_dates\CalendarDateAdminBasicResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function carousel()
    {
    	$carouselImages = \App\CarouselImage::where('hidden', 0)
            ->orderBy('disposition', 'asc')
            ->get();

    	return CarouselImagesPublicBasicResource::collection($carouselImages);
    }

    public function news()
    {
    	$news = \App\News::where('hidden', 0)
    		->orderBy('posted_at', 'desc')
    		->take(6)
    		->get();

    	return NewsPublicBasicResource::collection($news);
    }

    public function announcements()
    {
        $announcement = \App\Announcement::where('hidden', 0)
            ->orderBy('posted_at', 'desc')
            ->take(6)
            ->get();

        return AnnouncementPublicBasicResource::collection($announcement);
    }

    public function monthHolidaysAndEvents($month)
    {
        $calendarDates = \App\CalendarDate::where('calendar_date', 'like', $month . '%')
            ->orderBy('calendar_date')
            ->get();

        return CalendarDateAdminBasicResource::collection($calendarDates);
    }
}
