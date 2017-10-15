<?php

namespace Shield\GitLab;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Shield\Shield\Contracts\Service;

/**
 * Class GitLab
 *
 * @package \Shield\GitLab
 */
class GitLab implements Service
{
    public function verify(Request $request, Collection $config): bool
    {
        return $request->header('X-Gitlab-Token') == $config->get('token');
    }

    public function headers(): array
    {
        return ['X-Gitlab-Token'];
    }
}
