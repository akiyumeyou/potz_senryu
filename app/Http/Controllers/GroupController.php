<?php
namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::where('creator_user', Auth::id())->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $group = Group::where('creator_user', Auth::id())->first();
        return view('groups.create', compact('group'));
    }

    public function store(Request $request)
    {
        $request->validate(['groupname' => 'required|string|max:255']);

        $group = new Group();
        $group->groupname = $request->groupname;
        $group->creator_user = Auth::id();
        $group->save();

        return redirect()->route('groups.create')->with('success', 'Group created successfully');
    }

    public function update(Request $request, Group $group)
    {
        $request->validate(['groupname' => 'required|string|max:255']);

        $group->groupname = $request->groupname;
        $group->save();

        return redirect()->route('groups.create')->with('success', 'Group updated successfully');
    }

    public function edit($id)
    {
        $group = Group::with('members.user')->findOrFail($id);
        return view('groups.edit', compact('group'));
    }

}
