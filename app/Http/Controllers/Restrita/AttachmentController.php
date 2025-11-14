<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restrita;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Events\UploadedFileEvent;
use Symfony\Component\HttpFoundation\Response;
use Orchid\Platform\Http\Controllers\AttachmentController as ControllersAttachmentController;

class AttachmentController extends ControllersAttachmentController
{
    public function upload(Request $request): JsonResponse
    {
        $availableFormats = [
            "doc",
            "docx",
            "txt",
            "odc",
            "odp",
            "odt",
            "otf",
            "ppt",
            "pptx",
            "xls",
            "xlsx",

            "jpg",
            "jpeg",
            "png",
            "gif",
            "pdf",
            "webp",
            "svg",

            "zip",

            "3gp",
            "avi",
            "mp4",
            "mov",
            "wmv",
            "webm",
        ];

        $imageFormats = [
            "jpg",
            "jpeg",
            "png",
            "webp",
        ];

        foreach ($request->allFiles() as $file) {
            if (is_array($file)) {
                foreach ($file as $f) {
                    $extension = strtolower($f->getClientOriginalExtension());

                    if (!in_array($extension, $availableFormats, true)) {
                        abort(500, 'Extensão inválida');
                    }

                    if (in_array($extension, $imageFormats, true)) {
                        list($with, $height) = getimagesize($f->path());

                        $max = 2000 * 2000;
                        if ($with * $height > $max) {
                            abort(500, 'As dimensões da imagem não podem ultrapassar 2000px');
                        }
                    }
                }
            } else if (!in_array(strtolower($file->getClientOriginalExtension()), $availableFormats)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Extensão inválida de arquivo'
                ]);
            }
        }

        $attachment = collect($request->allFiles())
            ->flatten()
            ->map(function (UploadedFile $file) use ($request) {
                return $this->createModel($file, $request);
            });

        $response = $attachment->count() > 1 ? $attachment : $attachment->first();

        return response()->json($response);
    }

    private function createModel(UploadedFile $file, Request $request)
    {
        $model = resolve(File::class, [
            'file'  => $file,
            'disk'  => $request->get('storage'),
            'group' => $request->get('group'),
        ])->load();

        event(new UploadedFileEvent($model));

        $model->url = $model->url();

        return $model;
    }
    
    /**
     * Delete files.
     *
     * @param string  $id
     * @param Request $request
     */
    public function destroy(string $id, Request $request): void
    {
        // se está duplicando um item, não exclui os attachments do item original
        if (request()->query('duplicate')) {
            return;
        }
        parent::destroy($id, $request);
    }

}
