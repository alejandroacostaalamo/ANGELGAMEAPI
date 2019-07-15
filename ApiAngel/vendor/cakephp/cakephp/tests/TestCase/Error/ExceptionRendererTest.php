<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\Error;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Controller\Exception\MissingActionException;
use Cake\Controller\Exception\MissingComponentException;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception as CakeException;
use Cake\Core\Exception\MissingPluginException;
use Cake\Core\Plugin;
use Cake\Datasource\Exception\MissingDatasourceConfigException;
use Cake\Datasource\Exception\MissingDatasourceException;
use Cake\Error\ExceptionRenderer;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Mailer\Exception\MissingActionException as MissingMailerActionException;
use Cake\Network\Exception\InternalErrorException;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\SocketException;
use Cake\Network\Request;
use Cake\ORM\Exception\MissingBehaviorException;
use Cake\Routing\Exception\MissingControllerException;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use Cake\View\Exception\MissingHelperException;
use Cake\View\Exception\MissingLayoutException;
use Cake\View\Exception\MissingTemplateException;
use Exception;
use RuntimeException;

/**
 * BlueberryComponent class
 *
 */
class BlueberryComponent extends Component
{

    /**
     * testName property
     *
     * @return void
     */
    public $testName = null;

    /**
     * initialize method
     *
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->testName = 'BlueberryComponent';
    }
}

/**
 * TestErrorController class
 *
 */
class TestErrorController extends Controller
{

    /**
     * uses property
     *
     * @var array
     */
    public $uses = [];

    /**
     * components property
     *
     * @return void
     */
    public $components = ['Blueberry'];

    /**
     * beforeRender method
     *
     * @return void
     */
    public function beforeRender(Event $event)
    {
        echo $this->Blueberry->testName;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $this->autoRender = false;
        return 'what up';
    }
}

/**
 * MyCustomExceptionRenderer class
 *
 */
class MyCustomExceptionRenderer extends ExceptionRenderer
{

    /**
     * custom error message type.
     *
     * @return void
     */
    public function missingWidgetThing()
    {
        return 'widget thing is missing';
    }
}

/**
 * Exception class for testing app error handlers and custom errors.
 *
 */
class MissingWidgetThingException extends NotFoundException
{
}

/**
 * Exception class for testing app error handlers and custom errors.
 *
 */
class MissingWidgetThing extends \Exception
{
}

/**
 * ExceptionRendererTest class
 *
 */
class ExceptionRendererTest extends TestCase
{

    /**
     * @var bool
     */
    protected $_restoreError = false;

    /**
     * setup create a request object to get out of router later.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        Configure::write('Config.language', 'eng');
        Router::reload();

        $request = new Request();
        $request->base = '';
        Router::setRequestInfo($request);
        Configure::write('debug', true);
    }

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        if ($this->_restoreError) {
            restore_error_handler();
        }
    }

    /**
     * Mocks out the response on the ExceptionRenderer object so headers aren't modified.
     *
     * @return void
     */
    protected function _mockResponse($error)
    {
        $error->controller->response = $this->getMock('Cake\Network\Response', ['_sendHeader']);
        return $error;
    }

    /**
     * test that methods declared in an ExceptionRenderer subclass are not converted
     * into error400 when debug > 0
     *
     * @return void
     */
    public function testSubclassMethodsNotBeingConvertedToError()
    {
        $exception = new MissingWidgetThingException('Widget not found');
        $ExceptionRenderer = $this->_mockResponse(new MyCustomExceptionRenderer($exception));

        $result = $ExceptionRenderer->render();

        $this->assertEquals('widget thing is missing', $result->body());
    }

