<?php

namespace Modules\Videos\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SiteService;
use Modules\Videos\Services\VideosService;

class VideosController extends Controller
{
    public function index(SiteService $site, VideosService $videosService)
    {
        $site
            ->setAlternates('videos')
            ->setMenuActive('videos')
            ->pushBreadCrumb(__('modules-videos::strings.Galerias'), route_lang('videos'))
            ->setBreadTitle(__('modules-videos::strings.Galerias'))
            ->setTitle(__('modules-videos::strings.Galerias'));

        $videos = $videosService->getVideos()->paginate(12);

        // necessário para a paginação manter os parâmetros GET
        $videos->appends(request()->input());

        return view('modules-videos::videos', [
            'videos' => $videos,
        ]);
    }

    public function details(SiteService $site, VideosService $videosService, string $slug)
    {
        $site
            ->pushBreadCrumb(__('modules-videos::strings.Galerias'), route_lang('videos'))
            ->setMenuActive('videos');

        $video = $videosService->getVideo($slug);

        $site
            ->setAlternates('videos.details', $video)
            ->setTitle($video->title)
            ->pushBreadCrumb($video->short_title ?: $video->title)
            ->setBreadTitle($video->short_title ?: $video->title)
            ->setDescriptionIfNotEmpty($video->description)
            ->setKeywordsIfNotEmpty($video->keywords)
            ->setMetasSocials($video, $video->image, 'article');

        return view('modules-videos::videos-details', [
            'video' => $video,
        ]);
    }
}
