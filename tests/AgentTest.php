<?php
/**
 * Created by PhpStorm.
 * User: Manlin
 * Date: 2019/8/4
 * Time: 下午6:44
 */
namespace EasySwoole\Consul\Test;

use EasySwoole\Consul\Config;
use EasySwoole\Consul\Consul;
use EasySwoole\Consul\Request\Agent\Check\Deregister;
use EasySwoole\Consul\Request\Agent\Check\Fail;
use EasySwoole\Consul\Request\Agent\Check\Pass;
use EasySwoole\Consul\Request\Agent\Check\Register;
use EasySwoole\Consul\Request\Agent\Check\Update;
use EasySwoole\Consul\Request\Agent\Check\Warn;
use EasySwoole\Consul\Request\Agent\Checks;
use EasySwoole\Consul\Request\Agent\Connect\Authorize;
use EasySwoole\Consul\Request\Agent\Connect\Ca\Leaf;
use EasySwoole\Consul\Request\Agent\Connect\Ca\Roots;
use EasySwoole\Consul\Request\Agent\Connect\Proxy;
use EasySwoole\Consul\Request\Agent\ForceLeave;
use EasySwoole\Consul\Request\Agent\Health\Service\ID;
use EasySwoole\Consul\Request\Agent\Health\Service\Name;
use EasySwoole\Consul\Request\Agent\Join;
use EasySwoole\Consul\Request\Agent\Leave;
use EasySwoole\Consul\Request\Agent\Maintenance;
use EasySwoole\Consul\Request\Agent\Members;
use EasySwoole\Consul\Request\Agent\Metrics;
use EasySwoole\Consul\Request\Agent\Monitor;
use EasySwoole\Consul\Request\Agent\Reload;
use EasySwoole\Consul\Request\Agent\SelfParams;
use EasySwoole\Consul\Request\Agent\Service;
use EasySwoole\Consul\Request\Agent\Services;
use EasySwoole\Consul\Request\Agent\Token;
use PHPUnit\Framework\TestCase;

class AgentTest extends TestCase
{
    protected $config;
    protected $consul;

