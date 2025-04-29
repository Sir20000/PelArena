function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}
const affiliateCode = getQueryParam('affiliate_code');
if (affiliateCode) {
    const affiliateField = document.querySelector('[name="affiliate_code"], #affiliate_code');
    if (affiliateField) {
        affiliateField.value = affiliateCode;
    } else {
        console.warn('Champ affiliate_code introuvable sur la page.');
    }
}