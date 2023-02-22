<?php
/* @var ?string $note */
/* @var \App\Http\Livewire\Table\Column[] $columns */
/* @var \Illuminate\Database\Eloquent\Model[] $data */
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
        @if (count($data) > 0)
            <div class="table min-w-full divide-y divide-gray-300">
                <div class="table-header-group bg-gray-50">
                    <div class="table-row">
                        @foreach($columns as $column)
                            <div scope="col" class="table-cell py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ $column->title }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="table-row-group divide-y divide-gray-200 bg-white">
                @foreach($data as $item)
                    <div class="table-row hover:bg-gray-50">
                        @foreach($columns as $column)
                            <div class="table-cell w-full max-w-0 py-4 pl-4 pr-3 text-sm text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                                {{ $column->value($item) }}
                            </div>
                        @endforeach
                    </div>
                @endforeach
                </div>
            </div>
            {{ $data->onEachSide(2)->links() }}
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
