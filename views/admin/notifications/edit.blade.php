@extends('oxygencms::admin.layout')

@section('title', 'Edit Notification')

@section('content')

    <div class="row">
        <div class="col-12 d-flex align-items-center mb-3">
            <h1>Edit Notification</h1>
        </div>
    </div>

    <form action="{{ route('admin.notification.update', $notification) }}" method="POST" onsubmit="deleteBlankFields()">
        {!! csrf_field() !!}
        {!! method_field('patch') !!}

        @include('oxygencms::admin.notifications._form-fields')

        <button class="btn btn-primary" type="submit">Update</button>
    </form>

@endsection
