<?php

namespace App\Http\Controllers;

use App\Project;
use Github\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Project::class);
    }

    public function index()
    {
        return redirect()->action('HomeController@index');
    }

    public function create()
    {
        return redirect()->action('ProjectController@index');
    }

    /**
     * Creates a new project.
     *
     * @param Request $request
     * @param Client $github
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $github)
    {
        $input = $request->all() + ['webhook_secret' => str_random(20)];

        $project = Project::onlyTrashed()->where('github_repo', $request->get('github_repo'))->first();

        if ($project === null) {
            $project = new Project($input);
        }

        if ($project->trashed()) {
            $project->restore();
        }

        $project = auth()->user()->projects()->save($project);

        $github->authenticate($project->user->github_token, null, Client::AUTH_HTTP_PASSWORD);
        [$githubUser, $githubRepo] = explode('/', $project->github_repo);

        $hook = $github->api('repo')->hooks()->create($githubUser, $githubRepo, [
            'name' => 'web',
            'config' => [
                'url' => action('WebhookController@githubPullRequest'),
                'content_type' => 'json',
                'secret' => $project->webhook_secret,
                'insecure_ssl' => 0,
            ],
            'events' => ['pull_request'],
            'active' => true,
        ]);

        return redirect()->action('HomeController@index');
    }

    public function show(Project $project)
    {
        return view('project')->with(compact('project'));
    }

    public function edit(Project $project)
    {
        return redirect()->action('ProjectController@show', [$project]);
    }

    public function update(Project $project, Request $request)
    {
        $project->forge_site_url = $request->get('forge_site_url');
        $project->forge_deployment = $request->get('forge_deployment');
        $project->save();

        return redirect()->action('ProjectController@show', [$project]);
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->action('ProjectController@index');
    }
}
