<x-fake-inbox::layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $inbox->name }} - Emails
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-4">
                        <div class="w-1/3">
                            <input type="text" placeholder="Search emails..." class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <div>
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Refresh
                            </button>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach($emails as $email)
                            <div class="py-4 hover:bg-gray-50 px-2">
                                <a href="{{ route('fake-inbox.emails.show', [$inbox, $email]) }}" class="block">
                                    <div class="flex justify-between">
                                        <div class="font-medium">
                                            {{ $email->from[0]['name'] ?? $email->from[0]['email'] }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $email->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="font-semibold">{{ $email->subject }}</div>
                                    <div class="text-sm text-gray-500 truncate">
                                        {{ Str::limit($email->text_body ?: strip_tags($email->html_body), 100) }}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $emails->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-fake-inbox::layouts.app>