<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;

class AcceptGithubWebhook extends FormRequest
{
    public $project;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $input = $this->validated();
        $signature = $this->header('X-Hub-Signature');

        if (empty($signature)) {
            return false;
        }

        if (!str_contains($signature, '=')) {
            return false;
        }

        if (!isset($input['repository']['full_name'])) {
            return false;
        }

        [$algorithm, $signature] = explode('=', $signature, 2);
        $this->project = Project::where('github_repo', $input['repository']['full_name'])->with(['branches', 'user'])->first();

        if ($this->project === null) {
            return false;
        }

        // Signature Verification
        $hash = hash_hmac($algorithm, $this->getContent(), $this->project->webhook_secret);

        return $hash === $signature;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => 'required',
            'pull_request' => 'required',
            'repository.full_name' => 'required',
        ];
    }
}
