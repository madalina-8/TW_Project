//when changing 'formNames' change its value in compareUtils.php too
import CookiesHelper from '../cookies/CookiesHelper.js'

const formNames = ['year', 'sex', 'country', 'region']
const toggleButton = document.getElementsByClassName('toggle-button')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active')
})
//
// function getCookie(name) {
//     return CookiesHelper.getCookieFilter(name)
// }
//
// formNames.forEach( element => {
//     let filter = getCookie(element);
//     console.log(filter)
//     if (filter !== undefined) {
//         document.getElementById(element).value = filter.currentValue();
//     }
// })
//
