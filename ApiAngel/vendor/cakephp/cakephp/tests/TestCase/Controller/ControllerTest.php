<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP Project
 * @since         1.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Controller;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\Fixture\TestModel;
use Cake\TestSuite\TestCase;
use TestApp\Controller\Admin\PostsController;
use TestPlugin\Controller\TestPluginController;

/**
 * AppController class
 *
 */
class ControllerTestAppController extends Controller
{

    /**
     * helpers property
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * modelClass property
     *
     * @var string
     */
    public $modelClass = 'Posts';

    /**
     * components property
     *
     * @var array
     */
    public $components = ['Cookie'];
}

/**
 * TestController class
 */
class TestController extends ControllerTestAppController
{

    /**
     * Theme property
     *
     * @var string
     */
    public $theme = 'Foo';

    /**
     * helpers property
     *
     * @var array
     */
    public $helpers = ['Html'];

    /**
     * components property
     *
     * @var array
     */
    public $components = ['Security'];

    /**
     * modelClass property
     *
     * @var string
     */
    public $modelClass = 'Comments';

    /**
     * beforeFilter handler
     *
     * @param \Cake\Event\Event $event
     * @retun void
     */
    public function beforeFilter(Event $event)
    {
    }

    /**
     * index method
     *
     * @param mixed $testId
     * @param mixed $testTwoId
     * @return void
     */
    public function index($testId, $testTwoId)
    {
        $this->request->data = [
            'testId' => $testId,
            'test2Id' => $testTwoId
        ];
    }

    /**
     * view method
     *
     * @param mixed $testId
     * @param mixed $testTwoId
     * @return void
     */
    public function view($testId, $testTwoId)
    {
        $this->request->data = [
            'testId' => $testId,
            'test2Id' => $testTwoId
        ];
    }

    public function returner()
    {
        return 'I am from the controller.';
    }

    //@codingStandardsIgnoreStart
    protected function protected_m()
    {
    }

    private function private_m()
    {
    }

    public function _hidden()
    {
    }
    //@codingStandardsIgnoreEnd

    public function admin_add()
    {
    }
}

/**
 * TestComponent class
 */
class TestComponent extends Component
{

    /**
     * beforeRedirect method
     *
     * @return void
     */
    public function beforeRedirect()
    {
    }

    /**
     * initialize method
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
    }

    /**
     * startup method
     *
     * @param Event $event
     * @return void
     */
    public function startup(Event $event)
    {
    }

    /**
     * shutdown method
     *
     * @param Event $event
     * @return void
     */
    public function shutdown(Event $event)
    {
    }

    /**
     * beforeRender callback
     *
     * @param Event $event
     * @return void
     */
    public function beforeRender(Event $event)
    {
        $controller = $event->subject();
        if ($this->viewclass) {
            $controller->viewClass = $this->viewclass;
        }
    }
}

/**
 * AnotherTestController class
 *
 */
class AnotherTestController extends ControllerTestAppController
{
}

/**
 * ControllerTest class
 *
 */
class ControllerTest extends TestCase
{

    /**
     * fixtures property
     *
     * @var array
     */
    public $fixtures = [
        'core.comments',
        'core.posts'
    ];

    /**
     * reset environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Configure::write('App.namespace', 'TestApp');
        Router::reload();
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Plugin::unload();
    }

    /**
     * test autoload modelClass
     *
     * @return void
     */
    public function testTableAutoload()
    {
        $request = new Request('controller_posts/index');
        $response = $this->getMock('Cake\Network\Response');
        $Controller = new Controller($request, $response);
        $Controller->modelClass = 'SiteArticles';

        $this->assertFalse($Controller->Articles);
        $this->assertInstanceOf(
            'Cake\ORM\Table',
            $Controller->SiteArticles
        );
        unset($Controller->SiteArticles);

        $Controller->modelClass = 'Articles';

        $this->assertFalse($Controller->SiteArticles);
        $this->assertInstanceOf(
            'TestApp\Model\Table\ArticlesTable',
            $Controller->Articles
        );
    }

    /**
     * testLoadModel method
     *
     * @return void
     */
    public function testLoadModel()
    {
        $request = new Request('controller_posts/index');
        $response = $this->getMock('Cake\Network\Response');
        $Controller = new Controller($request, $response);

        $this->assertFalse(isset($Controller->Articles));

        $result = $Controller->loadModel('Articles');
        $this->assertInstanceOf(
            'TestApp\Model\Table\ArticlesTable',
            $result
        );
        $this->assertInstanceOf(
            'TestApp\Model\Table\ArticlesTable',
            $Controller->Articles
        );
    }

    /**
     * testLoadModel method from a plugin controller
     *
     * @return void
     */
    public function testLoadModelInPlugins()
    {
        Plugin::load('TestPlugin');

        $Controller = new TestPluginController();
        $Controller->plugin = 'TestPlugin';

        $this->assertFalse(isset($Controller->TestPluginComments));

        $result = $Controller->loadModel('TestPlugin.TestPluginComments');
        $this->assertInstanceOf(
            'TestPlugin\Model\Table\TestPluginCommentsTable',
            $result
        );
        $this->assertInstanceOf(
            'TestPlugin\Model\Table\TestPluginCommentsTable',
            $Controller->TestPluginComments
        );
    }

