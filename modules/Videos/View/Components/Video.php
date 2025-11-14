<?php

namespace Modules\Videos\View\Components;

use Illuminate\View\Component;
use Modules\Videos\Services\VideosService;

class Video extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        private VideosService $videos
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('modules-videos::components.video', [
            'videos' => $this->videos->getVideos(),
        ]);
    }
}
