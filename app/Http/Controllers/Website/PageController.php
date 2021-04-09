<?php

namespace App\Http\Controllers\Website;

use App\PageNode;
use App\Http\Resources\page_nodes\PageNodePublicBasicResource;
use App\Http\Resources\page_nodes\PageNodePublicBasicWithCollectionResource;
use App\Http\Resources\page_nodes\PagePublicFullResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    protected $pageNode;

    public function __construct(PageNode $pageNode)
    {
        $this->pageNode = $pageNode;
    }

    public function page($slug)
    {
    	$page = $this->pageNode->whereHas('pageContent', function ($query) use ($slug){
                $query->where('slug', $slug);
            })
            ->first();

        $ancestors = $this->pageNode->defaultOrder()->ancestorsAndSelf($page->id);
    	$children = $page->children()->where('hidden', 0)->defaultOrder()->get();
        $siblings = $page->siblings()->where('hidden', 0)->defaultOrder()->get();

        return (new PagePublicFullResource($page))
            ->additional([
                'ancestors' => PageNodePublicBasicResource::collection($ancestors),
                'children' => PageNodePublicBasicWithCollectionResource::collection($children),
                'siblings' => PageNodePublicBasicWithCollectionResource::collection($siblings)
            ]);
    }
}
