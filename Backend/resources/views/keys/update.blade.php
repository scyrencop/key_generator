@extends('layout')

@section('content')
<div class="container text-center">


    <button class="form-control" id="keygen">Generate Key</button>
    <form action="{{ route('update', $key->id) }}" method="post">
        {{ csrf_field() }} {{ method_field('PUT') }}
        <input name="name" class="form-control" type="text" value="{{ $key->name }}" placeholder="Name"  />
        <br>
        <input name="key" class="form-control" id="apikey"  value="{{ $key->key }}"  type="text" placeholder="Click on the button to generate a new key licence..."  />
        <br>
        <input type="submit" class="form-control" value="Update">
    </form>

    <br>
    <table class="table">
        <thead>
            <th> ID </th>
            <th> NAME </th>
            <th> KEY </th>
            <th> CREATED AT </th>
            <th> UPDATED AT </th>
            <th> ACTION </th>
        </thead>
        <tbody>
            @foreach ($keys as $key)
            <tr>

                <td> {{ $key->id }} </td>
                <td> {{ $key->name }} </td>
                <td> {{ $key->key }} </td>
                <td> {{ $key->created_at }} </td>
                <td> {{ $key->updated_at }} </td>
                <td>
                    <form action="{{ route('delete', $key->id) }}" method="post" style="display:inline;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit"  class="btn btn-danger"> <i class="fa fa-trash"></i> </button>
                    </form>
                    <a href="{{ route('edit', $key->id) }}" class="btn btn-info"> <i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
