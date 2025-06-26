<?php

namespace App\Services\Post;

use App\Models\Post\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostService
{

    public function getAll(): LengthAwarePaginator
    {
        $query = Post::latest();
        return $query->paginate(Post::PAGINATE);
    }

    public function create(array $data): Post
    {
        if (isset($data['file']) && $data['file']) {
            $archivo = $this->savefile($data);
            $data['file_path'] = $archivo['file_path'];
            $data['file_name'] = $archivo['file_name'];
            $data['file_type'] = $archivo['file_type'];
            unset($data['file']);
        }
        return Post::create($data);
    }

    public function find(int $id): Post
    {
        return Post::findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        $post = $this->find($id);

        if (isset($data['file']) && $data['file']) {
            if ($post->file_path && Storage::disk('public')->exists($post->file_path)) {
                Storage::disk('public')->delete($post->file_path);
            }

            $archivo = $this->savefile($data);
            $data['file_path'] = $archivo['file_path'];
            $data['file_name'] = $archivo['file_name'];
            $data['file_type'] = $archivo['file_type'];
            unset($data['file']);
        }

        return $post->update($data);
    }

    public function delete(int $id): bool
    {
        return Post::where('id', $id)->delete();
    }

    public function savefile(array $data): array
    {
        if (!isset($data['file']) || !$data['file']) {
            throw new \InvalidArgumentException('Archivo no válido');
        }

        $file = $data['file'];
        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

        $path = $file->storeAs('posts', $filename, 'public');

        return [
            'file_path' => $path,
            'file_name' => $originalName,
            'file_type' => $extension
        ];
    }
}
