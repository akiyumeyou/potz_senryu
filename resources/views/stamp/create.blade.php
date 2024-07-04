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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('preview-canvas');
            const ctx = canvas.getContext('2d');
            const imageInput = document.getElementById('image');
            const dropArea = document.getElementById('drop-area');
            const fileNameContainer = document.getElementById('file-name');
            let img = null;
            let originalFileName = '';

            // 画像ファイルが選択された時の処理
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    originalFileName = file.name.split('.').slice(0, -1).join('.');
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        img = new Image();
                        img.onload = function() {
                            // 画像を320x440ピクセルにリサイズして描画
                            canvas.width = 320;
                            canvas.height = 440;
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                    fileNameContainer.textContent = "選択されたファイル: " + file.name;
                } else {
                    fileNameContainer.textContent = "選択されたファイルは画像ではありません。";
                }
            });

            // ドラッグアンドドロップイベントの設定
            ['dragover', 'dragenter', 'dragleave', 'dragend', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    if (['dragover', 'dragenter'].includes(eventName)) {
                        dropArea.classList.add('active');
                    } else {
                        dropArea.classList.remove('active');
                    }

                    if (eventName === 'drop' && e.dataTransfer.files.length) {
                        imageInput.files = e.dataTransfer.files;
                        const event = new Event('change');
                        imageInput.dispatchEvent(event);
                    }
                }, false);
            });

            // クリックでファイル選択
            dropArea.addEventListener('click', function() {
                imageInput.click();
            });

            // テキスト反映ボタンが押された時の処理
            document.getElementById('apply-text').addEventListener('click', function() {
                if (!img) {
                    alert("先に画像を選択してください。");
                    return;
                }

                const text = document.getElementById('text-overlay').value;
                const color = document.getElementById('text-color').value;
                const position = document.getElementById('text-position').value;
                const size = document.getElementById('text-size').value;

                ctx.clearRect(0, 0, canvas.width, canvas.height); // キャンバスをクリア
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height); // 再度画像を描画

                ctx.font = `${size}px sans-serif`;
                ctx.fillStyle = color;
                ctx.textAlign = 'center';
                const x = canvas.width / 2;
                const y = calculateYPosition(canvas, position, size);
                ctx.fillText(text, x, y);
            });

            // テキスト位置を計算する関数
            function calculateYPosition(canvas, position, size) {
                const height = canvas.height;
                switch (position) {
                    case "top":
                        return 20 + parseInt(size);  // テキストサイズを考慮したオフセットを追加
                    case "center":
                        return (height / 2) + (parseInt(size) / 2);  // 中央に配置するための調整
                    case "bottom":
                        return height - 20;  // 下部に配置し、オフセットを引く
                    default:
                        return 20 + parseInt(size);
                }
            }

            // フォームの送信処理
            document.getElementById('stamp-form').addEventListener('submit', function(e) {
                e.preventDefault();

                if (!img) {
                    alert("先に画像を選択してください。");
                    return;
                }

                const dataURL = canvas.toDataURL('image/png');
                const binary = atob(dataURL.split(',')[1]);
                const array = [];
                for (let i = 0; i < binary.length; i++) {
                    array.push(binary.charCodeAt(i));
                }
                const file = new Blob([new Uint8Array(array)], { type: 'image/png' });
                const formData = new FormData(this);
                formData.append('image', file, `${originalFileName}.png`);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        alert('スタンプの作成に失敗しました。 ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('エラーが発生しました:', error);
                    alert('スタンプの作成に失敗しました。 ' + error.message);
                });
            });
        });
    </script>
</x-app-layout>
