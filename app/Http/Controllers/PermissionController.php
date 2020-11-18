<?php

namespace App\Http\Controllers;

use App\Ekeng\PermissionManager;
use App\Group;
use App\Http\Requests\CreatePermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $permissionManager;
    function __construct(PermissionManager $permissionManager)
    {
        $this->permissionManager = $permissionManager;
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permissions.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::pluck('name', 'id');
        return view('permissions.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePermissionRequest $request)
    {
        Permission::create($request->only(['name', 'group_id']));
        return redirect()->back()
            ->with('success', 'Permission created successfully');
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
    public function edit(Permission $permission)
    {
        $groups = Group::all();
        $all_groups = [];
        foreach ($groups as $key => $value) {
            $all_groups[$value->id] = $value->name;
        }
        $group = $permission->groups;
        return view('permissions.edit', compact('permission', 'group', 'all_groups'));
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
        if (!empty($request->input('current_group'))) {
            $update = ['name' => $request->get('name'), 'group_id' => $request->get('current_group')];
        } else {
            $update = ['name' => $request->get('name'), 'group_id' => $request->get('selected_group')];
        }
        Permission::where('id', $id)->update($update);
        return redirect()->back()
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()
            ->with('success', 'Permission deleted successfully');
    }

    public function foreach(Request $request)
    {
        return $this->permissionManager->permissions_table($request);

    }
}