    /**
     * test that subclass methods are not converted when debug = 0
     *
     * @return void
     */
    public function testSubclassMethodsNotBeingConvertedDebug0()
    {
        Configure::write('debug', false);
        $exception = new MissingWidgetThingException('Widget not found');
        $ExceptionRenderer = $this->_mockResponse(new MyCustomExceptionRenderer($exception));

        $result = $ExceptionRenderer->render();

        $this->assertEquals('missingWidgetThing', $ExceptionRenderer->method);
        $this->assertEquals(
            'widget thing is missing',
            $result->body(),
            'Method declared in subclass converted to error400'
        );
    }

    /**
     * test that ExceptionRenderer subclasses properly convert framework errors.
     *
     * @return void
     */
    public function testSubclassConvertingFrameworkErrors()
    {
        Configure::write('debug', false);

        $exception = new MissingControllerException('PostsController');
        $ExceptionRenderer = $this->_mockResponse(new MyCustomExceptionRenderer($exception));

        $result = $ExceptionRenderer->render();

        $this->assertRegExp(
            '/Not Found/',
            $result->body(),
            'Method declared in error handler not converted to error400. %s'
        );
    }

    /**
     * test things in the constructor.
     *
     * @return void
     */
    public function testConstruction()
    {
        $exception = new NotFoundException('Page not found');
        $ExceptionRenderer = new ExceptionRenderer($exception);

        $this->assertInstanceOf('Cake\Controller\ErrorController', $ExceptionRenderer->controller);
        $this->assertEquals($exception, $ExceptionRenderer->error);
    }

    /**
     * test that exception message gets coerced when debug = 0
     *
     * @return void
     */
    public function testExceptionMessageCoercion()
    {
        Configure::write('debug', false);
        $exception = new MissingActionException('Secret info not to be leaked');
        $ExceptionRenderer = $this->_mockResponse(new ExceptionRenderer($exception));

        $this->assertInstanceOf('Cake\Controller\ErrorController', $ExceptionRenderer->controller);
        $this->assertEquals($exception, $ExceptionRenderer->error);

        $result = $ExceptionRenderer->render()->body();

        $this->assertEquals('error400', $ExceptionRenderer->template);
        $this->assertContains('Not Found', $result);
        $this->assertNotContains('Secret info not to be leaked', $result);
    }

    /**
     * test that helpers in custom CakeErrorController are not lost
     *
     * @return void
     */
    public function testCakeErrorHelpersNotLost()
    {
        Configure::write('App.namespace', 'TestApp');
        $exception = new SocketException('socket exception');
        $renderer = $this->_mockResponse(new \TestApp\Error\TestAppsExceptionRenderer($exception));

        $result = $renderer->render();
        $this->assertContains('<b>peeled</b>', $result->body());
    }

    /**
     * test that unknown exception types with valid status codes are treated correctly.
     *
     * @return void
     */
    public function testUnknownExceptionTypeWithExceptionThatHasA400Code()
    {
        $exception = new MissingWidgetThingException('coding fail.');
        $ExceptionRenderer = new ExceptionRenderer($exception);
        $ExceptionRenderer->controller->response = $this->getMock('Cake\Network\Response', ['statusCode', '_sendHeader']);
        $ExceptionRenderer->controller->response->expects($this->once())->method('statusCode')->with(404);

        $result = $ExceptionRenderer->render();

        $this->assertFalse(method_exists($ExceptionRenderer, 'missingWidgetThing'), 'no method should exist.');
        $this->assertContains('coding fail', $result->body(), 'Text should show up.');
    }

    /**
     * test that unknown exception types with valid status codes are treated correctly.
     *
     * @return void
     */
    public function testUnknownExceptionTypeWithNoCodeIsA500()
    {
        $exception = new \OutOfBoundsException('foul ball.');
        $ExceptionRenderer = new ExceptionRenderer($exception);
        $ExceptionRenderer->controller->response = $this->getMock('Cake\Network\Response', ['statusCode', '_sendHeader']);
        $ExceptionRenderer->controller->response->expects($this->once())
            ->method('statusCode')
            ->with(500);

        $result = $ExceptionRenderer->render();

        $this->assertContains('foul ball.', $result->body(), 'Text should show up as its debug mode.');
    }

