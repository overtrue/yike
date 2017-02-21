<?php

namespace App\Jobs;

use Image;
use App\Image as ImageModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HandleImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $image = Image::make($this->image['url'])->widen(2200, function ($constraint) {
                    $constraint->upsize();
                })->save($this->image['relative_url']);

        ImageModel::findOrFail($this->image['image_id'])->update([
            'size' => "{$image->width()} x {$image->height()}"
        ]);
    }
}
