@extends('layouts.app')

@section('content')



<nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand text-white" href="{{ route('report.show') }}">
       Return to Dashboard
    </a>
</nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-10 text-center">
                    <h2>{{ $result->name }} </h2>
                    <small class="muted">(repository id: {{ $result->repo_id }})</small>
                </div>
                <div class="col-2">
                    <div class="divider text-center border border-black w-100">
                        <div class="emphasis">
                            <h2><strong> {{ number_format($result->stargazers_count) }} </strong></h2>
                            <p><small>Stargazers</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            
            <h3>Repository Details:</h3>
            <div class="col">
            <p><strong>Name:</strong> {{ $result->name }}</p>
            <p><strong>Description:</strong> {{ $result->description }}</p>
            <p><strong data-toggle="tooltip" data-placement="top" title="Number of people that added a star to the repository.">Number of Stargazers:</strong> {{ $result->stargazers_count }} </p>
            <p><strong>Created:</strong> {{ \Carbon\Carbon::parse($result->repo_created_at)->format('d/m/Y h:i:s a')}}</p>
            <p><strong>Last updated:</strong> {{ \Carbon\Carbon::parse($result->last_pushed_at)->format('d/m/Y h:i:s a')}}</p>
            <p><strong>Visit:</strong> <a href="{{ $result->repo_url }}" target="_blank">{{ $result->repo_url }}</a></p>
        </div>

        
            
        </div>

    </div>

@endsection