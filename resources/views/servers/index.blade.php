<x-app-layout>
    <h1>服务器列表</h1>
    <a href="{{ route('servers.create') }}">添加服务器</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>FQDN</th>
                <th>端口</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
        </thead>


        <tbody>
            @foreach ($servers as $server)
                <tr>
                    <td>{{ $server->id }}</td>
                    <td>{{ $server->name }}</td>
                    <td>{{ $server->fqdn }}</td>
                    <td>{{ $server->port }}</td>
                    <td>{{ $server->status }}</td>
                    <td>{{ $server->created_at }}</td>
                    <td>
                        <a href="{{ route('servers.edit', $server->id) }}">编辑</a>

                        @if ($server->status == 'down')
                            <span style="color: red">无法连接到服务器。</span>
                            <form action="{{ route('servers.update', $server->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="up" />
                                <button type="submit">强制标记为在线</button>
                            </form>
                        @else
                            <span style="color: red">正常</span>

                            <form action="{{ route('servers.update', $server->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="down" />
                                <button type="submit">标记为离线</button>
                            </form>
                        @endif


                        @if ($server->status == 'maintenance')
                            <span style="color: red">维护中</span>

                            <form action="{{ route('servers.update', $server->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="down" />
                                <button type="submit">取消维护</button>
                            </form>
                        @else
                            <form action="{{ route('servers.update', $server->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="maintenance" />
                                <button type="submit">开始维护</button>
                            </form>
                        @endif

                        <form action="{{ route('servers.destroy', $server->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">删除</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>


    {{ $servers->links() }}
</x-app-layout>
