<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Evaluation resource
 *
 * @property double $score
 * @property string $summary
 * @property array $raw
 */
class EvaluationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'score' => $this->score,
            'summary' => $this->summary,
            'raw' => $this->raw
        ];
    }
}
