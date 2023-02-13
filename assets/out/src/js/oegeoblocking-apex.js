/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

addSelectEventListener = () => {
    let invCountrySelect = document.querySelector('#invCountrySelect');

    invCountrySelect.addEventListener('click', checkInvoiceCountry);
    checkInvoiceCountry();
};

checkInvoiceCountry = () => {
    let invoiceonly = invCountrySelect.options[invCountrySelect.selectedIndex].dataset.invoiceonly;

    if (invoiceonly == 'true') {
        // Country is marked as "invoice only"
        let shippingAddress = document.querySelector('#shippingAddress');
        const style = getComputedStyle(shippingAddress);

        if (style.display === 'none') {
            document.querySelector('#showShipAddress').click();
        }
        document.querySelector('.invoiceonlyhint').classList.remove('hidden');
        document.querySelector('.invoiceonlyhint').style.display = '';
        document.querySelector('#showShipAddress').setAttribute("disabled", "disabled");
    } else {
        // Country is NOT marked as "invoice only"
        document.querySelector('.invoiceonlyhint').classList.add('hidden');
        document.querySelector('.invoiceonlyhint').style.display = 'none';
        document.querySelector('#showShipAddress').removeAttribute("disabled");
    }
};

window.addEventListener("load", function() {
    addSelectEventListener();
}, false );
