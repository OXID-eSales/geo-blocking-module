[{$smarty.block.parent}]

[{block name="oegeoblocking_form_user_shipping_address_select"}]
    [{*Removes edit and delete buttons for shipping address which was entered by admin.*}]
    [{foreach from=$aUserAddresses item=address name="shippingAdresses"}]
        [{if !$address->oeGeoBlockingCanFrontendUserChange()}]
            [{assign var="scriptToHideDeleteEditButtons" value=
            '$("input[name=\'oxaddressid\'][value=\''|cat:$address->getId()|cat:'\']").parent().parent().parent().find(\'.panel-body button\').remove()'
            }]
            [{oxscript add=$scriptToHideDeleteEditButtons}]
        [{/if}]
    [{/foreach}]
[{/block}]
