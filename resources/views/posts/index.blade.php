<x-layout>
    <div class="container my-5">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Listado de Posts</h2>
                <a href="{{ route('posts.create') }}" class="btn btn-light btn-sm">Nuevo Post</a>
            </div>

            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-secondary">{{ session('message') }}</div>
                @endif

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">Título</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Nombre del Archivo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ ucfirst($post->status) }}</td>
                                    <td>{{ $post->file_name ?? 'Sin Archivo' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-success me-1">Ver</a>
                                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning me-1">Editar</a>
                                        <form method="POST" action="{{ route('posts.destroy', $post) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay publicaciones registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="card-footer bg-light text-end">
                <strong>Total de Posts: {{ $posts->total() }}</strong>
            </div>
        </div>
    </div>
</x-layout>