    /**
     * test that unknown exceptions have messages ignored.
     *
     * @return void
     */
    public function testUnknownExceptionInProduction()
    {
        Configure::write('debug', false);

        $exception = new \OutOfBoundsException('foul ball.');
        $ExceptionRenderer = new ExceptionRenderer($exception);
        $ExceptionRenderer->controller->response = $this->getMock('Cake\Network\Response', ['statusCode', '_sendHeader']);
        $ExceptionRenderer->controller->response->expects($this->once())
            ->method('statusCode')
            ->with(500);

        $result = $ExceptionRenderer->render()->body();

        $this->assertNotContains('foul ball.', $result, 'Text should no show up.');
        $this->assertContains('Internal Error', $result, 'Generic message only.');
    }

    /**
     * test that unknown exception types with valid status codes are treated correctly.
     *
     * @return void
     */
    public function testUnknownExceptionTypeWithCodeHigherThan500()
    {
        $exception = new \OutOfBoundsException('foul ball.', 501);
        $ExceptionRenderer = new ExceptionRenderer($exception);
        $ExceptionRenderer->controller->response = $this->getMock('Cake\Network\Response', ['statusCode', '_sendHeader']);
        $ExceptionRenderer->controller->response->expects($this->once())->method('statusCode')->with(501);

        $result = $ExceptionRenderer->render();

        $this->assertContains('foul ball.', $result->body(), 'Text should show up as its debug mode.');
    }

    /**
     * testerror400 method
     *
     * @return void
     */
    public function testError400()
    {
        Router::reload();

        $request = new Request('posts/view/1000');
        Router::setRequestInfo($request);

        $exception = new NotFoundException('Custom message');
        $ExceptionRenderer = new ExceptionRenderer($exception);
        $ExceptionRenderer->controller->response = $this->getMock('Cake\Network\Response', ['statusCode', '_sendHeader']);
        $ExceptionRenderer->controller->response->expects($this->once())->method('statusCode')->with(404);

        $result = $ExceptionRenderer->render()->body();

        $this->assertContains('<h2>Custom message</h2>', $result);
        $this->assertRegExp("/<strong>'.*?\/posts\/view\/1000'<\/strong>/", $result);
    }

    /**
     * test that error400 only modifies the messages on Cake Exceptions.
     *
     * @return void
     */
    public function testerror400OnlyChangingCakeException()
    {
        Configure::write('debug', false);

        $exception = new NotFoundException('Custom message');
        $ExceptionRenderer = $this->_mockResponse(new ExceptionRenderer($exception));

        $result = $ExceptionRenderer->render();
        $this->assertContains('Custom message', $result->body());

        $exception = new MissingActionException(['controller' => 'PostsController', 'action' => 'index']);
        $ExceptionRenderer = $this->_mockResponse(new ExceptionRenderer($exception));

        $result = $ExceptionRenderer->render();
        $this->assertContains('Not Found', $result->body());
    }

    /**
     * test that error400 doesn't expose XSS
     *
     * @return void
     */
    public function testError400NoInjection()
    {
        Router::reload();

        $request = new Request('pages/<span id=333>pink</span></id><script>document.body.style.background = t=document.getElementById(333).innerHTML;window.alert(t);</script>');
        Router::setRequestInfo($request);

        $exception = new NotFoundException('Custom message');
        $ExceptionRenderer = $this->_mockResponse(new ExceptionRenderer($exception));

        $result = $ExceptionRenderer->render()->body();

        $this->assertNotContains('<script>document', $result);
        $this->assertNotContains('alert(t);</script>', $result);
    }

