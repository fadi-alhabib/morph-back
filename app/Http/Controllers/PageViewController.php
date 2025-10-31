<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageViewRequest;
use App\Http\Resources\PageViewResource;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageViewController extends Controller
{
    public function index(Request $request)
    {
        $views = PageView::latest()->paginate(50);
        return PageViewResource::collection($views);
    }

    public function store(StorePageViewRequest $request)
    {
        $data = $request->validated();
        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->userAgent();
        $data['method'] = $request->method();
        $data['referer'] = $request->header('referer');

        $view = PageView::create($data);

        return new PageViewResource($view);
    }

    public function stats(Request $request)
    {
        $daily = PageView::select(
            DB::raw('DATE(viewed_at) as date'),
            DB::raw('COUNT(*) as views'),
            DB::raw('COUNT(DISTINCT ip) as unique_visitors')
        )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $topPages = PageView::select(
            'path',
            DB::raw('COUNT(*) as views')
        )
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return response()->json([
            'daily' => $daily,
            'top_pages' => $topPages,
            'total_views' => PageView::count(),
            'unique_visitors' => PageView::distinct('ip')->count('ip'),
        ]);
    }
}
