@extends('layouts.app')

@section('content')

    
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-10">
                    <h3 class="flex-shrink-5">Most Stargazed Public Repositories</h3>
                </div>
                <div class="col-sm"><a href="{{ route('report.run') }}" class="btn btn-primary">Update Report</a></div>
            </div>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            @if (count($results) == 0)
            <div class="alert alert-success">
                There are no results. Click "Update Results" to generate some.
            </div>
            @endif


            <table class="table table-bordered">
                <thead>
                    <tr class="flex">
                        <th class="d-block d-table-cell" scope="col">#</th>
                        <th class="d-block d-table-cell" scope="col">Repo ID</th>
                        <th class="d-block d-table-cell" scope="col">Name</th>
                        <th class="d-none d-sm-table-cell" scope="col">Description</th>
                        <th class="d-block  d-table-cell" scope="col">Stargazers Count</th>
                        <th class="d-none d-lg-table-cell" scope="col">Created</th>
                        <th class="d-none d-lg-table-cell" scope="col">Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $result)
                    <tr class="clickable flex" data-toggle="popover" data-trigger="hover" data-placement="auto"
                        title="Description" data-html="true"
                        data-content="{{ $result->description }} <p><small></small> (Click row for more information)</small> </p>"
                        onclick="location.href='{{ route('report.detail', $result->id) }}'">
                        <th class="d-block d-table-cell th-sm" scope="row">{{ $result->id }}</th>
                        <td class="d-block d-table-cell">{{ $result->repo_id }}</td>
                        <td class="d-block d-table-cell">{{ $result->name }}</td>

                        <td class="d-none d-sm-table-cell">{{ Str::limit($result->description, 25) }}... </td>
                        <td class="d-block d-table-cell">{{ $result->stargazers_count }}</td>

                        
                        <td class="d-none d-lg-table-cell">{{ \Carbon\Carbon::parse($result->repo_created_at)->format('d/m/Y h:i:s a') }}</td>
                        <td class="d-none d-lg-table-cell">{{ \Carbon\Carbon::parse($result->last_pushed_at)->format('d/m/Y h:i:s a') }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>


        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $results->links() }}
            </div>
        </div>
    </div>


@endsection