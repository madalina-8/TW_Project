import CookiesHelper from "./CookiesHelper.js";

function getValueFromCookie(name) {
    let filter = CookiesHelper.getCookieFilter(name)
    //console.log(filter)
    return filter?.values
    //console.log(value)
}

export default function updateUIValueFromCookie(optionsID) {
    let options = document.getElementById(optionsID)
    //console.log(options)
    let cookieValues = getValueFromCookie(optionsID)
    console.log("cookie value: " + cookieValues)
    if(cookieValues !== undefined && cookieValues.length !== 0) {
        options.valueOf().value = cookieValues
    } else {
        options.value = ""
    }
}