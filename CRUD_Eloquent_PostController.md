# Operaciones CRUD en Eloquent - PostController

Este documento lista las operaciones Eloquent usadas en el controlador para enseñar en el curso.

## Listado (Read - index)

```php
$posts = Post::paginate(20);
```

- **Método**: `paginate()` - Paginación de resultados
- **Relación**: Sin relación eager loading (`Post::with('category')` está comentado)

---

## Create (Store)

```php
auth()->user()->posts()->save(new Post($request->validated()));
```

- **Método**: `save()` - Guarda una instancia nueva relacionada al usuario autenticado
- **Relación**: `posts()` - Relación polimórfica o morphic

**Alternativa** (comentado):
```php
Post::create($request->validated());
$post = new Post($request->validated());
auth()->user()->posts()->save($post);
```

---

## Read (Show)

```php
public function show(Post $post): View
```

- **Route Model Binding**: Laravel inyecta automáticamente el modelo desde la URL

---

## Update (Edit)

```php
public function update(PutRequest $request, Post $post): RedirectResponse
{
    $data = $request->validated();
    $data['image'] = $this->handleImageUpload($request, $data);
    Cache::forget('post_show_'.$post->id);
    $post->update($data);
    // ...
}
```

- **Método**: `update()` - Actualiza el modelo en BD
- **Nota**: También invalida caché antes de actualizar

---

## Delete (Destroy)

```php
public function destroy(Post $post): RedirectResponse
{
    $post->delete();
    // ...
}
```

- **Método**: `delete()` - Elimina el registro de la BD

---

## Otras operaciones Eloquent en el controlador

###Obtener valores para dropdowns:
```php
$categories = Category::pluck('title', 'id');
```

- **Método**: `pluck()` - Retorna array clave-valor

---

## Métodos Eloquent NO usados en este controlador

| Método | Descripción |
|--------|-------------|
| `firstOrFail()` | Obtiene el primer resultado o lanza 404 |
| `first()` | Obtiene el primer resultado |
| `find()` | Busca por ID |
| `findOrFail()` | Busca por ID o lanza 404 |
| `updateOrCreate()` | Actualiza o crea |
| `firstOrCreate()` | Obtiene o crea |
| `exists()` | Verifica si existe |
| `count()` | Cuenta registros |
| `pluck()` | Obtiene columna específica |

---

---

## Ejemplos con Category

Ejemplos prácticos de operaciones Eloquent aplicados a la entidad Category:

### Listado con paginate()
```php
// Listar todas las categorías paginado
$categories = Category::paginate(20);

// Con ordenamiento
$categories = Category::orderBy('title')->paginate(20);
```

### Listado con all() y get()
```php
// Obtener todas las categorías
$categories = Category::all();

// Con condición y orden
$categories = Category::where('active', true)->orderBy('title')->get();
```

### first() - Primer resultado
```php
// Obtener primera categoría
$category = Category::first();

// Con condición
$category = Category::where('slug', 'noticias')->first();
```

### firstOrFail() - Primer resultado o 404
```php
// Obtiene primera o lanza 404
$category = Category::firstOrFail();

// Con condición
$category = Category::where('slug', $slug)->firstOrFail();
```

### find() - Buscar por ID
```php
// Buscar por ID
$category = Category::find(1);

// Buscar múltiples IDs
$categories = Category::find([1, 2, 3]);
```

### findOrFail() - Buscar por ID o 404
```php
// Busca por ID o lanza 404
$category = Category::findOrFail(1);

// Con condición
$category = Category::where('active', true)->findOrFail(1);
```

### create() - Crear registro
```php
// Crear directamente
$category = Category::create([
    'title' => 'Tecnología',
    'slug' => 'tecnologia'
]);

// Crear con instancia
$category = new Category(['title' => 'Tecnología']);
$category->save();
```

### update() - Actualizar registro
```php
// Actualizar instancia
$category = Category::find(1);
$category->update(['title' => 'Nuevo Título']);

// Actualizar sin instancia
Category::where('slug', 'tecno')->update(['title' => 'Tech']);
```

### updateOrCreate() - Actualizar o crear
```php
// Atualiza si existe, crea si no
$category = Category::updateOrCreate(
    ['slug' => 'tecno'], // condición
    ['title' => 'Tecnología'] // valores
);
```

### firstOrCreate() - Obtener o crear
```php
// Obtiene si existe, crea si no
$category = Category::firstOrCreate(
    ['slug' => 'default'],
    ['title' => 'Default']
);
```

### delete() - Eliminar registro
```php
// Eliminar instancia
$category = Category::find(1);
$category->delete();

// Eliminar por ID directamente
Category::destroy(1);

// Eliminar múltiples
Category::destroy([1, 2, 3]);

// Eliminar con condición
Category::where('active', false)->delete();
```

### pluck() - Obtener columna específica
```php
// Array clave-valor (id => title)
$categories = Category::pluck('title', 'id');

// Solo valores
$categories = Category::pluck('title');
```

### count() - Contar registros
```php
// Contar todas
$count = Category::count();

// Con condición
$count = Category::where('active', true)->count();
```

### exists() - Verificar existencia
```php
// Verificar si existe
$exists = Category::where('slug', 'tecno')->exists();

// Verificar si NO existe
$exists = Category::where('slug', 'tecno')->doesntExist();
```

---

## Resumen de operaciones CRUD

| Operación | Métodos Eloquent | Ejemplo Category |
|------------|------------------|------------------|
| Listar | `paginate()`, `all()`, `get()` | `Category::paginate(20)` |
| Leer uno | `first()`, `find()`, `firstOrFail()`, `findOrFail()` | `Category::findOrFail(1)` |
| Crear | `create()`, `save()` | `Category::create([...])` |
| Actualizar | `update()`, `updateOrCreate()` | `$category->update([...])` |
| Eliminar | `delete()`, `destroy()` | `Category::destroy(1)` |
| Columnas | `pluck()` | `Category::pluck('title', 'id')` |
| Contar | `count()`, `exists()` | `Category::count()` |