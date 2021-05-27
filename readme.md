# CommercePaymentAuthorize
Plugin for receiving payments

## require
* php >=5.6
* evolution cms >= 1.4.12
* authorizenet/authorizenet

## install
1. Install plugin and snippet.
2. Create page where will be, and add `[!AuthorizePaymentForm!]` in page content
3. Get credentials from authorize.net.
4. In plugin settings fill credentials and created page id


## Snippet params
* tpl - payment form template.
  Possible values are the name of the template, indicative of the rules for setting templates in DocLister.  
  Default - `@FILE:paymentFormTemplate`
* js - add js scripts. Possible values (1,0).  Default - 1;



## Features 
If Authorize don't support order currency, amount will be convert to currency specified in plugin setting. 
If this currency don't specified in settings, the user will not redirected to payment form.
