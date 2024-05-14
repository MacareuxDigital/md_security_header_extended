<?php

namespace Concrete\Package\MdSecurityHeaderExtended;

use Concrete\Core\Http\ServerInterface;
use Concrete\Core\Package\Package;
use Macareux\SecurityHeaderExtended\Http\Middleware\AccessControlAllowOriginPolicyMiddleware;
use Macareux\SecurityHeaderExtended\Http\Middleware\ContentTypeOptionsMiddleware;
use Macareux\SecurityHeaderExtended\Http\Middleware\CrossOriginEmbedderPolicyMiddleware;
use Macareux\SecurityHeaderExtended\Http\Middleware\CrossOriginOpenerPolicyMiddleware;
use Macareux\SecurityHeaderExtended\Http\Middleware\CrossOriginResourcePolicyMiddleware;

class Controller extends Package
{
    /**
     * The minimum concrete5 version compatible with this package.
     *
     * @var string
     */
    protected $appVersionRequired = '8.5.0';

    /**
     * The handle of this package.
     *
     * @var string
     */
    protected $pkgHandle = 'md_security_header_extended';

    /**
     * The version number of this package.
     *
     * @var string
     */
    protected $pkgVersion = '1.1.0';

    /**
     * @see https://documentation.concretecms.org/developers/packages/adding-custom-code-to-packages
     *
     * @var string[]
     */
    protected $pkgAutoloaderRegistries = [
        'src' => '\Macareux\SecurityHeaderExtended',
    ];

    /**
     * Get the translated name of the package.
     *
     * @return string
     */
    public function getPackageName()
    {
        return t('Macareux Security Header Extended');
    }

    /**
     * Get the translated package description.
     *
     * @return string
     */
    public function getPackageDescription()
    {
        return t('This package makes you enable to add some security headers to mitigate some types of attacks.');
    }

    public function install()
    {
        $package = parent::install();

        $this->installContentFile('install/singlepages.xml');

        return $package;
    }

    public function on_start()
    {
        $config = $this->getFileConfig();
        /** @var ServerInterface $server */
        $server = $this->app->make(ServerInterface::class);

        $corp = $config->get('security.cross_origin_resource_policy', false);
        if ($corp) {
            $server->addMiddleware($this->app->make(CrossOriginResourcePolicyMiddleware::class, ['config' => $corp]));
        }

        $coop = $config->get('security.cross_origin_opener_policy', false);
        if ($coop) {
            $server->addMiddleware($this->app->make(CrossOriginOpenerPolicyMiddleware::class, ['config' => $coop]));
        }

        $coep = $config->get('security.cross_origin_embedder_policy', false);
        if ($coep) {
            $server->addMiddleware($this->app->make(CrossOriginEmbedderPolicyMiddleware::class, ['config' => $coep]));
        }

        $accessControlAllowOrigin = $config->get('security.access_control_allow_origin', false);
        if ($accessControlAllowOrigin) {
            $server->addMiddleware($this->app->make(AccessControlAllowOriginPolicyMiddleware::class, ['config' => $accessControlAllowOrigin]));
        }

        $nosniff = $config->get('security.x_content_type_options', false);
        if ($nosniff) {
            $server->addMiddleware($this->app->make(ContentTypeOptionsMiddleware::class, ['config' => $nosniff]));
        }
    }
}