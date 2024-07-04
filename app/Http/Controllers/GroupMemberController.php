<?php
namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Session;

class GroupMemberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'member_email' => 'required|email',
        ]);

        $group = Group::where('creator_user', Auth::id())->first();
        $user = User::where('email', $request->member_email)->first();

        if (!$user) {
            // ユーザーが存在しない場合、セッションにリダイレクト先を保存し、登録ページにリダイレクト
            Session::put('redirect_after_register', route('groups.create'));
            return redirect()->route('register.user')->with('email', $request->member_email);
        }

        $member = new GroupMember();
        $member->group_id = $group->id;
        $member->user_id = $user->id;
        $member->save();

        return redirect()->route('groups.create')->with('success', 'Member added successfully');
    }

    public function edit(GroupMember $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, GroupMember $member)
    {
        $request->validate([
            'member_email' => 'required|email|unique:users,email,' . $member->user_id,
        ]);

        $user = User::find($member->user_id);
        $user->email = $request->member_email;
        $user->save();

        return redirect()->route('groups.create')->with('success', 'Member updated successfully');
    }

    public function destroy(GroupMember $member)
    {
        $member->delete();

        return redirect()->route('groups.create')->with('success', 'Member deleted successfully');
    }
}
