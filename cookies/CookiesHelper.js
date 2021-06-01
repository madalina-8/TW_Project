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

    static getCookieFilter(cookieName) {
        let string = document.cookie
            .split('; ')
            .find(row => row.startsWith(cookieName + '='))
            .split(cookieName + '=')[1]

        if (string != null) {
            return JSON.parse(string)
        } else {
            return null
        }
    }
}