<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Family Tail Chat　メンバー登録') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">@if(isset($group)) グループ管理 @else Create Group @endif</h1>
        <form action="{{ isset($group) ? route('groups.update', $group->id) : route('groups.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @if(isset($group))
                @method('PUT')
            @endif
            <div class="mb-4">
                <label for="groupname" class="block text-gray-700 text-sm font-bold mb-2">グループの名前</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="groupname" name="groupname" value="{{ $group->groupname ?? '' }}" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                @if(isset($group)) グループ名変更 @else Create Group @endif
            </button>
        </form>

        <div class="container mt-8">
            <h2 class="text-xl font-bold mb-4">グループメンバー</h2>
            <form action="{{ route('members.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <div class="mb-4">
                    <label for="member_email" class="block text-gray-700 text-sm font-bold mb-2">登録するメンバーのメールアドレス</label>
                    <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_email" name="member_email" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">登録</button>
            </form>

            <ul class="list-group mt-4 space-y-2">
                @foreach($group->members ?? [] as $member)
                    <li class="bg-white shadow-md rounded p-4 flex justify-between items-center">
                        <span>{{ $member->user->name }} ({{ $member->user->email }})</span>
                        <div class="flex space-x-2">

                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">削除</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
