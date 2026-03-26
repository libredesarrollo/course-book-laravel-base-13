@extends('dashboard.layout')

@section('content')
    
    <a class="btn btn-primary" href="{{ route('post.create') }}">Create</a>

    <div class="overflow-x-auto mt-4">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Id
                    </th>
                    <th>
                        Title
                    </th>
                    <th>
                        Posted
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Options
                    </th>
                </tr>

            </thead>
            <tbody>
                @foreach ($posts as $p)
                    <tr>
                        <td>
                            {{ $p->id }}
                        </td>
                        <td>
                            {{ $p->title }}
                        </td>
                        <td>
                            {{ $p->posted }}
                        </td>
                        <td>
                            {{ $p->category->title }}
                        </td>
                        <td class="flex gap-2">
                            <form action="{{ route('post.destroy', $p) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                            <a class="btn-sm btn-secondary" href="{{ route('post.edit', $p) }}" target="_blank">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $posts->links() }}
@endsection
