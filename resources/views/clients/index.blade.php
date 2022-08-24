<x-app-layout>
    <h1>已经发现的客户</h1>

    <table>
        {{-- 表头 --}}
        <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>邮箱</th>
                <th>创建时间</th>
                <th>更新时间</th>
                {{-- <th>操作</th> --}}
            </tr>
        </thead>

        {{-- 表内容 --}}
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->created_at }}</td>
                    <td>{{ $client->updated_at }}</td>
                    {{-- <td>
                        <a href="{{ route('clients.show', $client) }}">查看</a>
                        <a href="{{ route('clients.edit', $client) }}">编辑</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">删除</button>
                        </form>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- @foreach ($clients as $client)
        
    @endforeach --}}

    {{ $clients->links() }}
</x-app-layout>