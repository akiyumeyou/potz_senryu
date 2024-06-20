<x-app-layout>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シニア動画交流</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .sort-text {
            text-decoration: underline;
            cursor: pointer;
        }
        #displayName {
            margin-left: auto;
            padding: 10px;
        }
        #aside {
            width: 22%;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
            box-sizing: border-box;
        }
        #flex {
            display: flex;
            flex-direction: column;
        }
        #output {
            width: 78%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }
        button#send {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        div#output p {
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
        }
        .video-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
    </style>
    <script>
        function extractVideoID(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const iframes = document.querySelectorAll('iframe[data-youtube]');
            iframes.forEach(iframe => {
                const videoID = extractVideoID(iframe.dataset.youtube);
                if (videoID) {
                    iframe.src = `https://www.youtube.com/embed/${videoID}`;
                }
            });
        });
    </script>
</head>
<body class="bg-orange-100">

<header class="text-green-800 p-4 flex items-center">
    <button id="sortBtnDate" class="bg-green-800 text-white p-2 m-2">新着順</button>
    <button id="sortBtnLikes" class="bg-green-800 text-white p-2 m-2">いいね</button>
    <a href="#aside" class="ml-auto text-green-800 underline">投稿</a>
</header>

<main class="flex flex-wrap justify-center p-4">
    <div id="output" class="w-full flex flex-wrap justify-between gap-4">
        @foreach ($videos as $video)
        <div class="video-container bg-white shadow rounded p-4 w-full max-w-lg" id="message-{{ $video->id }}">
            <iframe data-youtube="{{ $video->youtube_link }}" frameborder="0" allowfullscreen class="w-full h-48"></iframe>
            <div class="video-info p-2">
                <p>{{ $video->comment }}</p>
                <div class="btn-group flex justify-between mt-2">
                    <form action="{{ route('youtube.updateLikes', $video->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="like-btn bg-white-100 text-green-900 p-2 rounded">❤️ {{ $video->like_count }}</button>
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

</body>
</html>
</x-app-layout>
