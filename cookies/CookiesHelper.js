export default class CookiesHelper {

    static setCookieFilter(filter) {
        let expires = ""
        if (days) {
            let date = new Date()
            date.setTime(date.getTime() + (7*24*60*60*1000))
            expires = "; expires=" + date.toUTCString()
        }
        document.cookie = filter.getCookieName() + "=" + (filter.getEncoded() || "")  + expires + "; path=/"
    }

    static getCookie(cookieName) {
        let decoded = decodeURI(document.cookie)
        let replaced = decoded
            .replaceAll("%3A", ':')
            .replaceAll("%2C", ',')

        console.log(replaced)

        let string = replaced
            .split('; ')
            .find(row => row.startsWith(cookieName + '='))
            ?.split(cookieName + '=')[1]

        console.log(string)

        return string
    }

    static getCookieFilter(cookieName) {
        const filterString = this.getCookie(cookieName)

        if (filterString != null) {
            return JSON.parse(filterString)
        } else {
            return null
        }
    }
}