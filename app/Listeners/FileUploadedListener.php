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
        $result = $event->result;

        $image = $this->createImage($event->file, $result);

        if ($event->strategy == 'avatar') auth()->user()->update(['avatar' => $result['url']]);

        $result['image_id'] = $image->id;

        return $result;
    }

    /**
     * Create the image's record.
     *
     * @param  Illuminate\Http\UploadedFile $file
     * @param  array $result
     * @return array
     */
    public function createImage($file, $result)
    {
        [$width, $height] = getimagesize($file);

        $data = [
            'creator_id' => auth()->id(),
            'title' => $result['original_name'],
            'path' => $result['relative_url'],
            'size' => "{$width} x {$height}",
        ];

        return Image::create($data);
    }
}
