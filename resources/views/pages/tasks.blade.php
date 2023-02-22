<x-layout :title="$title ?? 'All tasks'">
    <livewire:tasks :type="$type ?? null" />
</x-layout>
