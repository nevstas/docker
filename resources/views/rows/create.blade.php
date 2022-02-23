@extends('layouts.app')

@section('content')
    <div class="md:container mx-auto">

        @if($errors->any())
            <div class="flex justify-center">
                <div class="text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex justify-center">

            <form class="space-x-6" action="{{ route('rows.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label class="block my-1">
                    <span class="sr-only">Choose profile photo</span>
                    <input id="с" name="import_file" type="file" class="block w-full text-sm text-slate-500
          file:mr-4 file:py-2 file:px-4
          file:rounded-full file:border-0
          file:text-sm file:font-semibold
          file:bg-violet-50 file:text-violet-700
          hover:file:bg-violet-100
        "/>
                </label>

                <div class="my-1 text-center">
                    <button class="mx-1 px-3 py-3 rounded-lg bg-violet-300" type="submit">Import</button>
                    <a class="mx-1 px-3 py-3 rounded-lg bg-violet-300" href="{{ route('rows.index') }}">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection
