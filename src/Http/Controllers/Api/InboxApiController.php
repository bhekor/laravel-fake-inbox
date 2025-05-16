<?php

namespace YourVendor\FakeInbox\Http\Controllers\Api;

use YourVendor\FakeInbox\Http\Controllers\Controller;
use YourVendor\FakeInbox\Http\Requests\CreateInboxRequest;
use YourVendor\FakeInbox\Http\Resources\InboxCollection;
use YourVendor\FakeInbox\Http\Resources\InboxResource;
use YourVendor\FakeInbox\Models\Inbox;

class InboxApiController extends Controller
{
    /**
     * List all inboxes for authenticated user
     *
     * @return InboxCollection
     */
    public function index()
    {
        return new InboxCollection(
            Inbox::where('user_id', auth()->id())->paginate()
        );
    }

    /**
     * Create a new inbox
     *
     * @param CreateInboxRequest $request
     * @return InboxResource
     */
    public function store(CreateInboxRequest $request)
    {
        $inbox = Inbox::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Inbox::generateSlug($request->name),
            'settings' => $request->validated(),
        ]);

        return new InboxResource($inbox);
    }

    /**
     * Show a specific inbox
     *
     * @param Inbox $inbox
     * @return InboxResource
     */
    public function show(Inbox $inbox)
    {
        $this->authorize('view', $inbox);
        return new InboxResource($inbox);
    }
}