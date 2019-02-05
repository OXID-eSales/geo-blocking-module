# createBasketUserAccountWithoutRegistration
UPDATE `oxconfig` SET `OXVARVALUE` = 0xde         WHERE `OXVARNAME` = 'iNewBasketItemMessage';
UPDATE `oxconfig` SET `OXVARVALUE` = ''           WHERE `OXVARNAME` = 'blDisableNavBars';
REPLACE INTO `oxconfig` (`OXID`, `OXSHOPID`, `OXMODULE`,   `OXVARNAME`,                     `OXVARTYPE`, `OXVARVALUE`) VALUES
                       ('4742', 1, '', 'blPerfNoBasketSaving',          'bool',       0x93ea1218),
                       ('8563fba1965a219c9.51133344', 1, '', 'blUseStock',          'bool',       0x93ea1218);

# createBasketUserAccountWithoutRegistrationTwice
UPDATE `oxcountry` SET `OXACTIVE` = 1 WHERE `OXTITLE_1` = 'Belgium';

#set country, username, password for default user
UPDATE oxuser
  SET
      oxcountryid = 'a7c40f631fc920687.20179984',
      oxusername = 'admin@myoxideshop.com',
      oxpassword = '6cb4a34e1b66d3445108cd91b67f98b9',
      oxpasssalt = '6631386565336161636139613634663766383538633566623662613036636539'
  WHERE OXUSERNAME='admin';
