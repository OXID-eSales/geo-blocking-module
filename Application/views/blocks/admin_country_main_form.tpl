[{$smarty.block.parent}]

[{block name="oegeoblocking_admin_country_main"}]
    <tr>
        <td class="edittext">
            [{ oxmultilang ident="OEGEOBLOCKING_INVOICEONLY" }]
        </td>
        <td class="edittext">
            <input type="hidden" class="editinput" name="editval_gb[oegeoblocking_country_to_shop__invoice_only]" value="0">
            <input type="checkbox" class="editinput" name="editval_gb[oegeoblocking_country_to_shop__invoice_only]" value="1" [{if $invoiceCountry->oegeoblocking_country_to_shop__invoice_only->value}] checked [{/if}]" [{ $readonly }]>
            [{ oxinputhelp ident="OEGEOBLOCKING_INVOICEONLY_HELP" }]
        </td>
    </tr>
    </table>
    </br>

    <fieldset>
        <legend>[{ oxmultilang ident="OEGEOBLOCKING_ADMIN_PICKUP_ADDRESS" }]</legend>

        <input type="hidden" name="editval_gb[oegeoblocking_country_to_shop__pickup_addressid]" value="[{$invoiceCountry->oegeoblocking_country_to_shop__pickup_addressid->value }]">
        <input type="hidden" name="editval_gb[oxaddress__oxid]" value="[{$invoiceCountry->oegeoblocking_country_to_shop__pickup_addressid->value }]">

        <table>
                <tr>
                    <td class="edittext" width="70">
                    [{ oxmultilang ident="GENERAL_ACTIVE" }]
                    </td>
                    <td class="edittext">
                    <input type="hidden" name="editval_gb[oegeoblocking_country_to_shop__pickup_address_active]" value='0'>
                    <input class="edittext" type="checkbox" name="editval_gb[oegeoblocking_country_to_shop__pickup_address_active]" value='1' [{if $invoiceCountry->oegeoblocking_country_to_shop__pickup_address_active->value == 1}]checked[{/if}] [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_GENERAL_ACTIVE" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_BILLSAL" }]
                    </td>
                    <td class="edittext">
                      <select name="editval_gb[oxaddress__oxsal]" class="editinput" [{ $readonly }]>
                        <option value="" [{if $pickupAddress->oxaddress__oxsal->value|lower  == "-"  }]SELECTED[{/if}]>-</option>
                        <option value="MR"  [{if $pickupAddress->oxaddress__oxsal->value|lower  == "mr"  }]SELECTED[{/if}]>[{ oxmultilang ident="MR"  }]</option>
                        <option value="MRS" [{if $pickupAddress->oxaddress__oxsal->value|lower  == "mrs" }]SELECTED[{/if}]>[{ oxmultilang ident="MRS" }]</option>
                      </select>
                    [{ oxinputhelp ident="HELP_GENERAL_BILLSAL" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="USER_MAIN_NAME" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="10" maxlength="[{$pickupAddress->oxaddress__oxfname->fldmax_length}]" name="editval_gb[oxaddress__oxfname]" value="[{$pickupAddress->oxaddress__oxfname->value }]" [{ $readonly }]>
                    <input type="text" class="editinput" size="20" maxlength="[{$pickupAddress->oxaddress__oxlname->fldmax_length}]" name="editval_gb[oxaddress__oxlname]" value="[{$pickupAddress->oxaddress__oxlname->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_USER_MAIN_NAME" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_COMPANY" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="37" maxlength="[{$pickupAddress->oxaddress__oxcompany->fldmax_length}]" name="editval_gb[oxaddress__oxcompany]" value="[{$pickupAddress->oxaddress__oxcompany->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_GENERAL_COMPANY" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="USER_MAIN_STRNR" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="28" maxlength="[{$pickupAddress->oxaddress__oxstreet->fldmax_length}]" name="editval_gb[oxaddress__oxstreet]" value="[{$pickupAddress->oxaddress__oxstreet->value }]" [{ $readonly }]> <input type="text" class="editinput" size="5" maxlength="[{$pickupAddress->oxaddress__oxstreetnr->fldmax_length}]" name="editval_gb[oxaddress__oxstreetnr]" value="[{$pickupAddress->oxaddress__oxstreetnr->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_USER_MAIN_STRNR" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_ZIPCITY" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="5" maxlength="[{$pickupAddress->oxaddress__oxzip->fldmax_length}]" name="editval_gb[oxaddress__oxzip]" value="[{$pickupAddress->oxaddress__oxzip->value }]" [{ $readonly }]>
                    <input type="text" class="editinput" size="25" maxlength="[{$pickupAddress->oxaddress__oxcity->fldmax_length}]" name="editval_gb[oxaddress__oxcity]" value="[{$pickupAddress->oxaddress__oxcity->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_GENERAL_ZIPCITY" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_EXTRAINFO" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="37" maxlength="[{$pickupAddress->oxaddress__oxaddinfo->fldmax_length}]" name="editval_gb[oxaddress__oxaddinfo]" value="[{$pickupAddress->oxaddress__oxaddinfo->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_GENERAL_EXTRAINFO" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_COUNTRY" }]
                    </td>
                    <td class="edittext">
                     <select class="editinput" name="editval_gb[oxaddress__oxcountryid]" [{ $readonly }]>
                       <option value="">-</option>
                       [{foreach from=$countryList item=oCountry}]
                       <option value="[{$oCountry->oxcountry__oxid->value}]" [{if $oCountry->oxcountry__oxid->value == $pickupAddress->oxaddress__oxcountryid->value}]selected[{/if}]>[{$oCountry->oxcountry__oxtitle->value}]</option>
                       [{/foreach}]
                     </select>
                     [{ oxinputhelp ident="HELP_GENERAL_COUNTRY" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_TELEPHONE" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="20" maxlength="[{$pickupAddress->oxaddress__oxfon->fldmax_length}]" name="editval_gb[oxaddress__oxfon]" value="[{$pickupAddress->oxaddress__oxfon->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_GENERAL_TELEPHONE" }]
                    </td>
                </tr>
                <tr>
                    <td class="edittext">
                    [{ oxmultilang ident="GENERAL_FAX" }]
                    </td>
                    <td class="edittext">
                    <input type="text" class="editinput" size="20" maxlength="[{$pickupAddress->oxaddress__oxfax->fldmax_length}]" name="editval_gb[oxaddress__oxfax]" value="[{$pickupAddress->oxaddress__oxfax->value }]" [{ $readonly }]>
                    [{ oxinputhelp ident="HELP_GENERAL_FAX" }]
                    </td>
                </tr>
        </table>
        </fieldset>
[{/block}]

<br />
<table border="0" cellpadding="0" cellspacing="0">
    <colgroup width="125"></colgroup>
    <colgroup></colgroup>
