<?php

namespace App\Validators\Notes;

use App\Enums\SQL;
use App\Models\Note;
use App\Validators\Notes\Base;

class UpdateNoteValidator extends Base
{
    protected static int $noteId;

    public static function validate(array $fields = []): bool
    {
        static::$noteId = $fields['id'];

        $result = [
            parent::validate($fields),
            empty($fields['folder_id']) || static::validateFolderId($fields['folder_id']),
            !static::checkTitleOnDuplicate($fields['title'], $fields['folder_id']),
            static::isBoolean($fields, 'pinned'),
            static::isBoolean($fields, 'completed')
        ];

        return !in_array(false, $result);
    }

    protected static function checkTitleOnDuplicate(string $title, int $folderId): bool
    {
        $result = Note::where('user_id', value: authId())
            ->and('folder_id', $folderId)
            ->and('title', $title)
            ->and('id', SQL::NOT_EQUAL, static::$noteId)
            ->exists();

        if ($result) {
            static::setError('title', "The note with name {$title} already exists");
        }

        return $result;
    }
}