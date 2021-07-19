<?php
if (empty($modx->commerce) && !defined('COMMERCE_INITIALIZED')) {
    return;
}
$isSelectedPayment = !empty($order['fields']['payment_method']) && $order['fields']['payment_method'] == 'authorize';

$commerceConfig = json_decode($modx->pluginCache['CommerceProps'], true);

/** @var \Commerce\Commerce $commerce */
$commerce = ci()->commerce;
$lang = $commerce->getUserLanguage('authorize');


switch ($modx->event->name) {
    case 'OnRegisterPayments':
    {
        $class = new \Commerce\Payments\AuthorizePayment($modx, $params);
        if (empty($params['title'])) {
            $params['title'] = $lang['authorize.caption'];
        }


        $commerce->registerPayment('authorize', $params['title'], $class);
        break;
    }

    case 'OnBeforeOrderSending':
    {
        if ($isSelectedPayment) {
            $FL->setPlaceholder('extra', $FL->getPlaceholder('extra', '') . $commerce->loadProcessor()->populateOrderPaymentLink());
        }

        break;
    }
    case 'OnOrderProcessed':

        /** @var $FL \FormLister\Form * */


        if ($FL->getField('payment_method') != 'authorize' || $params['pay_on_order'] == 0) {
            return;
        }

        $request = [
            'number' => $FL->getField('authorize-cc-number'),
            'expiration' => $FL->getField('authorize-cc-expiration'),
            'cvv' => $FL->getField('authorize-cc-cvv'),
        ];

        $authorizePayment = new \Commerce\Payments\AuthorizePayment($modx, $params);
        $payment = $authorizePayment->preparePayment($order['id']);

        try {

            $authorizePayment->charge($payment, $request);
            $FL->config->setConfig(['redirectTo' => $modx->makeUrl($commerceConfig['payment_success_page_id'])]);


        } catch (Exception $e) {

            $FL->config->setConfig(['redirectTo' => $modx->makeUrl($params['paymentPageId']) . '?' . http_build_query([
                    'payment_hash' => $payment['hash'],
                    'error' => 1
                ])]);
        }

        break;

    case 'OnManagerBeforeOrderRender':
    {
        if (isset($params['groups']['payment_delivery']) && $isSelectedPayment) {
            $params['groups']['payment_delivery']['fields']['payment_link'] = [
                'title' => $lang['authorize.link_caption'],
                'content' => function ($data) use ($commerce) {
                    return $commerce->loadProcessor()->populateOrderPaymentLink('@CODE:<a href="[+link+]" target="_blank">[+link+]</a>');
                },
                'sort' => 50,
            ];
        }
        break;
    }
}