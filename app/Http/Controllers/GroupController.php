<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'groupname' => 'required|string|max:255',
            'ai_flg' => 'boolean',
            'ai_userid' => 'nullable|exists:users,id',
        ]);

        $group = Group::create([
            'groupname' => $request->groupname,
            'creator_user' => Auth::id(),
            'ai_flg' => $request->ai_flg ?? false,
            'ai_userid' => $request->ai_userid,
        ]);

        return response()->json([
            'message' => 'Group successfully created',
            'group' => $group
        ], 201);
    }
        public function create()
        {
            return view('groups.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $group = Group::create([
                'name' => $request->name,
                'admin_id' => auth()->id(),
            ]);

            return redirect()->route('groups.show', $group);
        }

        public function show(Group $group)
        {
            $members = $group->members;
            return view('groups.show', compact('group', 'members'));
        }

        public function addMember(Request $request, Group $group)
        {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                // Redirect to registration form
                return redirect()->route('register')->with('email', $request->email);
            }

            $group->members()->attach($user->id);

            return redirect()->route('groups.show', $group);
        }
    }

}
