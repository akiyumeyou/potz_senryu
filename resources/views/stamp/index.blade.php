@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">スタンプ一覧</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div id="stamp-gallery" class="stamp-gallery mt-4">
        @foreach ($images as $stamp)
            <div class="stamp-item mb-4">
                <img src="{{ asset($stamp->image) }}" alt="Image" class="stamp-image" style="width: 150px; height: 150px;">
                <div class="stamp-details mt-2">
                    <p>登録日時: {{ $stamp->created_at }}</p>
                    <form action="{{ route('stamp.destroy', $stamp->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
