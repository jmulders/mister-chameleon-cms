<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * The control panel is reachable and guarded.
 *
 * This replaces Laravel's scaffold ExampleTest, which asserted that GET "/"
 * returns 200. That is true of a stock Laravel app and false of this one: the
 * public site is rendered by the Next.js platform over the REST API, so this
 * install is headless and "/" is a 404 in the test environment. The test failed
 * on every branch, which cost the suite its signal.
 *
 * `/cp/auth/login` is worth guarding in its place, because it is not just any
 * route:
 *
 *   - It is the `health_check_path` the platform's provisioner writes into
 *     every tenant's Ploi infrastructure (buildStatamicInfraYaml). Ploi decides
 *     an instance is unhealthy from exactly this response, so a change that
 *     breaks it takes rollouts down.
 *   - It is host-agnostic and needs no authentication, no seeded content and no
 *     database, which is what makes it stable enough to assert on.
 *
 * The body assertions matter as much as the status: a Statamic CP that boots
 * into an error page can still answer 200, and a bare status check would call
 * that healthy.
 */
class CpLoginTest extends TestCase
{
    public function test_cp_login_is_reachable(): void
    {
        $response = $this->get('/cp/auth/login');

        $response->assertStatus(200);

        // Proof it rendered the actual login screen rather than something that
        // merely returned 200. The CP login is a Vue component, so there is no
        // literal <form> to look for — these markers are what it ships with.
        $body = (string) $response->getContent();
        $this->assertStringContainsString('password', $body);
        $this->assertStringContainsString('csrf', $body);
    }

    public function test_the_control_panel_is_behind_the_login(): void
    {
        $this->get('/cp')->assertRedirect('/cp/auth/login');
    }
}
