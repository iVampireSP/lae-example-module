<x-app-layout>
    <h1>新产品组</h1>

    <form method="POST" action="{{ route('configurable-option-groups.store') }}">
        @csrf
        {{-- name --}}
        <input type="text" name="name" placeholder="名称" />
        {{-- description --}}
        <input type="text" name="description" placeholder="描述" />
        {{-- submit --}}
        <input type="submit" value="添加" />
    </form>
</x-app-layout>
