<x-layout>
    <div class="container my-5">
        <div class="mb-3">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                ← Volver al índice
            </a>
        </div>

        <div class="card border-0 shadow rounded">
            @if ($post->file_path)
                <div class="card-header bg-white border-bottom-0 p-0">
                    @php
                        $ext = strtolower(pathinfo($post->file_name, PATHINFO_EXTENSION));
                        $url = Storage::url($post->file_path);
                    @endphp

                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                        <img src="{{ $url }}" alt="{{ $post->file_name }}" class="img-fluid rounded-top">
                    @elseif (in_array($ext, ['mp4', 'webm', 'ogg']))
                        <video controls class="w-100 rounded-top">
                            <source src="{{ $url }}" type="video/{{ $ext }}">
                            Tu navegador no soporta videos.
                        </video>
                    @elseif (in_array($ext, ['mp3', 'wav', 'ogg']))
                        <div class="p-4">
                            <audio controls class="w-100">
                                <source src="{{ $url }}" type="audio/{{ $ext }}">
                                Tu navegador no soporta audio.
                            </audio>
                        </div>
                    @elseif ($ext === 'pdf')
                        <iframe src="{{ $url }}" style="width:100%; height:600px; border:none;" class="rounded-top"></iframe>
                    @else
                        <div class="p-4">
                            <a href="{{ $url }}" download class="btn btn-outline-secondary">
                                Descargar archivo ({{ $post->file_name }})
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <div class="card-body">
                <h1 class="display-6 fw-semibold text-center mb-4">{{ $post->title }}</h1>

                <div class="text-center mb-3">
                    <span class="badge bg-info text-dark fs-6">
                        Estado: {{ ucfirst($post->status) }}
                    </span>
                </div>

                <div class="mb-4">
                    <p class="fs-5 text-justify">{{ $post->content }}</p>
                </div>
            </div>

            <div class="card-footer bg-white border-top text-center py-3">
                <small class="text-muted">Publicado {{ $post->created_at->diffForHumans() }}</small>
            </div>
        </div>
    </div>
</x-layout>
