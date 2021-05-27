<div class="payment-card">
    <div>Online payment</div>
    <p>Please indicate the card for payment and click the "Pay" button</p>

    [[if? &is=`[+error+]:!empty` &then=`
    <div class="alert alert-danger" role="alert">
        [+error+]
    </div>
    `]]

    [[if? &is=`[+success+]:!empty` &then=`
    <div class="alert alert-success" role="alert">
        [+success+]
    </div>
    `]]

    <form action="?payment_hash=[+payment_hash+]" method="post">
        <div class="row">

            <div class="mb-12">
                <label for="cc-number">Credit card number</label>
                <input type="text" class="form-control" id="cc-number" name="number" placeholder="" value="[+number+]" >
                <div class="invalid-feedback">
                    Credit card number is required
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="cc-expiration">Expiration</label>
                    <input type="text" class="form-control" id="cc-expiration" name="expiration" placeholder="" value="[+expiration+]" >
                <div class="invalid-feedback">
                    Expiration date required
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="cc-expiration">CVV</label>
                <input type="text" class="form-control" id="cc-cvv" name="cvv" placeholder="" value="[+cvv+]" >
                <div class="invalid-feedback">
                    Security code required
                </div>
            </div>
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
    </form>

</div>