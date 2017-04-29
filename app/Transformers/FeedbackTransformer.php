<?php

namespace App\Transformers;

use App\Feedback;
use League\Fractal\TransformerAbstract;

class FeedbackTransformer extends TransformerAbstract
{
    /**
     * Transform a feedback.
     *
     * @param Feedback $feedback
     *
     * @return array
     */
    public function transform(Feedback $feedback)
    {
        return [
            'id' => $feedback->id,
            'user_id' => $feedback->user_id,
            'image_id' => $feedback->image_id,
            'ip' => $feedback->ip,
            'content' => $feedback->content,
            'created_at' => $feedback->created_at->toIso8601String(),
            'updated_at' => $feedback->updated_at->toIso8601String(),
        ];
    }
}