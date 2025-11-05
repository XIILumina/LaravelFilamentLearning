

@section('content')
<h1>{{ $object->name }}</h1>
<p>{{ $object->description }}</p>
<p>Status: {{ $object->active ? 'Active' : 'Inactive' }}</p>
@endsection
