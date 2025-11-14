<?php

namespace Modules\Videos\Services;

use Modules\Videos\Models\Video;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class VideosService
{
    public function getVideos() {
        /** @var Builder */
        $videos = Video::where('active', 1)
            ->withTranslation()
            ->orderBy('order');
            
        return $videos;
    }

    public function getVideo(string $slug)
    {
        $video = Video::where('active', 1)
            ->whereTranslation('slug', $slug)
            ->withTranslation();

        return $video->firstOrFail();
    }

    public function getFeaturedVideos()
    {
        $videos = Video::where('active', 1)
            ->withTranslation()
            ->where('featured', 1);

        return $videos->get();
    }

    public function hasVideos(){
        
        $count = Video::where('active', 1)->count();
        
        return $count;
    }

}
