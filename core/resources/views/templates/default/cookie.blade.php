@extends($activeTemplate.'layouts.frontend')
@section('content')

@php echo $cookie->data_values->description @endphp
    
@endsection
