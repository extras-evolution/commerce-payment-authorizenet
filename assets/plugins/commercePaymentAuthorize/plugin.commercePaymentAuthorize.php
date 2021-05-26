<?php
if (empty($modx->commerce) && !defined('COMMERCE_INITIALIZED')) {
    return;
}


$isSelectedPayment = !empty($order['fields']['payment_method']) && $order['fields']['payment_method'] == 'authorize';

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