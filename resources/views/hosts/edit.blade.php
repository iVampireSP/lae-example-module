@section('title', '主机:' . $host->name)

<x-app-layout>

    <h3>{{ $host->name }}</h3>

    <form method="post" action="{{ route('hosts.update', $host) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="col-sm-2 col-form-label">新的名称</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $host->name }}"
                placeholder="{{ $host->name }}">
            留空以使用默认名称
        </div>

        <div class="form-group">
            <label for="price" class="col-sm-2 col-form-label">原始价格</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ $host->price }}"
                placeholder="{{ $host->price }}">
            推荐修改覆盖价格
        </div>

        <div class="form-group">
            <label for="managed_price" class="col-sm-2 col-form-label">覆盖价格</label>
            <input type="text" class="form-control" id="managed_price" name="managed_price"
                value="{{ $host->managed_price }}" placeholder="如果要为此主机永久设置新的价格，请修改这里。否则这里应该留空。">
            留空将会按照原始价格计费
        </div>


        <button type="submit" class="btn btn-primary mt-3">修改</button>

    </form>


    <form method="post" action="{{ route('hosts.destroy', $host) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">删除</button>
    </form>


</x-app-layout>
