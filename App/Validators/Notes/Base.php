<?php

namespace App\Validators\Notes;

use App\Models\Folder;
use App\Models\Note;
use App\Validators\BaseValidator;

class Base extends BaseValidator
{
    protected static array $skip = [
        'pinned',
        'completed',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected static array $rules = [
        'title' => '/[\w\s\(\)\-]{3,}/i',
        'content' => '/\d+/i'
    ];

    protected static array $errors = [
      'title' => 'Title should contain only letters, numbers and underscores. Title must be at least 3 characters long.',
      'folder_id' => '{folder_id} should be exists and has type integer'
    ];

    protected static function isBoolean(array $fields, string $key): bool
    {
        if (empty($fields[$key])) {
            return true;
        }

        $result = is_bool($fields[$key]) || $fields[$key] === '1';

        if (!$result) {
            static::setError($key, "{$fields[$key]} is not a boolean type");
        }

        return $result;
    }

    protected static function validateFolderId(int $folderId): bool
    {
        $folder = Folder::find($folderId);

        if ($folder) {
            return is_null($folder->user_id) || $folder->user_id === authId();
        }

        return false;
    }

    protected static function checkTitleOnDuplicate(string $title, int $folderId): bool
    {
        $result = Note::where('user_id', value: authId())
            ->and('folder_id', $folderId)
            ->and('title', $title)
            ->exists();

        if ($result) {
            static::setError($title, "The note with name {$title} already exists in folder = {$folderId}");
        }

        return $result;
    }
}