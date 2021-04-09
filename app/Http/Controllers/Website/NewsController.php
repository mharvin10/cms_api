<?php

namespace App\Http\Controllers\Website;

use App\News;
use App\Http\Resources\news\NewsPublicBasicResource;
use App\Http\Resources\news\NewsPublicFullResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function news($slug)
    {
    	$news = $this->news->where('slug', $slug)->first();

    	$latestNews = $this->news
            ->where('id', '<>', $news->id)
            ->where('hidden', 0)
        		->orderBy('posted_at', 'desc')
        		->take(4)
        		->get();

      return (new NewsPublicFullResource($news))
          ->additional([
              'latest_news' => NewsPublicBasicResource::collection($latestNews)
          ]);
    }

    public function list()
    {
    	$news = $this->news->all();

      return NewsPublicBasicResource::collection($news);
    }
}
