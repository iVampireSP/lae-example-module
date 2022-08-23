<x-app-layout>
    <h2>编辑 {{ $server->name }}</h2>


    <form method="POST" action="{{ route('servers.update', $server->id) }}">
        @csrf
        @method('PUT')
        {{-- name --}}
        <input type="text" name="name" placeholder="服务器名称" value="{{ $server->name }} "/>

        {{-- fqdn --}}
        <input type="text" name="fqdn" placeholder="服务器域名" value="{{ $server->fqdn }} "/>

        {{-- port --}}
        <input type="text" name="port" placeholder="服务器端口" value="{{ $server->port }} " />

        {{-- status dropdown --}}
        <select name="status">
            <option value="up">在线</option>
            <option value="down">离线</option>
            <option value="maintenance">维护中</option>
        </select>

        {{-- submit --}}
        <input type="submit" value="更新" />

    </form>
</x-app-layout>
