@extends($activeTemplate.'layouts.frontend')
@section('content')
    <section class="ptb-80">
        <div class="container">
            @php echo $data->data_values->details @endphp
        </div>
    </section>
@endsection
