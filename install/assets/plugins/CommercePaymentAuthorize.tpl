//<?php
/**
 * CommercePaymentAuthorize
 *
 * CommercePaymentAuthorize solution
 *
 * @category    plugin
 * @version     0.0.1
 * @author      DDAProduction
 * @internal    @events OnRegisterPayments
 * @internal    @properties &title=Payment method title;text;Authorize &api_login_id=Api login id;text; &transaction_key=Transaction key;text; &paymentPageId=Payment page id;text; &log_info_messages=Log info messages (1|0);text;1 &convert_to=Currency to which need conver order, when original order currency not support, blank where dont create payment;text;USD
 * @internal    @modx_category Commerce
 * @internal    @disabled 0
 * @internal    @installset base
*/

require MODX_BASE_PATH.'assets/plugins/commercePaymentAuthorize/plugin.commercePaymentAuthorize.php';