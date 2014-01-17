<?php
require '../vendor/autoload.php';

/**
 * Tests BrowserMobProxy Client
 *
 * @class ClientTest
 * @category Testing
 * @package  PHPBrowserMobProxy
 * @author   Adam Goucher <adam@element34.ca>
 * @author   Chris Hartjes <chartjes@littlehart.net>
 * @license  Apache 2.0
 * @link     https://github.com/chartjes/PHPBrowserMobProxy
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * Setup method
     *
     * @return void
     */
    protected function setUp()
    {
        $this->client = new PHPBrowserMobProxy_Client("localhost:8080");
        $this->client->open();
    }

    /**
     * Tear-down method
     *
     * @return void
     */
    protected function tearDown()
    {
        $this->client->close();
    }

    /**
     * Test if the proxy exists
     *
     * @return void
     */
    public function testProxyExists()
    {
        $r = $this->client->close();
    }

    /**
     * Test that labelling HAR files works
     *
     * @return void
     */
    public function testNamedHar()
    {
        $this->client->newHar("google");
    }

    /**
     * Test that we can create an un-named HAR
     *
     * @return void
     */
    public function testUnNamedHar()
    {
        $this->client->newHar();
    }

    /**
     * Test we can create a named page
     *
     * @return void
     */
    public function testNamedPage()
    {
        $this->client->newHar();
        $this->client->newPage("foo");
    }

    /**
     * Test we can create an un-named page
     *
     * @return void
     */
    public function testUnNamedPage()
    {
        $this->client->newHar("Aa");
        $this->client->newPage("Bb");
    }

    /**
     * Test we can retriver a named HAR
     *
     * @return void
     */
    public function testGetHar()
    {
        $this->client->newHar("Aa");
        $this->client->newPage("Bb");
        $h = $this->client->har;
    }

    /**
     * Test the blacklist functionality
     *
     * @return void
     */
    public function testBlackList()
    {
        $this->client->whitelist('.*\.doubleclick\.net', 200);
        $this->client->newHar("noads");
    }

    /**
     * Test the whitelist functionality
     *
     * @return void
     */
    public function testWhiteList()
    {
        $this->client->whitelist('.*\.doubleclick\.net', 200);
        $this->client->newHar("noads");
    }

    /**
     * Test basic auth
     *
     * @return void
     */
    public function testBasicAuth()
    {
        $response = $this->client->basicAuth(
            'yoyo.org',
            array('username' => 'foo', 'password' => 'bar')
        );
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we send headers
     *
     * @return void
     */
    public function testHeaders()
    {
        $response = $this->client->headers(array('ribbit' => 'rabbit'));
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test that the response inteceptor works
     *
     * @return void
     */
    public function testResponseInterceptor()
    {
        $response = $this->client->responseInterceptor('ffdskl');
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can create a named page
     *
     * @return void
     */
    public function testRequestInterceptor()
    {
        $response = $this->client->requestInterceptor('ffdskl');
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can set upstream limits
     *
     * @return void
     */
    public function testUpstreamLimits()
    {
        $limits = array (
            "downstreamKbps" => 12,
            "upstreamKbps" => 34,
            "latency" => 3
        );
        $response = $this->client->limits($limits);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can set timeouts
     *
     * @return void
     */
    public function testTimeouts()
    {
        $timeouts = array (
            "request" => 12,
            "read" => 34,
            "connection" => 3,
            "dns" => 2
        );
        $response = $this->client->timeouts($timeouts);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can remap hosts
     *
     * @return void
     */
    public function testRemapHosts()
    {
        $response = $this->client->remapHosts("a.b.c", "d.e.f");
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can set traffic stop times
     *
     * @return void
     */
    public function testWaitForTrafficToStop()
    {
        $response = $this->client->waitForTrafficToStop(5, 30);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can clear the proxy's DNS cache
     *
     * @return void
     */
    public function testClearDNSCache()
    {
        $response = $this->client->clearDnsCache();
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can rewrite URL's inside the proxy
     *
     * @return void
     */
    public function testRewriteURL()
    {
        $response = $this->client->rewriteUrl('foo', 'bar');
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can set a retry time for the proxy
     *
     * @return void
     */
    public function testRetry()
    {
        $response = $this->client->retry(3);
        $this->assertEquals($response->status_code, 200);
    }

    /**
     * Test we can define the port of the proxy instance
     *
     * @return void
     */
    public function testInstancePort()
    {
        $this->client = new PHPBrowserMobProxy_Client("localhost:8080", null, "9999");
        $this->client->open();
        $this->assertEquals('localhost:9999', $this->client->url);
    }
}

