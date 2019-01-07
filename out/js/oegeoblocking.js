/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */
var oeGeoBlocking = {
    isCountryInvoiceOnly: 0,
    selectedCountryId: false,

    /**
     * Initializes after document.ready.
     */
    init: function() {
        if ($('#invCountrySelect').length > 0) {
            // event listener: selected invoice country has changed
            $(document.body).off('change', "#invCountrySelect", oeGeoBlocking.checkInvoiceCountry);
            $(document.body).on('change', "#invCountrySelect", oeGeoBlocking.checkInvoiceCountry);

            // event listener: edit invoice address has been clicked
            $('#userChangeAddress').off('click', oeGeoBlocking.checkInvoiceCountry);
            $('#userChangeAddress').on('click', oeGeoBlocking.checkInvoiceCountry);

            // initial check
            oeGeoBlocking.checkInvoiceCountry();
        }
    },

    /**
     * Is called every time when the selected invoice country changes and once initially.
     */
    checkInvoiceCountry: function() {
        oeGeoBlocking.isCountryInvoiceOnly = $("#invCountrySelect").find(':selected').data('invoiceonly');

        if (oeGeoBlocking.isCountryInvoiceOnly == 1) {
            // country is marked as "invoice only"
            if (!$('#shippingAddress').is(':visible')) {
                $('#showShipAddress').click();
            }
            $('.invoiceonlyhint').removeClass('hidden');
            $('#showShipAddress').attr("disabled", "disabled");
        } else {
            // country is NOT marked as "invoice only"
            if ($('#shippingAddress').is(':visible')) {
                $('#showShipAddress').removeAttr("disabled");
                $('.invoiceonlyhint').addClass('hidden');
            } else {
                $('#showShipAddress').removeAttr("disabled");
                $('.invoiceonlyhint').addClass('hidden');
            }
        }
    },
};

/*
 * ON DOCUMENT READY
 * =================================================================================================================== */
$(document).ready(function() {
    oeGeoBlocking.init();
});
