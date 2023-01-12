[{$smarty.block.parent}]

[{block name="oegeoblocking_form_user_billing_country"}]
	[{if $oViewConf->getActiveClassName() == 'user' || $oViewConf->getActiveClassName() == 'account_user'}]
		[{foreach from=$oViewConf->getCountryList() item=country key=country_id}]
			[{if $country->oeGeoBlockingIsInvoiceOnly()}]
				[{*Mark with attribute "invoice only" countries.*}]
				[{assign var="scriptToMarkCountryElement" value='$(\'#invCountrySelect option[value="'|cat:$country->oxcountry__oxid->value|cat:'"]\').attr(\'data-invoiceonly\', \'true\');'}]
				[{oxscript add=$scriptToMarkCountryElement}]
				[{*Move message element bellow countries drop down list..*}]
				[{oxscript add='
					$("#userChangeAddress").click(function(){
						var messageElement = $("#oegb-hint-message").detach();
						$("#invCountrySelect").parent().append(messageElement);
					});
				'}]
			[{/if}]
		[{/foreach}]
		[{oxscript include=$oViewConf->getModuleUrl('oegeoblocking','out/js/oegeoblocking.js') priority=11}]
	[{/if}]
[{/block}]
