<?php

namespace App\Http\Controllers\Website;

use App\Announcement;
use App\Http\Resources\announcements\AnnouncementPublicBasicResource;
use App\Http\Resources\announcements\AnnouncementPublicFullResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    protected $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    public function announcement($slug)
    {
    	$announcement = $this->announcement->where('slug', $slug)->first();

    	$latestAnnouncement = $this->announcement
    		->where('id', '<>', $announcement->id)
    		->where('hidden', 0)
    		->orderBy('posted_at', 'desc')
    		->take(4)
    		->get();

        return (new AnnouncementPublicFullResource($announcement))
            ->additional([
                'latest_announcement' => AnnouncementPublicBasicResource::collection($latestAnnouncement)
            ]);
    }

    public function list()
    {
    	$announcements = $this->announcement->all();

      return AnnouncementPublicBasicResource::collection($announcements);
    }
}
