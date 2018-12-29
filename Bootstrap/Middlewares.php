<?php

use App\Middleware\NotFound;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Middlewares\ContentEncoding;
use Middlewares\ContentLanguage;
use Middlewares\ContentType;
use Middlewares\CssMinifier;
use Middlewares\HtmlMinifier;
use Middlewares\JsMinifier;
use Middlewares\PhpSession;
use Middlewares\ResponseTime;
use Middlewares\Whoops;

/**
 * Middleware
 */
$app->addMiddleware(new Whoops());
//$session = new PhpSession();
//$session->id("xx")->regenerateId(10)->name("S_awa");
//// session start() hhhhhh
$app->addMiddleware(new App\Middleware\TrailingSlash($container));
$app->addMiddleware([
    new CssMinifier(),
    new JsMinifier(),
    new HtmlMinifier()
]);
$app->addMiddleware([
    new ContentType(),
    new ContentLanguage(['fr', 'en', 'ar']),
    new ContentEncoding(['gzip', 'deflate'])
]);
$app->addMiddleware(new ResponseTime());
$app->addMiddleware(new App\Middleware\Authentification($container));
$app->addMiddleware(new NotFound(function ($Response) use ($container) {
    // is html page not found
    $render = $container->get(RendererInterface::class)
            ->render("404", ["_page" => "404"]);
    $Response->getBody()->write($render);
    return $Response;
})
);
$app->addMiddleware($container->get(RouterInterface::class));





































