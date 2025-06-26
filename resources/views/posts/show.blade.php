<x-layout>
    <div>
        <a href="{{ route('posts.index') }}" class = "btn btn-secondary"> <- Volver Al Indice </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->content }}</p>
            <p><strong>Status:</strong> {{ $post->status }}</p>
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Editar</a>
            <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</x-layout>
