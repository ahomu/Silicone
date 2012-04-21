<?php

namespace Silicone;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\PHPTALServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\SessionServiceProvider;

use Silicone\Provider\DomainServiceProvider;
use Silicone\Provider\DatabaseServiceProvider;
use Silicone\Provider\FileReaderServiceProvider;

/**
 * The Silicone.
 *
 * @author Ayumu Sato <mail@ayumusato.com>
 *
 * @property \Symfony\Component\ClassLoader\UniversalClassLoader                        $autoloader
 * @property \Symfony\Component\Routing\RouteCollection                                 $routes
 * @property \Silex\ControllerCollection                                                $controllers
 * @property \Silex\ExceptionHandler                                                    $exception_handler
 * @property \Symfony\Component\EventDispatcher\EventDispatcher                         $dispatcher
 * @property \Silex\RedirectableUrlMatcher                                              $url_matcher
 * @property \Silex\ControllerResolver                                                  $resolver
 * @property \Symfony\Component\HttpKernel\HttpKernel                                   $kernel
 * @property \Symfony\Component\Routing\RequestContext                                  $request_context
 *
 * @property \Symfony\Component\Routing\Generator\UrlGenerator                          $url_generator
 * @property \PHPTAL                                                                    $phptal
 * @property \Silex\HttpCache                                                           $http_cache
 * @property \Symfony\Component\HttpFoundation\Session\Storage\NativeFileSessionStorage $session
 *
 * @property \Silicone\Component\Domain\ActionControllerCollection                      $domain @todo issue: ServiceProviderにする
 * @property \Silicone\Component\Database\HandlerFactory                                $db
 * @property \Silicone\Component\FileReader\FileReaderFactory                           $file_reader
 */
class Application extends \Silex\Application
{
    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config = array())
    {
        parent::__construct();

        // Debug
        if (!empty($config['debug'])) {
            $this['debug'] = true;
        }

        // Regsiter autloader
        $this['autoloader']->registerNamespace('Silicone', DIR_VENDOR);

        // Domain ['domain']
        $this->register(new DomainServiceProvider());

        // Url Generator ['url_generator']
        if (!empty($config['urlgen'])) {
            $this->register(new UrlGeneratorServiceProvider());
        }

        // PHPTAL ['phptal']
        if (!empty($config['phptal'])) {
            $this->register(new PHPTALServiceProvider(), $config['phptal']);
        }

        // Http Cache ['http_cache']
        if (!empty($config['cache'])) {
            $this->register(new HttpCacheServiceProvider(), $config['cache']);
        }

        // NativeSession ['session']
        if (!empty($config['session'])) {
            $this->register(new SessionServiceProvider(), $config['session']);
        }

        // Database ['db']
        if (!empty($config['db'])) {
            $this->register(new DatabaseServiceProvider(), $config['db']);
        }

        // FileReader ['file_reader']
        if (!empty($config['file_reader'])) {
            $this->register(new FileReaderServiceProvider());
        }
    }

    /**
     * Application running from web requests.
     *
     * @param null|\Symfony\Component\HttpFoundation\Request $request
     */
    public function run(Request $request = null)
    {
        $request = (null === $request) ? Request::createFromGlobals() : $request;

        $this->handle($request)->send();
    }

    /**
     * Application running from except web requests.
     *
     * @param string|\Symfony\Component\HttpFoundation\Request $pathOrRequest
     * @param string $method
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lan($pathOrRequest, $method = 'GET', $params = array())
    {
        if (!$pathOrRequest instanceof Response) {
            $path = strpos($pathOrRequest, '/') !== 0 ? '/'.$pathOrRequest : $pathOrRequest;
            $req = Request::create($path, $method, $params);
        } else {
            $req = $pathOrRequest;
        }

        return $this->handle($req);
    }

    /**
     * Import helper namespace.
     *
     * @param string $helperName
     */
    public function importHelper($helperName)
    {
        $this['autoloader']->loadClass('Silicone\\Helper\\'.$helperName);
    }

    /*
     * Override Pimple's ArrayAccess implementation
     *
     * Why?
     *   $app['provider']->method() // <- Some IDE (e.g, PhpStorm) cannot understanding this syntax.
     *
     *   $app->provider->method()   // <- IDE can understanding this syntax! I'm loven'it!
     */
    private $values = array();

    public function __get($id)
    {
        return $this[$id];
    }

    public function offsetSet($id, $value)
    {
        $this->values[$id] = $value;
    }

    public function offsetGet($id)
    {
        if (!array_key_exists($id, $this->values)) {
            throw new \InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }
        return $this->values[$id] instanceof \Closure ? $this->values[$id]($this) : $this->values[$id];
    }

    public function offsetUnset($id)
    {
        unset($this->values[$id]);
    }

    public function offsetExists($id)
    {
        return isset($this->values[$id]);
    }
}
