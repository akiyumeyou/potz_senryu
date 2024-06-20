<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>川柳一覧</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .senryu-text {
            writing-mode: vertical-rl;
            text-orientation: upright;
            font-size: 28px;

            margin-bottom: 1px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            height: 240px; /* テキスト表示エリアの高さを調整 */
        }
        .senryu-text p {
            margin: 0;
            margin-bottom: 7px; /* テキスト間の空間を5pxに設定 */
        }
        .senryu-media {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: contain;
            margin-top: 5px;
        }
        .senryu-meta {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 10px;
            margin-top: 5px;
        }
        .senryu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            width: 100%;
            height: 580px; /* カードの高さを調整 */
        }
    </style>
</head>
<body class="bg-yellow-50 flex flex-col items-center justify-center min-h-screen py-20">
    <header class="mb-10">
        <h1 class="text-3xl font-bold">シルバー川柳一覧</h1>
        <nav class="mt-4">
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">最初のページへ</a>
            <a href="{{ route('senryus.create') }}" class="ml-4 text-blue-500 hover:underline">新規投稿</a>
        </nav>
    </header>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-11/12">
        @foreach ($senryus as $senryu)
            <div class="bg-white p-4 rounded-lg shadow-lg senryu-item">
                <div class="senryu-text">
                    <p>{{ $senryu->s_text1 }}</p>
                    <p>{{ $senryu->s_text2 }}</p>
                    <p>{{ $senryu->s_text3 }}</p>
                </div>
                @if ($senryu->img_path)
                    @if (strpos($senryu->img_path, '.mp4') !== false || strpos($senryu->img_path, '.mov') !== false || strpos($senryu->img_path, '.avi') !== false)
                        <video src="{{ $senryu->img_path }}" class="senryu-media" controls></video>
                    @else
                        <img src="{{ $senryu->img_path }}" class="senryu-media">
                    @endif
                @endif
                <div class="senryu-meta mt-2">
                    @if (Auth::id() === $senryu->user_id)
                        <a href="{{ route('senryus.edit', $senryu->id) }}" class="text-blue-500 hover:underline">{{ $senryu->user_name }}</a>
                    @else
                        <span>{{ $senryu->user_name }}</span>
                    @endif

                    <!-- <span class="iine-btn" data-id="{{ $senryu->id }}">
                        {{ $senryu->iine > 0 ? '❤️' : '♡' }} {{ $senryu->iine }}
                    </span> -->
                    <form action="{{ route('senryu.incrementIine', ['id' => $senryu->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="iine-btn bg-white-500 text-green-900 p-2 rounded">❤️ {{ $senryu->iine }}</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <footer class="mt-10">
        <p>© 2024 川柳アプリ</p>
    </footer>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.iine-btn').forEach(button => {
        button.addEventListener('click', function () {
            const senryuId = this.getAttribute('data-id');

            fetch(`/senryus/${senryuId}/iine`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data && typeof data.iine !== 'undefined') {
                    // いいね数に基づいてアイコンを更新
                    const heartIcon = data.iine > 0 ? '❤️' : '♡';
                    this.innerHTML = `${heartIcon} ${data.iine}`;
                } else {
                    console.error('Error: Invalid data format');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>


</body>
</html>
