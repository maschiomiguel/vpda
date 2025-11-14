<?php

namespace App\Traits;

use Orchid\Attachment\Models\Attachment;
use Orchid\Attachment\Attachable as OrchidAttachable;

trait Attachable
{
    use OrchidAttachable;

    public function getAttachmentById(int $id): Attachment
    {
        $attachment = Attachment::where('id', $id)->first();
        return $attachment;
    }
}
