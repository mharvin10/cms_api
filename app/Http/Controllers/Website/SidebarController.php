<?php

namespace App\Http\Controllers\Website;

use App\Http\Resources\news\NewsPublicBasicResource;
use App\Http\Resources\announcements\AnnouncementPublicBasicResource;
use App\Http\Resources\navigations\LinkPublicBasicResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SidebarController extends Controller
{
    public function latestNews()
    {
    	$latestNews = \App\News::where('hidden', 0)
    		->orderBy('posted_at', 'desc')
    		->take(4)
    		->get();

    	return NewsPublicBasicResource::collection($latestNews);
    }

    public function latestAnnouncements()
    {
    	$announcement = \App\Announcement::where('hidden', 0)
    		->orderBy('posted_at', 'desc')
    		->take(4)
    		->get();

    	return AnnouncementPublicBasicResource::collection($announcement);
    }

    public function links()
    {
    	$links = \App\Navigation::where('hidden', 0)
    		->where('type', 'link')
    		->orderBy('disposition', 'asc')
    		->get();

    	return LinkPublicBasicResource::collection($links);
    }
}
