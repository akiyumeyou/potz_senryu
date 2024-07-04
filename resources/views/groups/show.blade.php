@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $group->name }}</h1>
    <h2>Members</h2>
    <ul>
        @foreach($members as $member)
        <li>{{ $member->name }} ({{ $member->email }})</li>
        @endforeach
    </ul>

    <h2>Add Member</h2>
    <form action="{{ route('groups.addMember', $group) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Member Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Member</button>
    </form>
</div>
@endsection
