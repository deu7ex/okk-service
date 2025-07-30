<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Log;

/**
 * Log resource
 *
 * @property integer $id
 * @property integer $type
 * @property string $type_label
 * @property string $message
 * @property string $context
 * @property string $created_at
 */
class LogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'message' => $this->message,
            'context' => $this->context,
            'created_at' => $this->created_at,
        ];
    }
}
