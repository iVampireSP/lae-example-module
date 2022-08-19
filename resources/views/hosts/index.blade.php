<x-app-layout>
    <h1>主机</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>客户</th>
                <th>每 5 分钟扣费</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>更新时间</th>
                {{-- <th>操作</th> --}}
            </tr>
        </thead>


        <tbody>
            @foreach ($hosts as $host)
                <tr>
                    <td>{{ $host->id }}</td>
                    <td>{{ $host->name }}</td>
                    <td>{{ $host->client->name }}</td>
                    <td>{{ $host->price }}</td>
                    <td>{{ $host->status }}</td>
                    <td>{{ $host->created_at }}</td>
                    <td>{{ $host->updated_at }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>


    {{ $hosts->links() }}
</x-app-layout>
