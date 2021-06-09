//when changing 'formNames' change its value in homeUtils.php too
// const formNames = ['year', 'sex', 'country', 'region']

const toggleButton = document.getElementsByClassName('toggle-button')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active')
})

// function getCookie(name) {
//     try {
//         return document.cookie.split('; ')
//             .find(row => row.startsWith(name + '='))
//             .split('=')[1]
//     } catch (error) {
//         console.log("Error getting cookies: " +  error)
//         return ""
//     }
// }

// formNames.forEach( element => {
//     let cookieValue = getCookie(element);
//     if (cookieValue !== undefined) {
//         document.getElementById(element).value = cookieValue;
//     }
// })

