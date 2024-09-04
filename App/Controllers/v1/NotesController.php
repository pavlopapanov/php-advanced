<?php

namespace App\Controllers\v1;

use App\Controllers\BaseApiController;
use App\Enums\Http\Status;
use App\Enums\SQL;
use App\Models\Note;
use App\Validators\FolderValidator;
use App\Validators\Notes\CreateNoteValidator;
use App\Validators\Notes\UpdateNoteValidator;

class NotesController extends BaseApiController
{
    public function index(): array
    {
        $notes = Note::where('user_id', value: authId())->get();

        return $this->response(Status::OK, $notes);
    }

    public function show(int $id): array
    {
        return $this->response(Status::OK, Note::find($id)->toArray());
    }

    public function store(): array
    {
        $fields = requestBody();

        if (CreateNoteValidator::validate($fields) && $note = Note::createAndReturn([
                ...$fields,
                'user_id' => authId()
            ])) {
            return $this->response(Status::OK, $note->toArray());
        }

        return $this->response(Status::UNPROCESSABLE_ENTITY, $fields, CreateNoteValidator::getErrors());
    }

    public function update(int $id): array
    {
        $fields = array_merge(
            $this->model->toArray(),
            requestBody(),
            ['updated_at' => date('Y-m-d H:i:s')]
        );

        if (UpdateNoteValidator::validate($fields) && $note = $this->model->update($fields)) {
            return $this->response(Status::OK, $note->toArray());
        }

        return $this->response(Status::UNPROCESSABLE_ENTITY, $fields, UpdateNoteValidator::getErrors());
    }

    public function delete(int $id): array
    {
        $result = Note::delete($id);

        if (!$result) {
            return $this->response(Status::UNPROCESSABLE_ENTITY, [], [
                'message' => 'Something went wrong'
            ]);
        }

        return $this->response(Status::OK, $this->model->toArray());
    }

    protected function getModelClass(): string
    {
        return Note::class;
    }
}