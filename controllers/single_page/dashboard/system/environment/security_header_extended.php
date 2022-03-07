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
    }

    protected function getPackageConfig(): ?Liaison
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

            $config = $this->getPackageConfig();
            $config->save('security', [
                'cross_origin_resource_policy' => $corp
            ]);

            $this->flash('success', t('The settings has been successfully updated.'));

            return $this->buildRedirect([$this->getPageObject()]);
        }
    }
}