    /**
     * testError500 method
     *
     * @return void
     */
    public function testError500Message()
    {
        $exception = new InternalErrorException('An Internal Error Has Occurred.');
        $ExceptionRenderer = new ExceptionRenderer($exception);
        $ExceptionRenderer->controller->response = $this->getMock('Cake\Network\Response', ['statusCode', '_sendHeader']);
        $ExceptionRenderer->controller->response->expects($this->once())->method('statusCode')->with(500);

        $result = $ExceptionRenderer->render();
        $this->assertContains('<h2>An Internal Error Has Occurred.</h2>', $result->body());
        $this->assertContains('An Internal Error Has Occurred.</p>', $result->body());
    }

    /**
     * testExceptionResponseHeader method
     *
     * @return void
     */
    public function testExceptionResponseHeader()
    {
        $exception = new MethodNotAllowedException('Only allowing POST and DELETE');
        $exception->responseHeader(['Allow: POST, DELETE']);
        $ExceptionRenderer = new ExceptionRenderer($exception);

        $result = $ExceptionRenderer->render();
        $headers = $result->header();
        $this->assertArrayHasKey('Allow', $headers);
        $this->assertEquals('POST, DELETE', $headers['Allow']);
    }

    /**
     * testMissingController method
     *
     * @return void
     */
    public function testMissingController()
    {
        $exception = new MissingControllerException([
            'class' => 'Posts',
            'prefix' => '',
            'plugin' => '',
        ]);
        $ExceptionRenderer = $this->_mockResponse(new MyCustomExceptionRenderer($exception));

        $result = $ExceptionRenderer->render()->body();

        $this->assertEquals('missingController', $ExceptionRenderer->template);
        $this->assertContains('Missing Controller', $result);
        $this->assertContains('<em>PostsController</em>', $result);
    }

    /**
     * Returns an array of tests to run for the various Cake Exception classes.
     *
     * @return array
     */
    public static function exceptionProvider()
    {
        return [
            [
                new MissingActionException([
                    'controller' => 'PostsController',
                    'action' => 'index',
                    'prefix' => '',
                    'plugin' => '',
                ]),
                [
                    '/Missing Method in PostsController/',
                    '/<em>PostsController::index\(\)<\/em>/'
                ],
                404
            ],
            [
                new MissingTemplateException(['file' => '/posts/about.ctp']),
                [
                    "/posts\/about.ctp/"
                ],
                500
            ],
            [
                new MissingLayoutException(['file' => 'layouts/my_layout.ctp']),
                [
                    "/Missing Layout/",
                    "/layouts\/my_layout.ctp/"
                ],
                500
            ],
            [
                new MissingHelperException(['class' => 'MyCustomHelper']),
                [
                    '/Missing Helper/',
                    '/<em>MyCustomHelper<\/em> could not be found./',
                    '/Create the class <em>MyCustomHelper<\/em> below in file:/',
                    '/(\/|\\\)MyCustomHelper.php/'
                ],
                500
            ],
            [
                new MissingBehaviorException(['class' => 'MyCustomBehavior']),
                [
                    '/Missing Behavior/',
                    '/Create the class <em>MyCustomBehavior<\/em> below in file:/',
                    '/(\/|\\\)MyCustomBehavior.php/'
                ],
                500
            ],
            [
                new MissingComponentException(['class' => 'SideboxComponent']),
                [
                    '/Missing Component/',
                    '/Create the class <em>SideboxComponent<\/em> below in file:/',
                    '/(\/|\\\)SideboxComponent.php/'
                ],
                500
            ],
            [
                new MissingDatasourceConfigException(['name' => 'MyDatasourceConfig']),
                [
                    '/Missing Datasource Configuration/',
                    '/<em>MyDatasourceConfig<\/em> was not found/'
                ],
                500
            ],
            [
                new MissingDatasourceException(['class' => 'MyDatasource', 'plugin' => 'MyPlugin']),
                [
                    '/Missing Datasource/',
                    '/<em>MyPlugin.MyDatasource<\/em> could not be found./'
                ],
                500
            ],
            [
                new MissingMailerActionException([
                    'mailer' => 'UserMailer',
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      