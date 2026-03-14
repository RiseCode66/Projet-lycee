@extends('base/baseAdmin')
@section('content')

    <div class="card ">
        <div class="card-body">
          <h5 class="card-title">Créer contenue</h5>
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <!-- Trix Textarea -->
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Post Title" required>
                    </div>

                    @trix(\App\Post::class, 'content')
                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Creer</button>
                        </div>
                    </div>
                </form>
        <table class="table datatable">
        <thead>
            <th>ID</th>
            <th>Titre</th>
            <th>Contenue</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach ($post as $item)
                @if (count($post)==0)
                    <tr>
                        <td colspan="3">Rien pour le moment</td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $item->id }} </td>
                    <td style="max-width: 50px" >{{ $item->title }} </td>
                    <td style="max-width: 200px" >{{ $item->content }} </td>
                    <td><a onclick="confirmer()" href="/deletePost?id={{ $item->id }}" class="btn btn-danger"><i class="bi bi-trash"></i></a></td>
                </tr>
            @endforeach
    </tbody>
    </table>
    </div>
</div>

@endsection
