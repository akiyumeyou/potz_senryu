<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショートカット作成ガイド</title>
</head>
<body>
    <h1>ホーム画面/デスクトップにショートカットを追加</h1>
    <p>このウェブサイトをホーム画面またはデスクトップに追加する手順は以下の通りです。</p>

    <h2>スマートフォンの場合（Android）</h2>
    <ol>
        <li>QRコードをスキャンしてこのページを開きます。</li>
        <li>ブラウザのメニューから「ホーム画面に追加」を選択します。</li>
    </ol>

    <h2>パソコンの場合</h2>
    <ol>
        <li>ブラウザでこのページを開きます。</li>
        <li>以下の手順に従ってショートカットをデスクトップに作成します。</li>
        <ul>
            <li>Chrome: 右上のメニュー → その他のツール → ショートカットを作成</li>
            <li>Firefox: URLバーのロックアイコンをデスクトップにドラッグ＆ドロップ</li>
            <li>Edge: 右上のメニュー → その他のツール → デスクトップに追加</li>
        </ul>
    </ol>

    <button id="add-to-home">ホーム画面に追加</button>

    <script>
        document.getElementById('add-to-home').addEventListener('click', function() {
            if (window.matchMedia('(display-mode: standalone)').matches) {
                alert('このアプリはすでにホーム画面に追加されています。');
            } else {
                alert('ブラウザのメニューから「ホーム画面に追加」を選択してください。');
            }
        });
    </script>
</body>
</html>
