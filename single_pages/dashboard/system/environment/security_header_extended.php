<?php

defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var \Concrete\Core\Form\Service\Form $form */

$corp = isset($corp) ? $corp : null;
$corpOptions = [
    '' => t('** Not Set'),
    'same-site' => 'same-site',
    'same-origin' => 'same-origin',
    'cross-origin' => 'cross-origin',
];
$coop = isset($coop) ? $coop : null;
$coopOptions = [
    '' => t('** Not Set'),
    'unsafe-none' => 'unsafe-none',
    'same-origin-allow-popups' => 'same-origin-allow-popups',
    'same-origin' => 'same-origin',
];
$coep = isset($coep) ? $coep : null;
$coepOptions = [
    '' => t('** Not Set'),
    'unsafe-none' => 'unsafe-none',
    'require-corp' => 'require-corp',
];
$accessControlAllowOrigin = isset($accessControlAllowOrigin) ? $accessControlAllowOrigin : null;

$site = app('site')->getSite();
/* @var \Concrete\Core\Entity\Site\Site|null $site */
?>
<div class="alert alert-warning">
    <?php echo t('Changing these values may block users from accessing your site. Please change it at your own risk.'); ?>
</div>
<form action="<?= $view->action('submit') ?>" method="post">
    <?php $token->output('update_security_header_extended'); ?>

    <div class="form-group">
        <?= $form->label('corp', t('Cross-Origin Resource Policy (CORP)')) ?>
        <?= $form->select('corp', $corpOptions, $corp) ?>
        <div class="help-block">
            <p><?= t('Cross-Origin Resource Policy (CORP) helps mitigate speculative site-channel attack, like Spectre, as well as Cross-Site Script Inclusion attacks.') ?></p>
            <p><?= t('See also:') ?></p>
            <ul>
                <li><a href="https://www.concretecms.com/about/blog/security/cve-2021-22954-and-mitigations-below-concrete-version-9" target="_blank">ConcreteCMS.org: CVE-2021-22954 and mitigations below Concrete Version 9</a></li>
                <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Cross-Origin_Resource_Policy_(CORP)" target="_blank">MDN Web Docs: Cross-Origin Resource Policy (CORP)</a></li>
                <li><a href="https://cheatsheetseries.owasp.org/cheatsheets/HTTP_Headers_Cheat_Sheet.html" target="_blank">OWASP Cheat Sheet Series: HTTP Security Response Headers Cheat Sheet</a></li>
            </ul>
        </div>
    </div>

    <div class="form-group">
        <?= $form->label('coop', t('Cross-Origin-Opener-Policy (COOP)')) ?>
        <?= $form->select('coop', $coopOptions, $coop) ?>
        <div class="help-block">
            <p><?= t('Cross-Origin-Opener-Policy (COOP) response header allows you to ensure a top-level document does not share a browsing context group with cross-origin documents.') ?></p>
            <p><?= t('See also:') ?></p>
            <ul>
                <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Opener-Policy" target="_blank">MDN Web Docs: Cross-Origin-Opener-Policy</a></li>
                <li><a href="https://cheatsheetseries.owasp.org/cheatsheets/HTTP_Headers_Cheat_Sheet.html" target="_blank">OWASP Cheat Sheet Series: HTTP Security Response Headers Cheat Sheet</a></li>
            </ul>
        </div>
    </div>

    <div class="form-group">
        <?= $form->label('coep', t('Cross-Origin-Embedder-Policy (COEP)')) ?>
        <?= $form->select('coep', $coepOptions, $coep) ?>
        <div class="help-block">
            <p><?= t("Cross-Origin-Embedder-Policy (COEP) response header prevents a document from loading any cross-origin resources that don't explicitly grant the document permission (using CORP or CORS).") ?></p>
            <p><?= t('See also:') ?></p>
            <ul>
                <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Embedder-Policy" target="_blank">MDN Web Docs: Cross-Origin-Embedder-Policy</a></li>
                <li><a href="https://cheatsheetseries.owasp.org/cheatsheets/HTTP_Headers_Cheat_Sheet.html" target="_blank">OWASP Cheat Sheet Series: HTTP Security Response Headers Cheat Sheet</a></li>
            </ul>
        </div>
    </div>

    <div class="form-group">
        <?= $form->label('accessControlAllowOrigin', t('Access-Control-Allow-Origin')) ?>
        <?= $form->text('accessControlAllowOrigin', $accessControlAllowOrigin, ['placeholder' => $site->getSiteCanonicalURL()]) ?>
        <div class="help-block">
            <p><?= t('Access-Control-Allow-Origin response header indicates whether the response can be shared with requesting code from the given origin.') ?></p>
            <p><?= t('See also:') ?></p>
            <ul>
                <li><a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin" target="_blank">MDN Web Docs: Access-Control-Allow-Origin</a></li>
                <li><a href="https://cheatsheetseries.owasp.org/cheatsheets/HTTP_Headers_Cheat_Sheet.html" target="_blank">OWASP Cheat Sheet Series: HTTP Security Response Headers Cheat Sheet</a></li>
            </ul>
        </div>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="submit" class="btn btn-primary float-end pull-right">
                <?php echo t('Save') ?>
            </button>
        </div>
    </div>
</form>
