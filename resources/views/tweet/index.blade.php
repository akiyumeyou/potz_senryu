<x-app-layout>
    <style>
        .stamp-gallery-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            background-color: #f0f0f0; /* スタンプ表示エリアの背景色 */
            padding: 10px;
        }
        .stamp-gallery {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
        }
        .stamp-image {
            flex: 0 0 auto;
            width: 16.66%; /* 100% / 6 = 16.66% */
            cursor: pointer;
            border-radius: 10px;
        }
        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            z-index: 1000;
        }
        .left-arrow {
            left: 0;
        }
        .right-arrow {
            right: 0;
        }
        @media (min-width: 768px) {
            .stamp-image {
                width: 8.33%; /* 100% / 12 = 8.33% for larger screens */
            }
        }
        .chat-message-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 10px;
            max-width: 90%; /* 横サイズ画面の90% */
            word-break: break-word;
        }
        .chat-message-container.user {
            align-items: flex-end;
            margin-left: auto;
        }
        .chat-message {
            padding: 3px;
            border-radius: 10px;
            position: relative;
            font-size: 20px;
            margin: 1px;
        }
        .chat-message.user {
            background-color: #cff1bf;
            text-align: right;
        }
        .chat-message.other {
            background-color: #ffffff;
            text-align: left;
        }
        .chat-username {
            font-size: 0.8em;
            margin-bottom: 2px;
        }
        .chat-timestamp {
            font-size: 0.8em;
            margin-top: 5px;
            text-align: right;
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 70px);
            overflow: hidden;
        }
        #message-list {
            height: 98%; /* 画面の高さの98%に設定 */
            overflow-y: scroll; /* 常にスクロールバーを表示 */
            padding: 2px;
            flex-grow: 1;
            background-color: #f9f5e7; /* メッセージ表示エリアの背景色 */
        }
        .input-area {
            padding: 10px;
            background: #f0f0f0;
        }
        .control-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }
        .control-buttons a {
            flex: 1;
            text-align: center;
            padding: 15px;
            background: #1c3faa;
            color: white;
            border-radius: 5px;
            margin: 5px;
            font-size: 18px;
            font-weight: bold;
        }
        .edit-icon {
            display: inline-block;
            margin-left: 10px;
        }
        @media (max-width: 768px) {
            .chat-message {
                font-size: 20px;
                padding: 1px;
            }
        }
    </style>
    <div class="py-12">
        <!-- <div class="max-w-7xl mx-auto px-6 lg:px-8"> -->
            <div class="chat-container">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6" style="height: 60%; background-color: #f9f5e7;">
                    <ul id="message-list" class="space-y-4">
                        @foreach ($messages as $tweet)
                            <li class="chat-message-container {{ Auth::id() == $tweet->user_id ? 'user' : 'other' }}">
                                @if (Auth::id() != $tweet->user_id)
                                    <span class="chat-username">{{ $tweet->user_name }}</span>
                                @endif
                                <div class="p-2 border rounded-lg chat-message {{ Auth::id() == $tweet->user_id ? 'user' : 'other' }}">
                                    <div>
                                        @if ($tweet->message_type == 'image')
                                            <img src="{{ asset($tweet->content) }}" alt="Image" class="max-w-full h-auto rounded-lg">
                                        @elseif ($tweet->message_type == 'video')
                                            <video controls class="max-w-full h-auto rounded-lg">
                                                <source src="{{ asset($tweet->content) }}" type="video/mp4">
                                            </video>
                                        @elseif ($tweet->message_type == 'link')
                                            <a href="{{ $tweet->content }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $tweet->content }}</a>
                                        @elseif ($tweet->message_type == 'stamp')
                                            <img src="{{ asset($tweet->content) }}" alt="Stamp" class="max-w-full h-auto rounded-lg">
                                        @else
                                            <p>{{ $tweet->content }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="chat-timestamp">
                                    {{ $tweet->created_at->format('Y/m/d H:i') }}
                                    @if(Auth::check() && Auth::id() == $tweet->user_id)
                                        <a href="{{ route('tweets.edit', $tweet->id) }}" class="edit-icon">
                                            <img src="{{ asset('img/hensyu.png') }}" alt="Edit" class="w-5 h-5">
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <form id="tweet-form" method="POST" action="{{ route('tweets.store') }}" enctype="multipart/form-data" class="input-area">
                    @csrf
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('img/maiku.png') }}" alt="Mic" class="w-12 h-12"><br>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="user_name" value="{{ Auth::user()->name }}">
                        <input type="text" name="content" id="content" class="form-input flex-1 border-gray-300 rounded-lg" placeholder="ここに入力...">
                        <input type="hidden" name="message_type" id="message_type" value="text">
                        <input type="hidden" name="stamp" id="stamp">

                        <input type="file" name="image" accept="image/*" id="image" style="display: none;">
                        <label for="image"><img src="{{ asset('img/picture.png') }}" alt="Upload Image" class="w-10 h-10 cursor-pointer"></label>
                        <button id="send" type="submit"><img src="{{ asset('img/btn_send.png') }}" width="50" height="50"></button>
                    </div>
                </form>

                <div class="stamp-gallery-container">
                    <button class="arrow left-arrow" onclick="scrollStampGalleryLeft()">&#60;</button>
                    <div id="stamp-gallery" class="stamp-gallery mt-4">
                        @foreach ($images as $image)
                            <img src="{{ asset($image->image) }}" alt="Image" class="stamp-image" onclick="selectStamp('{{ asset($image->image) }}')">
                        @endforeach
                    </div>
                    <button class="arrow right-arrow" onclick="scrollStampGalleryRight()">&#62;</button>
                </div>

                <div class="control-buttons">
                    <a href="{{ route('stamp.create') }}">
                        スタンプ作成
                    </a>
                    <a href="{{ route('stamp.index') }}">
                        スタンプ一覧
                    </a>
                </div>
            </div>
        <!-- </div> -->
    </div>

    <script>
        function selectStamp(imageUrl) {
            document.getElementById('content').value = imageUrl;
            document.getElementById('message_type').value = 'stamp';
            document.getElementById('stamp').value = imageUrl;
            document.getElementById('tweet-form').submit();
            playSound(); // 音を鳴らす
        }

        function playSound() {
            var audio = new Audio('/sound/syupon01.mp3');
            audio.play().then(() => {
                console.log("Audio played successfully!");
            }).catch(error => {
                console.error("Error playing the audio:", error);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            var messageList = document.getElementById('message-list');
            messageList.scrollTop = messageList.scrollHeight;
        });

        function scrollStampGalleryLeft() {
            document.getElementById('stamp-gallery').scrollBy({
                left: -300,
                behavior: 'smooth'
            });
        }

        function scrollStampGalleryRight() {
            document.getElementById('stamp-gallery').scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        }
    </script>

</x-app-layout>
