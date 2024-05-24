<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規川柳作成</title>
    <style>
        /* 指定されたCSSをここに貼り付けます */
        body {
            font-size: 20px;
            background-color: #FFFAF0; /* 薄いオレンジ色 */
            margin: 0;
            padding-top: 80px;
            padding-bottom: 60px;
        }

        .senryu-container {
            display: flex;
            flex-direction: column; /* スマホでは縦並び */
            align-items: center;
            text-align: center;
        }

        .senryu-input {
            width: 100%; /* 入力枠を大きくする */
            padding: 10px; /* 内側の余白を増やす */
            margin-bottom: 10px; /* 下側の余白を増やす */
            box-sizing: border-box; /* paddingを含めたサイズでwidthを計算 */
            font-size: 38px;
            writing-mode: vertical-rl;
            text-orientation: upright;
        }

        #drop-area {
            width: 80%; /* ドロップエリアを少し小さくする */
            height: 30%;
            margin: auto; /* 中央揃え */
            padding: 10px;
            font-size: 26px;
            border: 2px dashed #f2c487; /* 点線のスタイル */
            text-align: center;
        }

        #drop-area:hover {
            background-color: #e9b013;
        }

        .file-input-label {
            color: blue;
            text-decoration: underline;
        }

        #file-name {
            margin-top: 10px;
        }

        .toukou_btn {
            background-color: green;
            font-size: 30px; /* フォントサイズを大きく */
            color: rgb(241, 249, 243);
            padding: 20px 20px; /* スマートフォンでタップしやすいサイズに */
            border-radius: 5px;
            display: block; /* ボタンをブロックレベル要素として扱う */
            margin: 0 auto; /* 左右中央揃え */
            cursor: pointer;
        }

        .toukou_btn:hover {
            background-color: #e9b013; /* ホバー色を変更 */
        }

        @media (max-width: 768px) {
            .senryu-text, .iine {
                font-size: 36px;
            }
            .fieldset {
                max-width: 100%; /* コンテンツの最大幅を制限 */
                margin: auto; /* 中央寄せ */
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let dropArea = document.getElementById('drop-area');
            let fileNameDisplay = document.getElementById('file-name');

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false)
                document.body.addEventListener(eventName, preventDefaults, false)
            });

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false)
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false)
            });

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight(e) {
                dropArea.classList.add('highlight');
            }

            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                handleFiles(files);
            }

            function handleFiles(files) {
                files = [...files];
                files.forEach(uploadFile);
                fileNameDisplay.innerText = files.map(file => file.name).join(', ');
            }

            function uploadFile(file) {
                let url = 'YOUR_UPLOAD_URL';
                let formData = new FormData();
                formData.append('file', file);

                fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(() => { /* handle success */ })
                .catch(() => { /* handle error */ });
            }
        });
    </script>
</head>
<body>
    <header>
        <h1>新規川柳作成</h1>
        <nav>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>
            <x-nav-link :href="route('senryus.index')" :active="request()->routeIs('senryus.index')">
                {{ __('シルバー川柳') }}
            </x-nav-link>
            <!-- ログアウトなどの他のナビゲーションリンクもここに追加できます -->
        </nav>
    </header>

    <div class="senryu-container">
        <form action="{{ route('senryus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
            <label for="theme">テーマ:</label>
            <input type="text" name="theme" id="theme" class="senryu-input"><br>
            <label for="s_text1">川柳テキスト1:</label>
            <input type="text" name="s_text1" id="s_text1" class="senryu-input"><br>
            <label for="s_text2">川柳テキスト2:</label>
            <input type="text" name="s_text2" id="s_text2" class="senryu-input"><br>
            <label for="s_text3">川柳テキスト3:</label>
            <input type="text" name="s_text3" id="s_text3" class="senryu-input"><br>
            
            <div id="drop-area">
                <p>ここにファイルをドラッグ＆ドロップ</p>
                <input type="file" name="img_path" id="fileElem" class="file-input" accept="image/*,video/*" style="display:none" onchange="handleFiles(this.files)">
                <label class="file-input-label" for="fileElem">またはファイルを選択</label>
                <p id="file-name"></p>
            </div>

            <button type="submit" class="toukou_btn">投稿する</button>
        </form>
    </div>

    <footer>
        <p>© 2024 川柳アプリ</p>
    </footer>
</body>
</html>

