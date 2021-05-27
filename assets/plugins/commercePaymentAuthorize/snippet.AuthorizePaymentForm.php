<?php
/** @var $modx DocumentParser */
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

$tpl = isset($tpl) ? $tpl : '@FILE:paymentFormTemplate';
$js = isset($js) ? $js : 1;


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

$request = $_POST;

if($request){

    try {
        $paymentProcessor->charge($paymentHash,$request);
        $modx->sendRedirect(MODX_BASE_URL . 'commerce/authorize/payment-success?paymentHash=' . $_REQUEST['payment_hash']);
    }
    catch (Exception $e){
        $error = $e->getMessage();
    }

}
if($js){
    $modx->regClientScript('assets/plugins/commercePaymentAuthorize/jquery.inputmask.min.js');

    $script = 'assets/plugins/commercePaymentAuthorize/authorize.js';

    $v = file_exists(MODX_BASE_PATH.$script)?filemtime(MODX_BASE_PATH.$script):'';
    $modx->regClientScript($script.'?v='.$v);
}
return $render->parseChunk($tpl, [
    'success'=>$success,
    'error'=>$error,

    'number' => isset($request['number'])?preg_replace('~[^0-9]~','',$request['number']):'',
    'expiration' => isset($request['expiration'])?preg_replace('~[^0-9-]~','',$request['expiration']):'',
    'cvv' => isset($request['cvv'])?intval($request['cvv']):'',

    'payment_hash' => $_GET['payment_hash']
]);
