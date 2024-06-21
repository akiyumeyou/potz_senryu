<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="mt-4">
                <a href="{{ route('tweets.index') }}" class="text-blue-500 hover:underline">チャットに戻る</a>
            </nav>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="stamp-form" action="{{ route('stamp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="text-overlay" class="block text-xl font-medium text-gray-700">テキスト:</label>
                        <input type="text" id="text-overlay" name="text_overlay" class="mt-1 block w-full">

                        <label for="text-color" class="block text-xl font-medium text-gray-700">テキスト色:</label>
                        <select name="text_color" id="text-color" class="mt-1 block w-full">
                            <option value="white">白</option>
                            <option value="black">黒</option>
                            <option value="pink">ピンク</option>
                            <option value="green">緑</option>
                            <option value="navy">紺</option>
                        </select>

                        <label for="text-position" class="block text-xl font-medium text-gray-700">テキスト位置:</label>
                        <select name="text_position" id="text-position" class="mt-1 block w-full">
                            <option value="top">上</option>
                            <option value="center">中央</option>
                            <option value="bottom">下</option>
                        </select>

                        <label for="text-size" class="block text-xl font-medium text-gray-700">テキストサイズ:</label>
                        <select name="text_size" id="text-size" class="mt-1 block w-full">
                            <option value="36">小</option>
                            <option value="48">中</option>
                            <option value="62">大</option>
                        </select>

                        <button type="button" id="apply-text" class="mt-4 bg-blue-900 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded">テキスト反映</button>

                        <label for="image" class="block text-sm font-medium text-gray-700 mt-4">画像:</label>
                        <div id="drop-area" class="border-dashed border-2 border-gray-300 py-4 text-center">
                            <p>画像をドラッグ＆ドロップまたは<span class="file-input-label cursor-pointer text-blue-500">クリック</span>して選択</p>
                            <input type="file" id="image" name="image" hidden>
                            <div id="file-name" class="mt-2"></div>
                        </div>

                        <div id="image-container" style="position: relative; width: 320px; height: 445px; margin: auto;" class="mt-4">
                            <canvas id="preview-canvas" width="320" height="445"></canvas>
                        </div>

                        <input type="submit" value="保存" class="mt-4 bg-blue-900 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded">
                    </div>
                </form>
            </div>
        </div>
        <footer id="footer" class="w-full bg-green-800 text-white text-center p-2 fixed bottom-0">
            <img src="{{ asset('img/logo.png') }}" alt="potz" class="inline-block w-8 h-8">
            <a href="https://potz.jp/" class="text-white underline">https://potz.jp/</a>
        </footer>

    </div>
    <!-- サーバーアップロード -->
    @php
    $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp
    <script type="module" src="{{ asset('build/' . $manifest['resources/js/stamp.js']['file']) }}"></script>
    <!-- @vite('resources/js/stamp.js') -->
</x-app-layout>


