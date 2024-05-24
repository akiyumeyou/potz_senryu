<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>川柳一覧</title>
    <style>
        body {
            font-size: 20px;
            background-color: #FFFAF0; /* 薄いオレンジ色 */
            margin: 0;
            padding-top: 80px;
            padding-bottom: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .senryu-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            width: 90%;
            margin-top: 20px;
        }

        .senryu-item {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .senryu-text {
            writing-mode: vertical-rl;
            text-orientation: upright;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .senryu-image {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin-bottom: 10px;
        }

        .senryu-meta {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 10px;
        }

        .senryu-meta span {
            font-size: 18px;
        }

        .senryu-meta .iine-btn {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .senryu-actions {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
        }

        .senryu-actions a, .senryu-actions form {
            margin-right: 10px;
        }

        .senryu-actions form {
            display: inline;
        }

        @media (max-width: 768px) {
            .senryu-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>シルバー川柳一覧</h1>
        <nav>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('最初のページへ　') }}
            </x-nav-link>
            <x-nav-link :href="route('senryus.create')" :active="request()->routeIs('senryus.create')">
                {{ __('新規川柳作成') }}
            </x-nav-link>
        </nav>
    </header>

    <div class="senryu-container">
        @foreach ($senryus as $senryu)
            <div class="senryu-item">
                <div class="senryu-text">
                    <p>{{ $senryu->s_text1 }}</p>
                    <p>{{ $senryu->s_text2 }}</p>
                    <p>{{ $senryu->s_text3 }}</p>
                </div>
                @if ($senryu->img_path)
                    <img src="{{ $senryu->img_path }}" alt="senryu image" class="senryu-image">
                @endif
                <div class="senryu-meta">
                    <span>{{ $senryu->user_name }}</span>
                    <span class="iine-btn">{{ $senryu->iine }} いいね</span>
                </div>
                @if ($senryu->user_id == Auth::id())
                    <div class="senryu-actions">
                        <a href="{{ route('senryus.edit', $senryu->id) }}">編集</a>
                        <form action="{{ route('senryus.destroy', $senryu->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <footer>
        <p>© 2024 川柳アプリ</p>
    </footer>
</body>
</html>

