<?php

namespace Shield\GitLab\Test\Unit;

use PHPUnit\Framework\Assert;
use Shield\Shield\Contracts\Service;
use Shield\Testing\TestCase;
use Shield\GitLab\GitLab;

/**
 * Class ServiceTest
 *
 * @package \Shield\GitLab\Test\Unit
 */
class ServiceTest extends TestCase
{
    /**
     * @var \Shield\GitLab\GitLab
     */
    protected $service;

    protected function setUp()
    {
        parent::setUp();

        $this->service = new GitLab;
    }

    /** @test */
    public function it_is_a_service()
    {
        Assert::assertInstanceOf(Service::class, new GitLab);
    }

    /** @test */
    public function it_can_verify_a_valid_request()
    {
        $token = 'raNd0mk3y';

        $this->app['config']['shield.services.gitlab.options.token'] = $token;

        $request = $this->request();

        $headers = [
            'X-Gitlab-Token' => $token
        ];

        $request->headers->add($headers);

        Assert::assertTrue($this->service->verify($request, collect($this->app['config']['shield.services.gitlab.options'])));
    }

    /** @test */
    public function it_will_not_verify_a_bad_request()
    {
        $this->app['config']['shield.services.gitlab.options.token'] = 'good';

        $request = $this->request();

        $headers = [
            'X-Gitlab-Token' => 'bad'
        ];

        $request->headers->add($headers);

        Assert::assertFalse($this->service->verify($request, collect($this->app['config']['shield.services.gitlab.options'])));
    }

    /** @test */
    public function it_has_correct_headers_required()
    {
        Assert::assertArraySubset(['X-Gitlab-Token'], $this->service->headers());
    }
}
