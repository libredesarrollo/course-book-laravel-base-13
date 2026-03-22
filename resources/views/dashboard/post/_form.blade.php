<div class="grid grid-cols-2 gap-3">
    @csrf
    <div>
        <label for="" class="form-label">Title</label>
        <input class="form-input" type="text" name="title" value="{{ old('title', $post->title) }}">
    </div>

    <div>
        <label for="" class="form-label">Slug</label>
        <input class="form-input" type="text" name="slug" value="{{ old('slug', $post->slug) }}">
    </div>
    <div>
        <label class="form-label" for="">Category</label>
        <select class="form-input" name="category_id">
            <option value=""></option>
            @foreach ($categories as $title => $id)
                <option {{ old('category_id', $post->category_id) == $id ? 'selected' : '' }}
                    value="{{ $id }}">
                    {{ $title }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="form-label" for="">Posted</label>
        <select class="form-input" name="posted">
            <option value="not" {{ old('posted', $post->posted) == 'not' ? 'selected' : '' }}>Not</option>
            <option value="yes" {{ old('posted', $post->posted) == 'yes' ? 'selected' : '' }}>Yes</option>
        </select>
    </div>
    <div>
        <label class="form-label" for="">Content</label>
        <textarea class="form-input" name="content">{{ old('content', $post->content) }}</textarea>
    </div>

    <div>
        <label class="form-label" for="">Description</label>
        <textarea class="form-input" name="description">{{ old('description', $post->description) }}</textarea>
    </div>
   
    <div>
         @if (isset($task) && $task == 'edit')
            <label class="form-label" for="">Image</label>
            <input type="file" name="image">
        @endif
    </div>

    
</div>
<div class="flex flex-row-reverse">
    <button class="btn btn-primary mt-3" type="submit">Send</button>
</div>
