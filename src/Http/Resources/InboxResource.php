<?php

namespace YourVendor\FakeInbox\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InboxResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'settings' => $this->settings,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'emails_count' => $this->whenCounted('emails'),
            'links' => [
                'self' => route('api.fake-inbox.inboxes.show', $this),
                'emails' => route('api.fake-inbox.inboxes.emails.index', $this),
            ],
        ];
    }
}