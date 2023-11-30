<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Imagick;
use League\Flysystem\FilesystemException;
use Orchid\Attachment\File;
use Orchid\Attachment\Models\Attachment;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Events\UploadedFileEvent;
use Orchid\Platform\Http\Controllers\Controller;

class FilesController extends Controller
{
    /**
     * @var Attachment
     */
    protected $attachment;

    /**
     * AttachmentController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.systems.attachment');
        $this->attachment = Dashboard::modelClass(Attachment::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $filesArray = $request->files->all();
        if (isset($filesArray['files'])) {
            $filesArray = $filesArray['files'];
        }
        foreach ($filesArray as $file) {
            $fileItem['mimeType'] = $file->getClientMimeType();
            $fileItem['originalName'] = $file->getClientOriginalName();
            $fileItem['pathName'] = $file->getPathname();
            if (Str::contains($file->getClientMimeType(), 'image') && $file->getClientMimeType() !== 'image/svg+xml') {
                $files[] = $this->cropImage($fileItem, $request->get('width'), $request->get('height'));
            }
        }

        $files = $files ?? $request->allFiles();

        $attachment = collect($files)
            ->flatten()
            ->map(fn(UploadedFile $file) => $this->createModel($file, $request));

        $response = $attachment->count() > 1 ? $attachment : $attachment->first();

        return response()->json($response);
    }

    public function cropImage($fileItem, $width = null, $height = null)
    {
        $imagickObj = new Imagick();
        $imagickObj->readImage($fileItem['pathName']);
        $orig_width = $imagickObj->getImageWidth();
        $orig_height = $imagickObj->getImageHeight();
        if (!empty($width) && !empty($height)) {
            $orig_aspect_ratio = $orig_height / $orig_width;
            $thumb_aspect_ratio = $height / $width;
            if ($orig_aspect_ratio >= $thumb_aspect_ratio) {
                $width = 0;
            } else {
                $height = 0;
            }
            if (!empty($height) && $height > $orig_height) {
                $height = $orig_height;
            }
            if (!empty($width) && $width > $orig_width) {
                $width = $orig_width;
            }
            $imagickObj->thumbnailImage($width, $height);
            $imagickObj->setOption('webp:method', '6');
            $imagickObj->setImageCompressionQuality(100);
            $imagickObj->setOption('webp:lossless', 'true');
            $imagickObj->setImageFormat("webp");
        }
        $imagickObj->setImageBackgroundColor('white');
        $imagickObj->setImageCompressionQuality(100);
        $fileItem['mimeType'] = 'image/webp';

        try {
            $imagickObj->writeImage($fileItem['pathName']);
        } catch (\Throwable $exception) {
            dd($exception);
        }

        return new UploadedFile(
            $fileItem['pathName'],
            $fileItem['originalName'],
            $fileItem['mimeType']
        );
    }

    /**
     * @param UploadedFile $file
     * @param Request $request
     * @return mixed
     * @throws FilesystemException
     */
    private function createModel(UploadedFile $file, Request $request)
    {
        $file = resolve(File::class, [
            'file' => $file,
            'disk' => $request->get('storage'),
            'group' => $request->get('group'),
        ]);

        if ($request->has('path')) {
            $file->path($request->get('path'));
        }

        $model = $file->load();
        $model->url = $model->url();

        event(new UploadedFileEvent($model));

        return $model;
    }

    /**
     * @param Request $request
     */
    public function sort(Request $request): void
    {
        collect($request->get('files', []))
            ->each(function ($sort, $id) {
                $attachment = $this->attachment->find($id);
                $attachment->sort = $sort;
                $attachment->save();
            });
    }

    /**
     * Delete files.
     * @param string $id
     * @param Request $request
     * @throws Exception
     */
    public function destroy(string $id, Request $request): void
    {
        $storage = $request->get('storage', 'public');
        $this->attachment->findOrFail($id)->delete($storage);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(string $id, Request $request)
    {
        $attachment = $this->attachment
            ->findOrFail($id)
            ->fill($request->all());

        $attachment->save();

        return response()->json($attachment);
    }

    /**
     * @return JsonResponse
     */
    public function media(): JsonResponse
    {
        $attachments = $this->attachment->filters()->paginate(12);

        return response()->json($attachments);
    }
}
