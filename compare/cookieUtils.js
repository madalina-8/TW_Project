import CookiesHelper from "../cookies/CookiesHelper.js";

function getValueFromCookie(name) {
    let filter = CookiesHelper.getCookieFilter(name)
    console.log(filter)
    let value = filter?.values?.join(',')
    console.log(value)

    return value
}

export default function updateUIValueFromCookie(optionsID) {
    let options = document.getElementById(optionsID)
    console.log(options)

    let cookieValues = getValueFromCookie(optionsID)

    console.log("cookie value: " + cookieValues)

    if(cookieValues !== undefined && cookieValues.length !== 0) {
        console.log("setting")
        options.valueOf().value = cookieValues
    } else {
        console.log("passing")
        options.value = ""
    }
    console.log(options)
    console.log(options.value)
    // does not update the UI though... ?
}
// updateUIValueFromCookie("year")