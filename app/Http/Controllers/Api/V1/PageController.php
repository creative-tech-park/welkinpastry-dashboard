<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\Seo;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
            $pages = Page::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->latest();
            if(\request()->has('onlyData')){
                $pages = $pages->select('id', 'title')->get();
                return response()->json($pages, 200);
            }
            $pages = $pages->simplePaginate(10)->withQueryString();
            return response()->json($pages, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        Request::validate([
            'id' => 'exists:pages,id',
            'content' => 'required'
        ]);

        if($id = Request::input('id')){
            Request::validate([
                'title' => 'required|max:255|unique:pages,title,'.Request::input('id'),
            ]);
            $page = Page::query()->findOrfail($id);
        }else{
            Request::validate([
                'title' => 'required|max:255|unique:pages'
            ]);
            $page = new Page();
        }
        $page->title = Request::input('title');
        $page->content = Request::input('content');
        $page->status = true;
        $page->save();
        return response()->json($id ? 'Page Update' : 'Page Save' . 'Successfully done...', 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $page = Page::query()->findOrFail($id);
        return response()->json($page, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */


    public function updatePage($id){

        $page = Page::with('seo')->findOrFail($id);

        if (Request::hasFile('icon')){
            $icon = Request::file('icon')->store('uploads/all', 'public');
            $page->seo->icon = $icon;
        }

        $page->title = Request::input('title');
        $page->summery = Request::input('summery');
        $page->status = filled(Request::input('status'));
        $page->is_delete= true;
        $page->update();

        $page->seo->title = Request::input('seoTitle');
        $page->seo->key_words = json_encode(Request::input('seoKeyWords'));
        $page->seo->description = Request::input('seoDiscriptions');
        $page->seo->update();
        return redirect()->route('admin.pages.index')->with('message', 'Your page Updated...');

    }


    public function update(Request $request, Page $page)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $page = Page::query()->findOrFail($id);
        $page->delete();
        return back();
    }


    public function navPages(){
        $ids = collect(json_decode(get_setting('headerPages')));
        $pages = [];
        if(count($ids) > 0){
            $pages = Page::query()->whereIn('id', $ids)->get();
        }
        return response()->json($pages);
    }


}