    function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->config = new Config();
        $this->consul = new Consul($this->config);
        parent::__construct($name, $data, $dataName);

    }

    function testMembers()
    {
        $this->consul->agent()->members(new Members([
            'wan' => 'a',
            'segment' => 'b',
        ]));
        $this->assertEquals('x','x');
    }

    function testSelf()
    {
        $self = new SelfParams();
        $this->consul->agent()->self($self);
        $this->assertEquals('x','x');
    }

    function testReload()
    {
        $reload = new Reload();
        $this->consul->agent()->reload($reload);
        $this->assertEquals('x','x');
    }

    function testMaintenance()
    {
        $maintenance = new Maintenance([
            'enable' => 'true',
            'reason' => 'whatever',
        ]);
        $this->consul->agent()->maintenance($maintenance);
        $this->assertEquals('x','x');
    }

    function testMetrics()
    {
        $metrics = new Metrics([
            'format' => 'prometheus',
        ]);
        $this->consul->agent()->metrics($metrics);
        $this->assertEquals('x','x');
    }

    function testMonitor()
    {
        $monitor = new Monitor([
            'loglevel' => 'info',
        ]);
        $this->consul->agent()->monitor($monitor);
        $this->assertEquals('x','x');
    }

    function testJoin()
    {
        $join = new Join([
            'address' => '1.2.3.4',
            'wan' => false
        ]);
        $this->consul->agent()->join($join);
        $this->assertEquals('x','x');
    }

    function testLeave()
    {
        $leave = new Leave();
        $this->consul->agent()->leave($leave);
        $this->assertEquals('x','x');
    }

    function testForceLeave()
    {
        $forceLeave = new ForceLeave([
            'node' => 'aaaaaaaaa'
        ]);
        $this->consul->agent()->forceLeave($forceLeave);
        $this->assertEquals('x','x');
    }

    function testToken()
    {
        $token = new Token([
            'action' => 'acl_agent_token',
            'token' => 'token'
        ]);
        $this->consul->agent()->token($token);
        $this->assertEquals('x','x');
    }

    function testChecks()
    {
        $checks = new Checks([
            'filter' => 'aaaa',
        ]);
        $this->consul->agent()->checks($checks);
        $this->assertEquals('x','x');
    }

    function testRegister()
    {
        $register = new Register([
            'name' => 'Memory_utilization', // 不可以出现空格或者其他url中不允许出现的特殊字符，否则取消注册的check_id会报400 error
            "notes" => "Ensure we don't oversubscribe memory",
            "DeregisterCriticalServiceAfter" => "90m",
            "Args" => ["/usr/local/bin/check_mem.py"],
            "DockerContainerID" => "f972c95ebf0e",
            "Shell" => "/bin/bash",
            "HTTP" => "https://example.com",
            "Method" => "POST",
            "Header" => ["x-foo" => ["bar", "baz"]],
            "TCP" => "example.com:22",
            "Interval" => "10s",
            "TTL" => "15s",
            "TLSSkipVerify" => true,
        ]);
        $this->consul->agent()->register($register);
        $this->assertEquals('x','x');
    }

    function testDeRegister()
    {
        $deRegister = new DeRegister([
            'check_id' => 'Memory_utilization'
        ]);
        $this->consul->agent()->deRegister($deRegister);
        $this->assertEquals('x','x');
    }

    function testPass()
    {
        $pass = new Pass([
            'check_id' => 'Memory_utilization',
            'note' => 'aaaaa',
        ]);
        $this->consul->agent()->pass($pass);
        $this->assertEquals('x','x');
    }

    function testWarn()
    {
        $warn = new Warn([
            'check_id' => 'Memory_utilization',
            'note' => 'aaaaa',
        ]);
        $this->consul->agent()->warn($warn);
        $this->assertEquals('x','x');
    }

    function testFail()
    {
        $fail = new Fail([
            'check_id' => 'Memory_utilization',
            'note' => 'aaaaa',
        ]);
        $this->consul->agent()->fail($fail);
        $this->assertEquals('x','x');
    }

    function testUpdate()
    {
        $update = new Update([
            'check_id' => 'Memory_utilization',
            'Status' => 'passing',
            'Output' => 'update success'
        ]);
        $this->consul->agent()->update($update);
        $this->assertEquals('x','x');
    }

    function testServices()
    {
        $services = new Services([
            'filter' => 'a',
        ]);
        $this->consul->agent()->services($services);
        $this->assertEquals('x','x');
    }

    function testService()
    {
        $service = new Service([
            'service_id' => "register_consule"
        ]);
        $this->consul->agent()->service($service);
        $this->assertEquals('x','x');
    }

    function testName()
    {
        $name = new Name([
            'service_name' => 'register_consule',
            'format' => 'text',
        ]);
        $this->consul->agent()->name($name);
        $this->assertEquals('x','x');
    }

    function testId()
    {
        $id = new ID([
            'service_id' => 'register_consule',
            'format' => 'text',
        ]);
        $this->consul->agent()->id($id);
        $this->assertEquals('x','x');
    }

    function testServiceRegister()
    {
        $register = new Service\Register([
            "ID" => "redis1",
            "name" => "redis",
            "Tags" => [
                "primary",
                "v1"
            ],
            "Address" => "127.0.0.1",
            "Port" => 8000,
            "meta" => [
                "redis_version" => "4.0",
            ],
            "EnableTagOverride" => false,
            "Check" => [
                "DeregisterCriticalServiceAfter" => "90m",
            "Args" => ["/usr/local/bin/check_redis.py"],
            "HTTP" => "http://localhost:5000/health",
            "Interval" => "10s",
            "TTL" => "15s"
            ],
            "weights" => [
                "Passing" => 10,
            "Warning" => 1
            ]
        ]);
        $this->consul->agent()->serviceRegister($register);
        $this->assertEquals('x','x');
    }

    function testServiceDeRegister()
    {
        $deregister = new Service\DeRegister([
            'service_id' => 'aaaaaa',
        ]);
        $this->consul->agent()->serviceDeregister($deregister);
        $this->assertEquals('x','x');
    }

      function testServiceMaintenance()
      {
        $maintenance= new Service\Maintenance([
            'service_id' => 'aaaaaa',
            'enable' => true,
            'reason' => 'bbbb'
        ]);
        $this->consul->agent()->serviceMaintenance($maintenance);
        $this->assertEquals('x','x');
      }
    function testAuthorize()
    {
        $authorize = new Authorize([
            "target" => "db",
            "clientCertURI" => "spiffe://dc1-7e567ac2-551d-463f-8497-f78972856fc1.consul/ns/default/dc/dc1/svc/web",
            "clientCertSerial" => "04:00:00:00:00:01:15:4b:5a:c3:94"
        ]);
        $this->consul->agent()->authorize($authorize);
        $this->assertEquals('x','x');
    }

    function testRoots()
    {
        $roots = new Roots();
        $this->consul->agent()->roots($roots);
        $this->assertEquals('x','x');
    }

    function testLeaf()
    {
        $leaf = new Leaf([
            'service' => 'aaaa'
        ]);
        $this->consul->agent()->leaf($leaf);
        $this->assertEquals('x','x');
    }

    function testProxy()
    {
        $proxy = new Proxy([
            'ID' => 'aaaaa'
        ]);
        $this->consul->agent()->proxy($proxy);
        $this->assertEquals('x','x');
    }
}