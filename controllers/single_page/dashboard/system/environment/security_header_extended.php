<?php

namespace Concrete\Package\MdSecurityHeaderExtended\Controller\SinglePage\Dashboard\System\Environment;

use Concrete\Core\Config\Repository\Liaison;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Page\Controller\DashboardPageController;

class SecurityHeaderExtended extends DashboardPageController
{
    protected $pkgConfig;

    public function view()
    {
        $pkgConfig = $this->getPackageConfig();
        $this->set('corp', $pkgConfig->get('security.cross_origin_resource_policy'));
        $this->set('coop', $pkgConfig->get('security.cross_origin_opener_policy'));
        $this->set('coep', $pkgConfig->get('security.cross_origin_embedder_policy'));
        $this->set('accessControlAllowOrigin', $pkgConfig->get('security.access_control_allow_origin'));
        $this->set('nosniff', $pkgConfig->get('security.x_content_type_options'));
    }

    protected function getPackageConfig()
    {
        if (!$this->pkgConfig) {
            /** @var PackageService $packageService */
            $packageService = $this->app->make(PackageService::class);
            $package = $packageService->getClass('md_security_header_extended');
            $this->pkgConfig = $package->getFileConfig();
        }

        return $this->pkgConfig;
    }

    public function submit()
    {
        if (!$this->token->validate('update_security_header_extended')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has()) {
            $corp = trim($this->post('corp'));
            if (empty($corp)) {
                $corp = false;
            }
            $coop = trim($this->post('coop'));
            if (empty($coop)) {
                $coop = false;
            }
            $coep = trim($this->post('coep'));
            if (empty($coep)) {
                $coep = false;
            }
            $accessControlAllowOrigin = trim($this->post('accessControlAllowOrigin'));
            if (empty($accessControlAllowOrigin)) {
                $accessControlAllowOrigin = false;
            }
            $nosniff = trim($this->post('nosniff'));
            if (empty($nosniff)) {
                $nosniff = false;
            }

            $config = $this->getPackageConfig();
            $config->save('security', [
                'cross_origin_resource_policy' => $corp,
                'cross_origin_opener_policy' => $coop,
                'cross_origin_embedder_policy' => $coep,
                'access_control_allow_origin' => $accessControlAllowOrigin,
                'x_content_type_options' => $nosniff,
            ]);

            $this->flash('success', t('The settings has been successfully updated.'));

            return $this->redirect('/dashboard/system/environment/security_header_extended');
        }
    }
}

