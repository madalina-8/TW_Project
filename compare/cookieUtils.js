import CookiesHelper from "../cookies/CookiesHelper.js";

function getValueFromCookie(name) {
    let filter = CookiesHelper.getCookieFilter(name)
    console.log(filter)
    let value = filter?.values?.join(',')
    console.log(value)

    return value
}

function getCompareFromCookie(name) {
    let filter = CookiesHelper.getCookieFilter(name)
    console.log(filter)
    let compare = filter?.compare
    console.log(compare)

    return compare
}

export function updateUIValueFromCookie(optionsID) {
    let options = document.getElementById(optionsID)
    let compare = document.getElementById(optionsID + "Compare")
    console.log(options)

    let cookieValues = getValueFromCookie(optionsID)
    let compareValue = getCompareFromCookie(optionsID)

    console.log("cookie value: " + cookieValues)

    if(cookieValues !== undefined && cookieValues.length !== 0) {
        options.valueOf().value = cookieValues
    } else {
        options.valueOf().value = ""
    }

    if (compareValue !== undefined && compareValue === true) {
        compare.valueOf().checked = true
    }
    console.log(options)
    console.log(options.value)
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
// updateUIValueFromCookie("year")