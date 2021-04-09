<?php

namespace App\Http\Controllers\Admin;

use App\PageNode;
use App\Http\Resources\page_nodes\PageNodeAdminBasicResource;
use App\Http\Resources\page_nodes\PageNodeAdminFullResource;
use App\Http\Resources\page_nodes\PageAdminBasicResource;
use App\Http\Resources\page_nodes\PageAdminFullResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PageNodeController extends Controller
{
    protected $pageNode;

    public function __construct(PageNode $pageNode)
    {
        $this->pageNode = $pageNode;
    }

    public function pageNodes(Request $request)
    {
        $pageNodes = $this->pageNode
            ->where('id', '<>', 'rootpage')
            ->withDepth()
            ->defaultOrder()
            ->get();

        return PageNodeAdminBasicResource::collection($pageNodes);
    }

    public function parentPageNodes(Request $request, $parentNode = null)
    {
        if ($parentNode) {
            $currentParentNode = $this->pageNode->withDepth()->defaultOrder()->find($parentNode);
        } else {
            $currentParentNode = $this->pageNode->withDepth()->defaultOrder()->find('rootpage');
        }

        if (!$currentParentNode || $currentParentNode->depth > 2) {
            abort('404', 'not_found');
        }
        return (new PageNodeAdminBasicResource($currentParentNode))
            ->additional([
                'children' => PageNodeAdminBasicResource::collection($currentParentNode->children()->withDepth()->defaultOrder()->get()),
                'ancestors' => PageNodeAdminBasicResource::collection($this->pageNode->defaultOrder()->ancestorsAndSelf($currentParentNode->id))
            ]);
    }

    public function pageNode(Request $request, PageNode $pageNode)
    {
        return new PageNodeAdminFullResource($pageNode);
    }

    public function store($request, $parent)
    {
        do {
            $id = str_random(14);
            $pageNode = $this->pageNode->find($id);
        } while ($pageNode);

        $page = $parent->children()->create([
            'id' => $id,
            'title' => $request->title,
            'short_title' => $request->short_title,
            'hidden' => $request->hidden,
            'created_by' => $request->user()->id
        ]);

        if ($request->location !== NULL && $request->sibling !== NULL) {
            $sibling = $this->pageNode->find($request->sibling);
            switch ($request->location) {
                case 'before':
                    $page->insertBeforeNode($sibling);
                    break;
                case 'after':
                    $page->insertAfterNode($sibling);
                    break;
            }
        }

        return $page;
    }

    public function rename(Request $request, PageNode $pageNode)
    {
        $validations = [
            'title' => 'required|max:150',
            'short_title' => 'nullable|max:40'
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.',
            'short_title.max' => 'Short title must be 150 characters or less.'
        ];

        $this->validate($request, $validations, $errors);

        $pageNode->update([
            'title' => $request->title,
            'short_title' => $request->short_title
        ]);
    }

    public function showOrHide(Request $request, PageNode $pageNode)
    {
        $pageNode->update([
            'hidden' => !$pageNode->hidden
        ]);
    }

    public function move(Request $request, PageNode $pageNode, $dirtn)
    {
        switch ($dirtn) {
            case 'down':
                $pageNode->down();
                break;
            case 'up':
                $pageNode->up();
                break;
        }
    }

    public function destroy(PageNode $pageNode)
    {
        // if ($pageNode->pageContent) {
        //     if ($pageNode->pageContent->header_image) {
        //         Storage::delete($pageNode->pageContent->header_image);
        //         $pageNode->pageContent->delete();
        //     }
        // }

        $pageNode->delete();
    }

    /**
     * Page actions
     */
    public function page(Request $request, PageNode $pageNode)
    {
        return new PageAdminFullResource($pageNode);
    }

    public function pages(Request $request)
    {
        $pages = $this->pageNode
            ->has('pageContent')
            ->get();

        return PageAdminBasicResource::collection($pages);
    }

    public function storePage(Request $request, PageNode $parent)
    {
        $validations = [
            'title' => 'required|max:150',
            'short_title' => 'nullable|max:40',
            'slug' => 'nullable|alpha_dash|unique:page_contents,slug',
            'redirect_url' => 'required_if:redirect,1|nullable|url',
            'sibling' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->location !== NULL && $value === NULL) {
                        $fail('Please select a page');
                    }
                }
            ]
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.',
            'short_title.max' => 'Short title must be 150 characters or less.',
            'slug.unique' => 'This URL has already been taken.',
            'slug.alpha_dash' => 'Custom URL name may only contain letters, numbers, and dashes.',
            'redirect_url.required_if' => 'Redirect url is required.',
            'redirect_url.url' => 'Please input a valid URL.'
        ];

        $this->validate($request, $validations, $errors);

        $page = $this->store($request, $parent);

        $page->pageContent()->create([
            'slug' => strtolower($request->slug),
            'redirect_url' => $request->redirect ? $request->redirect_url : NULL
        ]);

    }

    public function updatePageContent(Request $request)
    {
        if ($request->pageId) {
            $page = $this->pageNode->find($request->pageId)->pageContent;

            if ($page) {
                $page->body = $request->body;
                $page->save();
            }
        }
    }

    public function updatePageSettings(Request $request, PageNode $pageNode)
    {
        $validations = [
            'slug' => [
                'nullable',
                'alpha_dash',
                function ($attribute, $value, $fail) use ($request, $pageNode) {
                    $page = $this->pageNode->whereHas('pageContent', function ($query) use ($value, $pageNode) {
                        $query->where('slug', $value)
                            ->where('page_node_id', '<>', $pageNode->id);
                    })
                    ->get();

                    if (count($page)) {
                        $fail('This URL has already been taken.');
                    }
                }
            ],
            'redirect_url' => 'required_if:redirect,1|nullable|url',
        ];

        $errors = [
            'slug.alpha_dash' => 'Custom URL name may only contain letters, numbers, and dashes.',
            'redirect_url.required_if' => 'Redirect url is required.',
            'redirect_url.url' => 'Please input a valid URL.'
        ];

        $this->validate($request, $validations, $errors);

        $pageNode->update([
            'hidden' => $request->hidden,
        ]);

        $pageNode->pageContent()->update([
            'slug' => strtolower($request->slug),
            'redirect_url' => $request->redirect ? $request->redirect_url : NULL
        ]);

        if ($request->headerImage) {
            $imageBase64 = explode(',', $request->headerImage);
            if (count($imageBase64) > 1) {
                $hasOldHeaderImage = Storage::exists($pageNode->pageContent->header_image);
                if ($hasOldHeaderImage) {
                    Storage::delete($pageNode->pageContent->header_image);
                }
                $imageBase64Decoded = base64_decode($imageBase64[1]);
                $image = $this->pageFilesDirectory($pageNode->id) . '/images/header/' . str_random(12) . '.png';
                Storage::put($image, $imageBase64Decoded);
                $pageNode->pageContent()->update([
                    'header_image' => $image
                ]);
            }
        } else {
            if ($pageNode->pageContent->header_image) {
                Storage::delete($pageNode->pageContent->header_image);
                $pageNode->pageContent()->update([
                    'header_image' => null,
                ]);
            }
        }
    }

    public function storePageImage(Request $request)
    {
        $uploadedImage = $request->image->storeAs($this->pageFilesDirectory($request->pageId) . '/images', $request->image->getClientOriginalName());

        $response = [
            'link' => url(Storage::url($uploadedImage))
        ];

        return $response;
    }

    public function pageImages(Request $request)
    {
        $images = Storage::files($this->pageFilesDirectory($request->pageId) . '/images');

        $images_obj = [];

        foreach ($images as $key => $value) {
            $images_obj [] = [
            'url' => url(Storage::url($value)),
            // 'url' => asset('img/sample_cart/39-iceland_money30029.jpg'),
            // thumb: "http://exmaple.com/thumbs/photo1.jpg",
            // 'tag' => 'General'
            ];
        }

        return $images_obj;
    }

    public function deletePageImage(Request $request)
    {
        $src = explode('storage/', $request->src);

        Storage::delete('public/'.$src[1]);
    }

    public function storePageFile(Request $request)
    {
        $uploadedFile = $request->file->storeAs($this->pageFilesDirectory($request->pageId) . '/files', $request->file->getClientOriginalName());

        $response = [
            'link' => url(Storage::url($uploadedFile))
        ];

        return $response;
    }

    /**
     * Page section actions.
     */
    public function storeSection(Request $request, PageNode $parent)
    {
        $validations = [
            'title' => 'required|max:150',
            'short_title' => 'nullable|max:40',
            'sibling' => [
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->location !== NULL && $value === NULL) {
                        $fail('Please select a page');
                    }
                }
            ]
        ];

        $errors = [
            'title.required' => 'Title is required.',
            'title.max' => 'Title title must be 150 characters or less.',
            'short_title.max' => 'Short title must be 150 characters or less.',
        ];

        $this->validate($request, $validations, $errors);

        $this->store($request, $parent);

    }

    private function pageFilesDirectory($folder)
    {
        return "public/page/$folder";
    }
}
