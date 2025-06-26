<x-layout>
    <div class="container my-5">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0">{{ $post->exists ? 'Editar Post' : 'Crear Post' }}</h2>
                <a href="{{ route('posts.index') }}" class="btn btn-light btn-sm">← Volver al índice</a>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ $post->exists ? route('posts.update', $post) : route('posts.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @if ($post->exists)
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label for="file" class="form-label">Archivo</label>
                        <input type="file" name="file" class="form-control" id="file">

                        @if ($post->exists && $post->file_path)
                            <div class="mt-3">
                                @php
                                    $ext = strtolower(pathinfo($post->file_name, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                    <img src="{{ Storage::url($post->file_path) }}" alt="{{ $post->file_name }}"
                                        class="img-thumbnail" style="max-width: 100%;">
                                @elseif (in_array($ext, ['mp4', 'webm', 'ogg']))
                                    <video controls style="max-width: 100%;">
                                        <source src="{{ Storage::url($post->file_path) }}"
                                            type="video/{{ $ext }}">
                                    </video>
                                @elseif (in_array($ext, ['mp3', 'wav', 'ogg']))
                                    <audio controls>
                                        <source src="{{ Storage::url($post->file_path) }}"
                                            type="audio/{{ $ext }}">
                                    </audio>
                                @elseif ($ext === 'pdf')
                                    <iframe src="{{ Storage::url($post->file_path) }}" style="width:100%; height:400px;"
                                        frameborder="0"></iframe>
                                @else
                                    <a href="{{ Storage::url($post->file_path) }}" download>
                                        {{ $post->file_name }}
                                    </a>
                                @endif
                            </div>
                        @endif

                        @error('file')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input name="title" class="form-control" value="{{ old('title', $post->title) }}">
                        @error('title')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="status" class="form-select">
                            <option value="draft" @selected(old('status', $post->status) === 'draft')>Borrador</option>
                            <option value="published" @selected(old('status', $post->status) === 'published')>Publicado</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary">{{ $post->exists ? 'Actualizar' : 'Crear' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
