<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
            'relationship' => 'nullable|string|max:255',
        ]);

        $groupMember = GroupMember::create([
            'group_id' => $request->group_id,
            'user_id' => $request->user_id,
            'relationship' => $request->relationship,
        ]);

        return response()->json([
            'message' => 'Group member successfully added',
            'groupMember' => $groupMember
        ], 201);
    }
}
