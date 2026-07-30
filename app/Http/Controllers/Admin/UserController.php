<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    /**
     * عرض جميع المستخدمين
     */
    public function index()
    {
        // ✅ استدعاء الدالة الصحيحة
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', compact('users'));
    }

    /**
     * عرض نموذج إنشاء مستخدم
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * حفظ مستخدم جديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'roles' => 'nullable|array',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data['status'] = $request->has('status') ? 'active' : 'inactive';

        $this->userService->create($data);

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.created'));
    }

    /**
     * عرض نموذج تعديل مستخدم
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * تحديث مستخدم
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048',
            'roles' => 'nullable|array',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data['status'] = $request->has('status') ? 'active' : 'inactive';

        $this->userService->update($user, $data);

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.updated'));
    }

    /**
     * حذف مستخدم
     */
    public function destroy(User $user)
    {
        // منع حذف السوبر أدمن
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'لا يمكن حذف حساب السوبر أدمن');
        }

        $this->userService->delete($user);

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.deleted'));
    }
}
