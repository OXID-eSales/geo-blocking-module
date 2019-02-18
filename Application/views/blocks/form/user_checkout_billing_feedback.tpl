[{$smarty.block.parent}]

[{block name="oegeoblocking_user_checkout_billing_feedback"}]
    <div class="col-lg-9 col-lg-offset-3 offset-lg-3">
        <style>
            .invoiceonlyhint {
                margin-bottom: 0;
            }
        </style>
        <div id="oegb-hint-message"  class="invoiceonlyhint hidden alert alert-warning">
            [{oxmultilang ident="OEGEOBLOCKING_HINT"}]
        </div>
    </div>
[{/block}]
