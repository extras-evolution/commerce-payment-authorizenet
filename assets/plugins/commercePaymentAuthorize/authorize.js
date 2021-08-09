function initAuthorizaMask(){
    $('#cc-number').inputmask("9999-9999-9999-9999");
    $('#cc-expiration').inputmask("99/99");
    $('#cc-cvv').inputmask("999");

}
initAuthorizaMask()
$(document).on('form-reloaded.commerce', function(e) {

    initAuthorizaMask();

});