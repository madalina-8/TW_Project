//when changing 'formNames' change its value in compareUtils.php too
const formNames = ['age', 'sex', 'country', 'age2', 'sex2', 'country2']
const toggleButton = document.getElementsByClassName('toggle-button')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

toggleButton.addEventListener('click', () => {
    navbarLinks.classList.toggle('active')
})

function getCookie(name) {
    return document.cookie
        .split('; ')
        .find(row => row.startsWith(name + '='))
        .split('=')[1]
}

formNames.forEach( element => {
    let cookieValue = getCookie(element);
    if (cookieValue !== undefined) {
        document.getElementById(element).value = cookieValue;
    }
})

