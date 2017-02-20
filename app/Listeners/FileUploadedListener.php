<?php

namespace App\Listeners;

use App\Image;
use Overtrue\LaravelUploader\Events\FileUploaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FileUploadedListener
{
    /**
     * Handle the event.
     *
     * @param  Overtrue\LaravelUploader\Events\FileUploaded  $event
     * @param  Array $result
     *
     * @return void
     */
    public function handle(FileUploaded $event)
    {
        $file = $event->file;
        $result = $event->result;

        [$width, $height] = getimagesize($file);

        $data = [
            'creator_id' => auth()->id(),
            'title' => $result['original_name'],
            'path' => $result['url'],
            'size' => "{$width} x {$height}",
        ];

        $image = Image::create($data);

        $result['image_id'] = $image->id;

        return $result;
    }
}
