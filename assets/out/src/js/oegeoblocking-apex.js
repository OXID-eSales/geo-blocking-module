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
    console.log(invoiceonly);
    if (invoiceonly == 'true') {
        console.log(1);
        // Country is marked as "invoice only"
        let shippingAddress = document.querySelector('#shippingAddress');
        const style = getComputedStyle(shippingAddress);

        console.log(shippingAddress);
        console.log(style.display === 'none');
        if (style.display === 'none') {
            document.querySelector('#showShipAddress').click();
        }
        document.querySelector('.invoiceonlyhint').classList.remove('hidden');
        document.querySelector('.invoiceonlyhint').style.display = '';
        document.querySelector('#showShipAddress').setAttribute("disabled", "disabled");
    } else {
        console.log(2);
        // Country is NOT marked as "invoice only"
        document.querySelector('.invoiceonlyhint').classList.add('hidden');
        document.querySelector('.invoiceonlyhint').style.display = 'none';
        document.querySelector('#showShipAddress').removeAttribute("disabled");
    }
};

window.addEventListener("load", function() {
    addSelectEventListener();
}, false );
