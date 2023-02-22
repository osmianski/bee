<?php
/* @var ?string $note */
?>
<div>
    @if ($note)
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <p class="mt-2 text-sm text-gray-700">{{ $note }}</p>
            </div>
        </div>
    @endif
    <div class="mt-8 overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        @if (count($tickets) > 0)
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Subject</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 xl:table-cell w-[12rem]">Author</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell w-[12rem]">Assigned to</th>
                    <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 w-[7rem]">Resolved</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($tickets as $ticket)
                    <tr class="hover:bg-gray-50">
                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                            <a href="{{ route('tickets.edit', ['ticket' => $ticket->id]) }}" class="flex items-center">

                                <div class="ml-3 flex-grow">
                                    <span class="italic">#{{ $ticket->id }}</span>
                                    <span>{{ $ticket->subject }}</span>
                                    @if($ticket->author)
                                        <p class="mt-4 font-normal xl:hidden truncate">
                                            <span>By</span>
                                            <span class="text-gray-700">{{ $ticket->author?->name }}</span>
                                        </p>
                                    @endif
                                    @if($ticket->assignedUser)
                                        <p class="font-normal lg:hidden truncate">
                                            <span>Assigned to</span>
                                            <span class="text-gray-700">{{ $ticket->assignedUser?->name }}</span>
                                        </p>
                                    @endif
                                </div>
                            </a>
                        </td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 xl:table-cell text-left">
                            @if ($ticket->author)
                                <a href="#" wire:click.prevent="columnFilter('author', '{{ $ticket->author?->name }}')">
                                    {{ $ticket->author?->name }}
                                </a>
                            @endif
                        </td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell text-left">
                            @if ($ticket->assignedUser)
                                <a href="#" wire:click.prevent="columnFilter('assignedTo', '{{ $ticket->assignedUser?->name }}')">
                                    {{ $ticket->assignedUser?->name }}
                                </a>
                            @endif
                        </td>
                        <td class="px-3 py-4 text-sm text-gray-500 text-center">
                            <a href="#" wire:click.prevent="columnFilter('resolved', {{ $ticket->resolved_at !== null }})" class="block">
                                @if($ticket->resolved_at) Yes @else No @endif
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tickets->onEachSide(2)->links() }}
        @else
            <div class="text-center bg-white p-10">
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tickets.</h3>
                @if ($hasFilters)
                    <p class="mt-1 text-sm text-gray-500">Modify the filters to get something to work with.</p>
                @else
                    <span class="pr-1">Everybody seems to be happy!</span>
                @endif
            </div>
        @endif
    </div>
</div>
