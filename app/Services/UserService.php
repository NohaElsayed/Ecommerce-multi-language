<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ImageUploadTrait;

    /**
     * ✅ جلب جميع المستخدمين مع الترقيم
     */
    public function getAllUsers(int $perPage = 15)
    {
        return User::with('roles')->latest()->paginate($perPage);
    }

    /**
     * إنشاء مستخدم جديد
     */
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['avatar'])) {
            $data['avatar'] = $this->uploadImage($data['avatar'], 'users');
        }

        $user = User::create($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        } else {
            $user->assignRole('user');
        }

        return $user;
    }

    /**
     * تحديث بيانات مستخدم
     */
    public function update(User $user, array $data): User
    {
        // إذا لم يتم إدخال كلمة مرور جديدة، لا تقم بتحديثها
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['avatar'])) {
            $data['avatar'] = $this->updateImage($data['avatar'], $user->avatar, 'users');
        }

        $user->update($data);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return $user->fresh();
    }

    /**
     * حذف مستخدم
     */
    public function delete(User $user): bool
    {
        $this->deleteImage($user->avatar);
        return $user->delete();
    }

    /**
     * تعيين أدوار للمستخدم
     */
    public function assignRole(User $user, array $roles): User
    {
        $user->syncRoles($roles);
        return $user;
    }
}
