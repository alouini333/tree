@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Tokens</div>

                    <div class="card-body">
                        @if (isset($forgeException)) <div class="alert alert-danger">{{ $forgeException }}</div> @endif
                        @if (isset($githubException)) <div class="alert alert-danger">{{ $githubException }}</div> @endif

                        <form method="POST" action="{{ action('ProfileController@update') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="forge_token" class="col-sm-4 col-form-label text-md-right">Forge Token:</label>

                                <div class="col-md-6">
                                    <input id="forge_token" type="text" class="form-control{{ $errors->has('forge_token') ? ' is-invalid' : '' }}" name="forge_token" value="{{ auth()->user()->forge_token }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Save Tokens</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Projects</div>

                    @if (auth()->user()->projects->count() > 0)
                        <div class="card-body">
                            <form method="POST" action="">
                                @csrf

                                <div class="form-group row">
                                    <label for="forge_server_id" class="col-sm-4 col-form-label text-md-right">Project:</label>

                                    <div class="col-md-6">
                                        <select id="forge_server_id" name="forge_server_id" class="form-control">
                                            @foreach (auth()->user()->projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->forge_site_url }} ({{ $project->github_repo }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-info">Edit Project</button>
                                        <button type="submit" class="btn btn-danger">Delete Project</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="col-md-8 offset-md-4">
                                You haven't created any projects yet!
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-8 mt-3">
                <div class="card">
                    <div class="card-header">Create New Project</div>

                    <div class="card-body">
                        <form method="POST" action="{{ action('ProjectController@create') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="forge_site_url" class="col-sm-4 col-form-label text-md-right">URL:</label>

                                <div class="col-md-6">
                                    <input id="forge_site_url" type="text" class="form-control{{ $errors->has('forge_site_url') ? ' is-invalid' : '' }}" name="forge_site_url" value="{{ auth()->user()->forge_site_url }}" required placeholder="*.example.com">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="forge_server_id" class="col-sm-4 col-form-label text-md-right">Server:</label>

                                <div class="col-md-6">
                                    <select id="forge_server_id" name="forge_server_id" class="form-control">
                                        @foreach ($servers as $server)
                                            <option value="{{ $server->id }}">{{ $server->name }} ({{ $server->ipAddress}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="github_repo" class="col-md-4 col-form-label text-md-right">Github Repository:</label>

                                <div class="col-md-6">
                                    <select id="github_repo" name="github_repo" class="form-control">
                                        @foreach ($repositories as $repository)
                                            <option value="{{ $repository['full_name'] }}">{{ $repository['full_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="forge_deployment" class="col-md-4 col-form-label text-md-right">Deployment:</label>

                                <div class="col-md-6">
                                    <textarea name="forge_deployment" class="form-control" rows="5">php artisan db:seed</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Create Project</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
