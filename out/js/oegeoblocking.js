/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */
var oeGeoBlocking = {
    isCountryInvoiceOnly: 0,

    /**
     * Initializes after document.ready.
     */
    init: function() {
        if ($('#invCountrySelect').length > 0) {
            // event listener: selected invoice country has changed
            $(document.body).off('change', "#invCountrySelect", oeGeoBlocking.checkInvoiceCountry);
            $(document.body).on('change', "#invCountrySelect", oeGeoBlocking.checkInvoiceCountry);

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
            // Country is marked as "invoice only"
            if (!$('#shippingAddress').is(':visible')) {
                $('#showShipAddress').click();
            }
            $('.invoiceonlyhint').removeClass('hidden');
            $('#showShipAddress').attr("disabled", "disabled");
        } else {
            // Country is NOT marked as "invoice only"
            $('.invoiceonlyhint').addClass('hidden');
            $('#showShipAddress').removeAttr("disabled");
        }
    },
};

/*
 * ON DOCUMENT READY
 * =================================================================================================================== */
$(document).ready(function() {
    oeGeoBlocking.init();
});
