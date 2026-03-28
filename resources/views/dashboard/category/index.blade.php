@extends('dashboard.layout')

@section('content')
    <a class="btn btn-primary" href="{{ route('category.create') }}">Crear</a>

    <div class="overflow-x-auto mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->slug }}</td>
                        <td class="flex gap-2">
                            <a class="btn-sm btn-secondary" href="{{ route('category.show', $category) }}">Show</a>
                            <a class="btn-sm btn-secondary"  href="{{ route('category.edit', $category) }}">Edit</a>

                            <form action="{{ route('category.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $categories->links() }}
@endsection
