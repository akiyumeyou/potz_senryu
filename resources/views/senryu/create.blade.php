<x-app-layout>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>川柳投稿</title>
    <!-- サーバーアップロード -->
    @php
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp
    <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/senryu.css']['file']) }}">

    <!-- Scripts -->
    <script type="module" src="{{ asset('build/' . $manifest['resources/js/senryu.js']['file']) }}"></script>
    <!-- @vite(['resources/css/senryu.css', 'resources/js/senryu.js']) -->
</head>
<body>

    <div>
        @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div>{{ session('error') }}</div>
        @endif

        <form action="{{ route('senryus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="senryu-container">
                <label for="theme">テーマ:</label>
                <input type="text" name="theme" id="theme" class="senryu-input" required><br>
                <label for="s_text1">上五:</label>
                <input type="text" name="s_text1" id="s_text1" class="senryu-input" required maxlength="5"><br>
                <label for="s_text2">中七:</label>
                <input type="text" name="s_text2" id="s_text2" class="senryu-input" required maxlength="7"><br>
                <label for="s_text3">下五:</label>
                <input type="text" name="s_text3" id="s_text3" class="senryu-input" required maxlength="5"><br>
            </div>

            <div id="drop-area">
                <p>ここにファイルをドラッグ＆ドロップ</p>
                <input type="file" name="img_path" id="fileElem" class="file-input" accept="image/*,video/*" style="display:none">
                <label class="file-input-label" for="fileElem">またはファイルを選択</label>
                <p id="file-name"></p>
            </div>

            <div id="preview-container"></div>

            <button type="submit" class="toukou_btn" id="toukou-btn" style="display: none;">投稿する</button>
            <button type="button" class="reselect_btn" id="reselect-btn" style="display: none;">画像再選択</button>
        </form>
    </div>

    <footer id="footer" class="w-full bg-green-800 text-white text-center p-2 fixed bottom-0">
        <img src="{{ asset('img/logo.png') }}" alt="potz" class="inline-block w-8 h-8">
        <a href="https://potz.jp/" class="text-white underline">https://potz.jp/</a>
    </footer>
    </body>
</html>
</x-app-layout>
