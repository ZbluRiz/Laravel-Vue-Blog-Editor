<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function create(User $user): bool
    {
        // Any authenticated user (student, teacher, admin) can comment
        return in_array($user->role, ['admin', 'teacher', 'student']);
    }

    public function delete(User $user, Comment $comment): bool
    {
        // Admin can delete anything, otherwise owner can delete own comment
        if ($user->role === 'admin') {
            return true;
        }

        return $comment->user_id === $user->id;
    }
}


