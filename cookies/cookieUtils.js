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
        //console.log("setting")
        options.valueOf().value = cookieValues
    } else {
        //console.log("passing")
        options.value = ""
    }
    //console.log(options)
    //console.log(options.value)
    // does not update the UI though... ?
}
// updateUIValueFromCookie("year")

//Aceasta functie o va inlocui pe cea de sus
//Deoarece avem nevoie de cookie-uri doar pt filtrele curente
//Choicebox-ul initial va fi folosit doar ca sa putem alege aceste filtre
export function updateFiltersFromCookies(optionsID) {
    let choiceBox = document.querySelector('#' + optionsID)
    let cookieValues = getValueFromCookie(optionsID)
    console.log("cookie value: " + cookieValues)
    cookieValues.forEach(cookie => {
        let newOption = new Option(cookie, cookie)
        choiceBox.appendChild(newOption)
    })
}