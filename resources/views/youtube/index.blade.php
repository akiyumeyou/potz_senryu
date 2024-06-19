<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シニア動画交流</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="bg-orange-100">

<header class="bg-green-200 text-green-800 p-4 flex items-center">
    <button id="sortBtnDate" class="bg-green-500 text-white p-2 m-2">新着順</button>
    <button id="sortBtnLikes" class="bg-green-500 text-white p-2 m-2">いいね</button>
    <h1 class="text-2xl m-0">POTZ動画交流のページ</h1>
    <a href="#aside" class="ml-auto text-green-800 underline">投稿</a>
    <div id="displayName" class="ml-auto p-2">ユーザー名</div>
</header>

<main class="flex flex-wrap justify-center p-4">
    <div id="output" class="w-full flex flex-wrap justify-between gap-4">
        @foreach ($videos as $video)
        <div class="video-container bg-white shadow rounded p-4 w-full max-w-lg" id="message-{{ $video->id }}">
            <iframe src="https://www.youtube.com/embed/{{ extractVideoID($video->youtube_link) }}" frameborder="0" allowfullscreen class="w-full h-48"></iframe>
            <div class="video-info p-2">
                <p>{{ $video->comment }}</p>
                <div class="btn-group flex justify-between mt-2">
                    <form action="{{ route('youtube.updateLikes', $video->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="like-btn bg-green-500 text-white p-2 rounded">いいね {{ $video->like_count }}</button>
                    </form>
                    <form action="{{ route('youtube.destroy', $video->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn bg-red-500 text-white p-2 rounded">削除</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div id="aside" class="w-full max-w-lg mt-4">
        <h2>投稿フォーム</h2>
        <form action="{{ route('youtube.store') }}" method="POST">
            @csrf
            <textarea id="text" name="comment" class="w-full p-2 mt-2 mb-4 border" placeholder="動画の説明"></textarea><br>
            <select id="category" name="category" class="w-full p-2 mb-4 border">
                <option value="support">サポート会員用</option>
                <option value="senior" selected>シニア会員用</option>
                <option value="series">シリーズ</option>
            </select><br>
            <input type="text" id="youtubeLink" name="youtube_link" class="w-full p-2 mb-4 border" placeholder="YouTubeリンクをここに貼り付け"><br>
            <button type="submit" id="send" class="bg-green-500 text-white p-2 rounded">送信</button>
        </form>
    </div>
</main>

<footer id="footer" class="w-full bg-green-800 text-white text-center p-2 fixed bottom-0">
    <img src="{{ asset('img/logo.png') }}" alt="potz" class="inline-block w-8 h-8">
    <a href="https://potz.jp/" class="text-white underline">https://potz.jp/</a>
</footer>

<script>
function extractVideoID(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}
</script>

</body>
</html>
