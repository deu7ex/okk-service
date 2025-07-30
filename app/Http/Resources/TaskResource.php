<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Task resource
 *
 * @property integer $id
 * @property integer $status
 * @property string $status_label
 * @property string $audio_url
 * @property array $parameters
 * @property array $metadata
 * @property string $created_at
 */
class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'audio_url' => $this->audio_url,
            'parameters' => $this->parameters,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
        ];
    }
}
