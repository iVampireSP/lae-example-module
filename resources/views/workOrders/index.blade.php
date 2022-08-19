<x-app-layout>
    <h1>工单</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>标题</th>
                <th>客户</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>更新时间</th>
                {{-- <th>操作</th> --}}
            </tr>
        </thead>


        <tbody>
            @foreach ($workOrders as $workOrder)
                <tr>
                    <td><a href="{{ route('work-orders.show', $workOrder->id) }}">{{ $workOrder->id }}</a></td>
                    <td><a href="{{ route('work-orders.show', $workOrder->id) }}">{{ $workOrder->title }}</a></td>
                    <td>{{ $workOrder->client->name }}</td>
                    <td>{{ $workOrder->status}}</td>
                    <td>{{ $workOrder->created_at }}</td>
                    <td>{{ $workOrder->updated_at }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>


    {{ $workOrders->links() }}
</x-app-layout>