    /**
     * Test that the constructor sets modelClass properly.
     *
     * @return void
     */
    public function testConstructSetModelClass()
    {
        Plugin::load('TestPlugin');

        $request = new Request();
        $response = new Response();
        $controller = new \TestApp\Controller\PostsController($request, $response);
        $this->assertEquals('Posts', $controller->modelClass);
        $this->assertInstanceOf('Cake\ORM\Table', $controller->Posts);

        $controller = new \TestApp\Controller\Admin\PostsController($request, $response);
        $this->assertEquals('Posts', $controller->modelClass);
        $this->assertInstanceOf('Cake\ORM\Table', $controller->Posts);

        $request->params['plugin'] = 'TestPlugin';
        $controller = new \TestPlugin\Controller\Admin\CommentsController($request, $response);
        $this->assertEquals('TestPlugin.Comments', $controller->modelClass);
        $this->assertInstanceOf('TestPlugin\Model\Table\CommentsTable', $controller->Comments);
    }

    /**
     * testConstructClassesWithComponents method
     *
     * @return void
     */
    public function testConstructClassesWithComponents()
    {
        Plugin::load('TestPlugin');

        $Controller = new TestPluginController(new Request(), new Response());
        $Controller->loadComponent('TestPlugin.Other');

        $this->assertInstanceOf('TestPlugin\Controller\Component\OtherComponent', $Controller->Other);
    }

    /**
     * testRender method
     *
     * @return void
     */
    public function testRender()
    {
        Plugin::load('TestPlugin');

        $request = new Request('controller_posts/index');
        $request->params['action'] = 'index';

        $Controller = new Controller($request, new Response());
        $Controller->viewBuilder()->templatePath('Posts');

        $result = $Controller->render('index');
        $this->assertRegExp('/posts index/', (string)$result);

        $Controller->viewBuilder()->template('index');
        $result = $Controller->render();
        $this->assertRegExp('/posts index/', (string)$result);

        $result = $Controller->render('/Element/test_element');
        $this->assertRegExp('/this is the test element/', (string)$result);
    }

    /**
     * test that a component beforeRender can change the controller view class.
     *
     * @return void
     */
    public function testBeforeRenderCallbackChangingViewClass()
    {
        $Controller = new Controller(new Request, new Response());

        $Controller->eventManager()->on('Controller.beforeRender', function ($event) {
            $controller = $event->subject();
            $controller->viewClass = 'Json';
        });

        $Controller->set([
            'test' => 'value',
            '_serialize' => ['test']
        ]);
        $debug = Configure::read('debug');
        Configure::write('debug', false);
        $result = $Controller->render('index');
        $this->assertEquals('{"test":"value"}', $result->body());
        Configure::write('debug', $debug);
    }

    /**
     * test that a component beforeRender can change the controller view class.
     *
     * @return void
     */
    public function testBeforeRenderEventCancelsRender()
    {
        $Controller = new Controller(new Request, new Response());

        $Controller->eventManager()->attach(function ($event) {
            return false;
        }, 'Controller.beforeRender');

        $result = $Controller->render('index');
        $this->assertInstanceOf('Cake\Network\Response', $result);
    }

    /**
     * Generates status codes for redirect test.
     *
     * @return void
     */
    public static function statusCodeProvider()
    {
        return [
            [300, "Multiple Choices"],
            [301, "Moved Permanently"],
            [302, "Found"],
            [303, "See Other"],
            [304, "Not Modified"],
            [305, "Use Proxy"],
            [307, "Temporary Redirect"],
            [403, "Forbidden"],
        ];
    }

    /**
     * testRedirect method
     *
     * @dataProvider statusCodeProvider
     * @return void
     */
    public function testRedirectByCode($code, $msg)
    {
        $Controller = new Controller(null, new Response());

        $response = $Controller->redirect('http://cakephp.org', (int)$code);
        $this->assertEquals($code, $response->statusCode());
        $this->assertEquals('http://cakephp.org', $response->header()['Location']);
        $this->assertFalse($Controller->autoRender);
    }

    /**
     * test that beforeRedirect callbacks can set the URL that is being redirected to.
     *
     * @return void
     */
    public function testRedirectBeforeRedirectModifyingUrl()
    {
        $Controller = new Controller(null, new Response());

        $Controller->eventManager()->attach(function ($event, $url, $response) {
            $response->location('http://book.cakephp.org');
        }, 'Controller.beforeRedirect');

        $response = $Controller->redirect('http://cakephp.org', 301);
        $this->assertEquals('http://book.cakephp.org', $response->header()['Location']);
        $this->assertEquals(301, $response->statusCode());
    }

