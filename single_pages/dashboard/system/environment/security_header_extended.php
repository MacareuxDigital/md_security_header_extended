<?php

defined('C5_EXECUTE') or die('Access Denied.');

/** @var \Concrete\Core\View\View $view */
/** @var \Concrete\Core\Validation\CSRF\Token $token */
/** @var \Concrete\Core\Form\Service\Form $form */

$corp = $corp ?? null;
$corpOptions = [
    '' => t('** Not Set'),
    'same-site' => 'same-site',
    'same-origin' => 'same-origin',
    'cross-origin' => 'cross-origin',
];
?>
<div class="alert alert-warning">
    <?php echo t('Changing these values may block users from accessing your site. Please change it at your own risk.'); ?>
</div>
<form action="<?= $view->action('submit') ?>" method="post">
    <?php $token->output('update_security_header_extended'); ?>

    <div class="form-group">
        <?= $form->label('corp', t('Content Security Policy (CSP)')) ?>
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

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="submit" class="btn btn-primary float-end pull-right">
                <?php echo t('Save') ?>
            </button>
        </div>
    </div>
</form>
