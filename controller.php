<?php

namespace Concrete\Package\MdSecurityHeaderExtended;

use Concrete\Core\Http\ServerInterface;
use Concrete\Core\Package\Package;
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
    protected $pkgVersion = '0.0.1';

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
        return t('CORP header, etc.');
    }

    public function install()
    {
        $package = parent::install();

        $this->installContentFile('install/singlepages.xml');

        return $package;
    }

    public function on_start()
    {
        $corp = $this->getFileConfig()->get('security.cross_origin_resource_policy', false);
        if ($corp) {
            /** @var ServerInterface $server */
            $server = $this->app->make(ServerInterface::class);
            $server->addMiddleware($this->app->make(CrossOriginResourcePolicyMiddleware::class, ['config' => $corp]));
        }
    }
}