    /**
     * test that beforeRedirect callback returning null doesn't affect things.
     *
     * @return void
     */
    public function testRedirectBeforeRedirectModifyingStatusCode()
    {
        $Response = $this->getMock('Cake\Network\Response', ['stop']);
        $Controller = new Controller(null, $Response);

        $Controller->eventManager()->attach(function ($event, $url, $response) {
            $response->statusCode(302);
        }, 'Controller.beforeRedirect');

        $response = $Controller->redirect('http://cakephp.org', 301);

        $this->assertEquals('http://cakephp.org', $response->header()['Location']);
        $this->assertEquals(302, $response->statusCode());
    }

    public function testRedirectBeforeRedirectListenerReturnResponse()
    {
        $Response = $this->getMock('Cake\Network\Response', ['stop', 'header', 'statusCode']);
        $Controller = new Controller(null, $Response);

        $newResponse = new Response;
        $Controller->eventManager()->on('Controller.beforeRedirect', function ($event, $url, $response) use ($newResponse) {
            return $newResponse;
        });

        $result = $Controller->redirect('http://cakephp.org');
        $this->assertSame($newResponse, $result);
    }

    /**
     * testMergeVars method
     *
     * @return void
     */
    public function testMergeVars()
    {
        $request = new Request();
        $TestController = new TestController($request);

        $expected = [
            'Html' => null,
        ];
        $this->assertEquals($expected, $TestController->helpers);

        $expected = [
            'Security' => null,
            'Cookie' => null,
        ];
        $this->assertEquals($expected, $TestController->components);

        $TestController = new AnotherTestController($request);
        $this->assertEquals(
            'Posts',
            $TestController->modelClass,
            'modelClass should not be overwritten when defined.'
        );
    }

    /**
     * testReferer method
     *
     * @return void
     */
    public function testReferer()
    {
        $request = $this->getMock('Cake\Network\Request', ['referer']);
        $request->expects($this->any())->method('referer')
            ->with(true)
            ->will($this->returnValue('/posts/index'));

        $Controller = new Controller($request);
        $result = $Controller->referer(null, true);
        $this->assertEquals('/posts/index', $result);

        $request = $this->getMock('Cake\Network\Request', ['referer']);
        $request->expects($this->any())->method('referer')
            ->with(true)
            ->will($this->returnValue('/posts/index'));
        $Controller = new Controller($request);
        $result = $Controller->referer(['controller' => 'posts', 'action' => 'index'], true);
        $this->assertEquals('/posts/index', $result);

        $request = $this->getMock('Cake\Network\Request', ['referer']);

        $request->expects($this->any())->method('referer')
            ->with(false)
            ->will($this->returnValue('http://localhost/posts/index'));

        $Controller = new Controller($request);
        $result = $Controller->referer();
        $this->assertEquals('http://localhost/posts/index', $result);

        $Controller = new Controller(null);
        $result = $Controller->referer();
        $this->assertEquals('/', $result);
    }

    /**
     * Test that the referer is not absolute if it is '/'.
     *
     * This avoids the base path being applied twice on string urls.
     *
     * @return void
     */
    public function testRefererSlash()
    {
        $request = $this->getMock('Cake\Network\Request', ['referer']);
        $request->base = '/base';
        Router::pushRequest($request);

        $request->expects($this->any())->method('referer')
            ->will($this->returnValue('/'));

        $controller = new Controller($request);
        $result = $controller->referer('/', true);
        $this->assertEquals('/', $result);

        $controller = new Controller($request);
        $result = $controller->referer('/some/path', true);
        $this->assertEquals('/base/some/path', $result);
    }

    /**
     * testSetAction method
     *
     * @return void
     */
    public function testSetAction()
    {
        $request = new Request('controller_posts/index');

        $TestController = new TestController($request);
        $TestController->setAction('view', 1, 2);
        $expected = ['testId' => 1, 'test2Id' => 2];
        $this->assertSame($expected, $TestController->request->data);
        $this->assertSame('view', $TestController->request->params['action']);
    }

    /**
     * Tests that the startup process calls the correct functions
     *
     * @return void
     */
    public function testStartupProcess()
    {
        $eventManager = $this->getMock('Cake\Event\EventManager');
        $controller = new Controller(null, null, null, $eventManager);

        $eventManager->expects($this->at(0))->method('dispatch')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf('Cake\Event\Event'),
                    $this->attributeEqualTo('_name', 'Controller.initialize'),
                    $this->attributeEqualTo('_subject', $controller)
                )
            )
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $eventManager->expects($this->at(1))->method('dispatch')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf('Cake\Event\Event'),
                    $this->attributeEqualTo('_name', 'Controller.startup'),
                    $this->attributeEqualTo('_subject', $controller)
                )
            )
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $controller->startupProcess();
    }

    /**
     * Tests that the shutdown process calls the correct functions
     *
     * @return void
     */
    public function testShutdownProcess()
    {
        $eventManager = $this->getMock('Cake\Event\EventManager');
        $controller = new Controller(null, null, nu                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               