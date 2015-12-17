// uiHelper
appModule.filter('StoreCurrency',function() {
    return function(amount,currency) {
        console.log(currency);
        if (!isNaN(amount))
            return amount.toString() + ' euro';
        else
            return '';
    };
});