<?php

namespace App\Listeners;

use Orchid\Platform\Events\UploadedFileEvent;

class OptimizeAttachmentsListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UploadedFileEvent $event)
    {
        $file = $event->attachment;

        /*
        if (in_array($file->getMimeType(), ['image/jpeg', 'image/png'])) {

            try {
                $optimized = Image::make(Storage::disk('public')->get($file->physicalPath()))->encode('webp', 80);
            }
            catch (\Exception $e) {
                return;
            }

            Storage::disk('public')->put($file->path . $file->name . ".webp", $optimized);

            Storage::disk('public')->delete($file->physicalPath());

            $file->extension = 'webp';
            $file->mime = 'image/webp';
            $file->save();
        }
        */
    }
}
