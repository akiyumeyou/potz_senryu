<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <nav class="mt-4">
                        <a href="{{ route('tweets.index') }}" class="text-blue-500 hover:underline">チャット</a>
                        <a href="{{ route('stamp.create') }}" class="ml-4 text-blue-500 hover:underline">スタンプ</a>
                    </nav>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                        @foreach ($images as $stamp)
                            <div class="stamp-item mb-4">
                                <img src="{{ asset($stamp->image) }}" alt="Image" class="stamp-image w-full h-auto">
                                <div class="stamp-details mt-2 text-sm">
                                    <p>記録: {{ $stamp->created_at->format('y/m/d H:i') }}</p>
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
            </div>
        </div>
    </div>
</x-app-layout>



