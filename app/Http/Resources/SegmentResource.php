<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Segment resource
 *
 * @property string $speaker
 * @property double $start
 * @property double $end
 * @property string $text
 */
class SegmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'speaker' => $this->speaker,
            'start' => (float)$this->start,
            'end' => (float)$this->end,
            'text' => $this->text
        ];
    }
}
