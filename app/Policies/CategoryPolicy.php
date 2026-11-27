<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return $this->belongsToStore($user, $category);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Category $category): bool
    {
        return $this->belongsToStore($user, $category);
    }

    public function delete(User $user, Category $category): bool
    {
        return $this->belongsToStore($user, $category);
    }

    private function belongsToStore(User $user, Category $category): bool
    {
        return $user->stores()
            ->whereKey($category->store_id)
            ->wherePivot('status', 'active')
            ->exists();
    }
}