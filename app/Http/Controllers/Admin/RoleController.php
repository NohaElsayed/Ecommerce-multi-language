<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * عرض جميع الأدوار
     */
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * عرض نموذج إنشاء دور
     */
    public function create()
    {
        // تجميع الصلاحيات حسب المجموعة (module)
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * حفظ دور جديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.created'));
    }

    /**
     * عرض نموذج تعديل دور
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('.', $permission->name)[0];
        });
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * تحديث دور
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.updated'));
    }

    /**
     * حذف دور
     */
    public function destroy(Role $role)
    {
        // منع حذف الأدوار المهمة
        if (in_array($role->name, ['super-admin', 'admin'])) {
            return back()->with('error', 'لا يمكن حذف هذا الدور');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', __('admin.deleted'));
    }
}
