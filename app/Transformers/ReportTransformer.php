<?php

namespace App\Transformers;

use App\Report;
use League\Fractal\TransformerAbstract;

class ReportTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'user',
    ];

    /**
     * List of default includes.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * Transform a report.
     *
     * @param  Report $report
     *
     * @return array
     */
    public function transform(Report $report)
    {
        $reportType = explode('\\', $report->reportable_type);

        return [
            'id' => $report->id,
            'user_id' => $report->user_id,
            'reason' => $report->reason,
            'type' => end($reportType),
            'type_id' => $report->reportable_id,
            'created_at' => $report->created_at->toIso8601String(),
            'updated_at' => $report->updated_at->toIso8601String(),
        ];
    }

    /**
     * Include user.
     *
     * @param  Report $report
     *
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Report $report)
    {
        if ($report->user) {
            return $this->item($report->user, new UserTransformer);
        }
    }
}
