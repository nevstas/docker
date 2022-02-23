@extends('layouts.app')

@section('content')
    <div class="md:container mx-auto">


        @if (!$rows->isEmpty())
            <table class="table-auto w-full text-center	border-collapse border border-slate-400">
                <thead>
                <tr>
                    <th class="border border-slate-300 p-2">Date</th>
                    <th class="border border-slate-300 p-2">Users</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td class="border border-slate-300 p-2">{{ Carbon\Carbon::parse($row->date)->format('d.m.Y') }}</td>
                        <td class="border border-slate-300 p-2">
                            @foreach($row->users as $user)
                                <p>ID: {{ $user->id }}, Name: {{ $user->name }}</p>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $rows->links() }}
            </div>
        @else
            <div class="text-red-600">
                <p>Nothing found</p>
            </div>
        @endif


    </div>




@endsection
