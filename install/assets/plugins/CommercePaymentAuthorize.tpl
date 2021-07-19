//<?php
/**
 * CommercePaymentAuthorize
 *
 * CommercePaymentAuthorize solution
 *
 * @category    plugin
 * @internal    @events OnRegisterPayments,OnOrderProcessed
 * @internal    @modx_category Commerce
 * @internal    @properties &title=Payment method title;text;Authorize &api_login_id=Api login id;text; &transaction_key=Transaction key;text; &markup_tpl=Markup template;text; &pay_on_order=Pay on order page;list;||Yes==1||No==0;1 &paymentPageId=Payment page id;text; &log_info_messages=Log info messages (1|0);text;1 &convert_to=Currency to which need conver order, when original order currency not support, blank where dont create payment;text;USD
 * @internal    @disabled 0
 * @internal    @installset base
 */
require MODX_BASE_PATH.'assets/plugins/commercePaymentAuthorize/plugin.commercePaymentAuthorize.php';
