<?php

namespace Concrete\Package\MdSecurityHeaderExtended\Controller\SinglePage\Dashboard\System\Environment;

use Concrete\Core\Config\Repository\Liaison;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Page\Controller\DashboardPageController;

class SecurityHeaderExtended extends DashboardPageController
{
    public function view()
    {
        $this->set('corp', $this->getPackageConfig()->get('security.cross_origin_resource_policy'));
        $this->set('coop', $this->getPackageConfig()->get('security.cross_origin_opener_policy'));
        $this->set('coep', $this->getPackageConfig()->get('security.cross_origin_embedder_policy'));
        $this->set('accessControlAllowOrigin', $this->getPackageConfig()->get('security.access_control_allow_origin'));
    }

    protected function getPackageConfig()
    {
        /** @var PackageService $packageService */
        $packageService = $this->app->make(PackageService::class);
        $package = $packageService->getClass('md_security_header_extended');
        return $package->getFileConfig();
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

            $config = $this->getPackageConfig();
            $config->save('security', [
                'cross_origin_resource_policy' => $corp,
                'cross_origin_opener_policy' => $coop,
                'cross_origin_embedder_policy' => $coep,
                'access_control_allow_origin' => $accessControlAllowOrigin
            ]);

            $this->flash('success', t('The settings has been successfully updated.'));

            return $this->redirect('/dashboard/system/environment/security_header_extended');
        }
    }
}