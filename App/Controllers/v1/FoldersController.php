<?php

namespace App\Controllers\v1;

use App\Controllers\BaseApiController;
use App\Enums\Http\Status;
use App\Enums\SQL;
use App\Models\Folder;
use App\Validators\FolderValidator;

class FoldersController extends BaseApiController
{
    public function index(): array
    {
        $folders = Folder::where('user_id', value: authId())
            ->or('user_id', SQL::IS, null)
            ->get();

        return $this->response(Status::OK, $folders);
    }

    public function show(int $id): array
    {
        return $this->response(Status::OK, Folder::find($id)->toArray());
    }

    public function store(): array
    {
        $fields = requestBody();

        if (FolderValidator::validate($fields) && $folder = Folder::createAndReturn([
                ...$fields,
                'user_id' => authId()
            ])) {
            return $this->response(Status::OK, $folder->toArray());
        }

        return $this->response(Status::UNPROCESSABLE_ENTITY, $fields, FolderValidator::getErrors());
    }

    public function update(int $id): array
    {
        $fields = array_merge(
            requestBody(),
            ['updated_at' => date('Y-m-d H:i:s')]
        );

        if (FolderValidator::validate($fields) && $folder = $this->model->update($fields)) {
            return $this->response(Status::OK, $folder->toArray());
        }

        return $this->response(Status::UNPROCESSABLE_ENTITY, $fields, FolderValidator::getErrors());
    }

    public function delete(int $id): array
    {
        $result = Folder::delete($id);

        if (!$result) {
            return $this->response(Status::UNPROCESSABLE_ENTITY, [], [
                'message' => 'Something went wrong'
            ]);
        }

        return $this->response(Status::OK, $this->model->toArray());
    }

    protected function getModelClass(): string
    {
        return Folder::class;
    }
}