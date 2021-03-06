import CookiesHelper from "./CookiesHelper.js";

function getValueFromCookie(name) {
    let filter = CookiesHelper.getCookieFilter(name)
    //console.log(filter)
    return filter?.values
    //console.log(value)
}

function getCompareFromCookie(name) {
    let filter = CookiesHelper.getCookieFilter(name)
    //console.log(filter)
    return filter?.compare
    //console.log(value)
}

export function updateUIValueFromCookie(optionsID) {
    let options = document.getElementById(optionsID)
    let shouldCompare = document.getElementById(optionsID + "Compare")
    //console.log(options)
    let cookieValues = getValueFromCookie(optionsID)
    //console.log("cookie value: " + cookieValues)
    if(cookieValues !== undefined && cookieValues.length !== 0) {
        options.valueOf().value = cookieValues
    } else {
        options.value = ""
    }
    if(shouldCompare !== null) {
        shouldCompare.valueOf().checked = (getCompareFromCookie(optionsID) === true)
    }
}

export function updateUICheckBoxFromCookie(checkBoxId) {
    let checkBox = document.getElementById(checkBoxId)

    let checked = CookiesHelper.getCookie(checkBoxId)

    if (checked !== undefined && checked === "off") {
        checkBox.valueOf().checked = false
    } else {
        checkBox.valueOf().checked = true
    }
}