<?php

namespace App\Models;

use Core\Model;

class Note extends Model
{
    protected static string|null $tableName = 'notes';
    public string $title, $created_at, $updated_at;
    public int $user_id, $folder_id, $pinned, $completed;
    public ?string $content;
}