<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Famiry Tail Chat') }}
        </h2>
    </x-slot>
    <style>
        .stamp-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-start;
        }
        .stamp-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
        }
        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }
        .chat-message.user {
            text-align: right;
            background-color: #cff1bf;
        }
        .chat-message.other {
            text-align: left;
            background-color: #f9f5e7;
        }
        .chat-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 70px);
            overflow: hidden;
        }
        #message-list {
        height: 50vh; /* 画面の高さの50%に設定 */
        overflow-y: scroll; /* 常にスクロールバーを表示 */
        padding: 10px;
        flex-grow: 1;
        }

        .input-area {
            padding: 10px;
            background: #f0f0f0;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="chat-container">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <ul id="message-list" class="space-y-4">
                        @foreach ($messages as $tweet)
                            <li class="p-2 border rounded-lg chat-message {{ Auth::id() == $tweet->user_id ? 'user' : 'other' }}">    <strong>{{ $tweet->user_name }}:</strong>
                                <div>
                                    @if ($tweet->message_type == 'image')
                                        <img src="{{ asset($tweet->content) }}" alt="Image" class="max-w-full h-auto">
                                    @elseif ($tweet->message_type == 'video')
                                        <video controls class="max-w-full h-auto">
                                            <source src="{{ asset($tweet->content) }}" type="video/mp4">
                                        </video>
                                    @elseif ($tweet->message_type == 'link')
                                        <a href="{{ $tweet->content }}" target="_blank" class="text-blue-500 hover:text-blue-700">{{ $tweet->content }}</a>
                                    @elseif ($tweet->message_type == 'stamp')
                                        <img src="{{ asset($tweet->content) }}" alt="Stamp" class="max-w-full h-auto">
                                    @else
                                        <p>{{ $tweet->content }}</p>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    @if(Auth::check() && Auth::id() == $tweet->user_id)
                                        <a href="{{ route('tweets.edit', $tweet->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-2 px-4 rounded">
                                            編集
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>


                <form id="tweet-form" method="POST" action="{{ route('tweets.store') }}" enctype="multipart/form-data">
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

                <div id="stamp-gallery" class="stamp-gallery mt-4">
                    @foreach ($images as $image)
                        <img src="{{ asset($image->image) }}" alt="Image" class="stamp-image" onclick="selectStamp('{{ asset($image->image) }}')">
                    @endforeach
                </div>
                <div class="flex mt-4 space-x-2">
                    <a href="{{ route('stamp.create') }}" class="flex-1 text-center py-2 bg-blue-900 text-white rounded-lg shadow-lg">
                        スタンプ作成
                    </a>
                    <a href="{{ route('stamp.index') }}" class="flex-1 text-center py-2 bg-blue-900 text-white rounded-lg shadow-lg">
                        スタンプ一覧
                    </a>
                </div>
            </div>
        </div>
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


        </script>

</x-app-layout>
