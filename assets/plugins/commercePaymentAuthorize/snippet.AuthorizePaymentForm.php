<?php

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

$tpl = isset($tpl) ? $tpl : '@FILE:paymentFormTemplate';
$render = DLTemplate::getInstance($modx);
$render->setTemplatePath('assets/plugins/commercePaymentAuthorize/');
$render->setTemplateExtension('tpl');

$pluginParams = $modx->parseProperties($modx->pluginCache['commercePaymentAuthorizeProps'], 'commercePaymentAuthorize', 'plugin');

$paymentHash = $_GET['payment_hash'];

/** @var \Commerce\Commerce $commerce */
$commerce = ci()->commerce;

/** @var \Commerce\Payments\AuthorizePayment $paymentProcessor */
$paymentProcessor = $commerce->getPayment('authorize')['processor'];
$lang = $commerce->getUserLanguage('authorize');

$error = $success = '';


if($_POST){
    try {
        $paymentProcessor->charge($paymentHash,$_POST);
        $success = $lang['authorize.order_paid'];
    }
    catch (Exception $e){
        $error = $e->getMessage();
    }

}

return $render->parseChunk($tpl, [
    'success'=>$success,
    'error'=>$error,

    'payment_hash' => $_GET['payment_hash']
]);
