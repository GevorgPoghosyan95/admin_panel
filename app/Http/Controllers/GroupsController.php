<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Ekeng\Permission;
use Spatie\Permission\Models\Role;

class GroupsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:group-list|group-create|group-edit|group-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:group-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:group-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:group-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $groups = Group::orderBy('id', 'DESC')->get();
        return view('groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $group = Group::create($request->only(['name', 'route']));
        $permissions = createPermission($group->name);
        foreach ($permissions as $permission){
            $perm = Permission::create(['name'=>$permission,'group_id'=>$group->id]);
            $role = Role::where('name','Admin')->first();
            $role->givePermissionTo([$perm->name]);
        }

        return redirect()->back()
            ->with('success', 'Group created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        Group::find($id)->update($request->only(['name', 'route']));
        return redirect()->back()
            ->with('success', 'Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $permissions = createPermission($group->name);
        foreach ($permissions as $permission){
            $roles = Role::all();
            foreach($roles as $role){
                $role->revokePermissionTo($permission);
            }
        }
        $group->delete();
        return redirect()->back()
            ->with('success', 'Group deleted successfully');
    }
}
